<?php
require_once "iDbConnectable_interface.php";
require_once "database_class.php";

$attributes = array('id' => 4,'login' => "one",'password' => "one",'firstname' => "one",'surname' => "one",'email' => "one");

//create new object of class DbConnectable
$user = new DbConnectable('user',$attributes);

$user->save(); //create (insert) new user
$user->login="two2"; //change login
$user->save(); //update user
$user->findByPk(1); //find user with id=1
echo "<strong>Find user with id=1</strong><br>";
echo "Firstname and surname: ".$user->firstname." ".$user->surname."<br>";
echo "Login: ".$user->login."<br>";

$result=$user->where('id','1','album');
//echo "<pre>"; print_r($result); echo "</pre>";
echo "<pre>"; print_r($result[0]->album[1]); echo "</pre>";