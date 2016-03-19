<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


$app->contentType('application/json');
$db = new PDO('sqlite:db2.sqlite3');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$app->get('/install', function () use ($db) {
    $db->exec('  CREATE TABLE IF NOT EXISTS users (
                    id INTEGER PRIMARY KEY,
                    firstname TEXT NOT NULL,
                    surname TEXT NOT NULL,
                    email TEXT,
                    databirth TEXT);
                  CREATE TABLE IF NOT EXISTS phone_number (
                    id INTEGER PRIMARY KEY,
                    phone TEXT NOT NULL,
                    pseudo TEXT NOT NULL,
                    notes TEXT,
                    user INTEGER); ');
    returnResult('install');
});


$app->post('/user', function () use ($db, $app) {
            
    $sth = $db->prepare('INSERT INTO users (firstname, surname,email,databirth) VALUES (?, ?,?,?);');
    $sth->execute([
        $app->request()->post('firstname'),
        $app->request()->post('surname'),
        $app->request()->post('email'),
        $app->request()->post('databirth')       
    ]);

    returnResult('add', $sth->rowCount() == 1, $db->lastInsertId());
});

$app->get('/users', function () use ($db, $app) {
    $sth = $db->query('SELECT id,firstname,surname FROM users;');
    echo json_encode($sth->fetchAll(PDO::FETCH_CLASS));
});


$app->get('/user/:id', function ($id) use ($db, $app) {
   
    $sth = $db->prepare('SELECT * FROM users WHERE id = ?;');
    $sth->execute([intval($id)]);
    $data=$sth->fetchAll(PDO::FETCH_CLASS);
    
    $sth = $db->prepare('SELECT phone,notes FROM phone_number WHERE user = ?;');
    $sth->execute([intval($id)]);
    if ($data) $data[0]->phones=$sth->fetchAll(PDO::FETCH_CLASS); 
    
    if ($data) echo json_encode($data[0]);
    else returnResult('get', 0, $id,'User not found');
});


$app->put('/user/:id', function ($id) use ($db, $app) {
    $sth = $db->prepare('UPDATE users SET firstname = ?, surname = ? WHERE id = ?;');
    $sth->execute([
        $app->request()->post('firstname'),
        $app->request()->post('surname'),
        intval($id)
    ]);

    returnResult('edit', $sth->rowCount() == 1, $id);
});

$app->delete('/user/:id', function ($id) use ($db) {
    
    $sth = $db->prepare('DELETE FROM phone_number WHERE user = ?;');
    $sth->execute([intval($id)]);
    
    
    $sth = $db->prepare('DELETE FROM users WHERE id = ?;');
    $sth->execute([intval($id)]);

    returnResult('delete', $sth->rowCount() == 1, $id);
});


$app->post('/user/:id/phone', function ($id) use ($db, $app) {
        
    $sth = $db->prepare('SELECT * FROM phone_number WHERE user = ? AND pseudo = ? LIMIT 1;');
    $sth->execute([intval($id),$app->request()->post('pseudo')]);
    $data=$sth->fetchAll(PDO::FETCH_CLASS);
    if ($data) {
        returnResult('add', 0, $id, 'Phone with this pseudo exists');   
    } else {
        $sth = $db->prepare('INSERT INTO phone_number (phone, pseudo,notes,user) VALUES (?, ?,?,?);');
        $sth->execute([
            $app->request()->post('phone'),
            $app->request()->post('pseudo'),
            $app->request()->post('notes'),
            intval($id)   
        ]);

        returnResult('add', $sth->rowCount() == 1, $db->lastInsertId());
    }
});


$app->get('/user/:id/phone', function ($id) use ($db, $app) {
    $sth = $db->prepare('SELECT phone,pseudo FROM phone_number WHERE user = ?;');
    $sth->execute([intval($id)]);
    $data=$sth->fetchAll(PDO::FETCH_CLASS);
    if ($data) echo json_encode($data);
    else returnResult('get', 0, $id,'Phones not found');
});

$app->get('/user/:id/phone/:pseudo', function ($id,$pseudo) use ($db, $app) {
    
    $sth = $db->prepare('SELECT phone,pseudo,notes FROM phone_number WHERE user = ? AND pseudo = ?;');
    $sth->execute([intval($id),$pseudo]);
    $data=$sth->fetchAll(PDO::FETCH_CLASS);
    if ($data) echo json_encode($data);
    else returnResult('get', 0, $id,'Phones with this pseudo not found');
});



$app->put('/user/:id/phone/:pseudo', function ($id,$pseudo) use ($db, $app) {
    $sth = $db->prepare('UPDATE phone_number SET phone = ? WHERE user = ? AND pseudo = ?;');
    $sth->execute([
        $app->request()->post('phone'),
        intval($id),
        $pseudo
    ]);

    returnResult('edit', $sth->rowCount() == 1, $id);
});

$app->delete('/user/:id/phone/:pseudo', function ($id,$pseudo) use ($db) {
    $sth = $db->prepare('DELETE FROM phone_number WHERE user = ? AND pseudo=?;');
    $sth->execute([intval($id),$pseudo]);

    returnResult('delete', $sth->rowCount() ==1, $id);
});


function returnResult($action, $success = true, $id = 0,$message="")
{
    echo json_encode([
        'action' => $action,
        'success' => $success,
        'id' => intval($id),
        'message' => $message,
    ]);
}

$app->run();