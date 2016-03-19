/*
1. Написать миграцию для создания структуры БД. +
2. Написать запрос для добавления нового пользователя/альбома/фотографии. +
3. Написать 2 скрипта: первый присылает запрос на добавления в друзья, второй подтверждает инвайт. + +
4. Написать запрос для демонстрации 5й страницы любого вашего альбома. +
5. Вывод списка альбомов ваших друзей. +
6. Написать запрос для изменения имени пользователя/названия альбома/перевод фотографии в приватный режим. +
7. Написать запрос который удалит все ваши приватные фотографии из чужих альбомов. +
8. Написать скрипт удаляющий все фотографии без альбома. +
9. Написать запрос, выводящий 2 колонки: 1 — фотография, 2 — пользователь, который может смотреть фтографию. +
10. Расставить индексы для максимальной производительности БД на всех запросах SELECT. +
*/

/*  type в таблице 'relationship' может принимать следующие значения:
    0 - Пользователи дружат друг с другом
    1 - Пользователь (user) подписан на пользователя (friend)
    2 - Пользователь (friend) подписан на пользователя (user)
*/

#2 Написать запрос для добавления нового пользователя/альбома/фотографии
INSERT INTO `user` VALUES (1,'login','password','Sasha','Ivanov','sasha@gmail.com');
INSERT INTO `photo` VALUES('1','Name of photo','1');
INSERT INTO `album` VALUES (1,1,'Name of album');


#3 Написать 2 скрипта: первый присылает запрос на добавления в друзья, второй подтверждает инвайт.
INSERT INTO `relationship`(`id`,`user`,`friend`,`type`) VALUES('4','1','2','1');
UPDATE `relationship` SET `type`=0 WHERE `user`=1 AND `friend`=2;


#4 Написать запрос для демонстрации 5й страницы любого вашего альбома.
SELECT p.`name`  'Photo name', a.`name`  'Album name'
FROM  `photo` p,  `album` a,  `album_to_photo` t
WHERE p.id = t.id_photo
  AND a.id = t.id_album
  AND a.id =  '1'
LIMIT 50 , 10;


#5 Вывод списка альбомов ваших друзей.
SELECT u.`id` , 
  CONCAT( u.`firstname` ,  ' ', u.`surname` )  'Friend name', 
  CONCAT(  '(', p.`id` ,  ') ', p.`name` )  '(#) Photo name', 
  CONCAT(  '(', a.`id` ,  ') ', a.`name` ) '(#) Album name'
FROM  `album_to_photo` t,  `album` a,  `user` u,  `relationship` r,  `photo` p
WHERE p.id = t.id_photo
  AND a.id = t.id_album
  AND a.id_user = u.id
  AND u.id !=  '3'
  AND ((r.user =  '3'AND r.friend = u.id) OR (r.friend =  '3'AND r.user = u.id))
  AND r.type =  '0';


#6 Написать запрос для изменения имени пользователя/названия альбома/перевод фотографии в приватный режим.
UPDATE `user` SET `firstname`='Sasha2' WHERE `id`=3;
UPDATE `album` SET `name`='My friends2' WHERE `id`=1;
UPDATE `photo` SET `access`='0' WHERE `id`=1;

#7 Написать запрос который удалит все ваши приватные фотографии из чужих альбомов.
DELETE FROM album_to_photo WHERE id IN 
(
  SELECT id
  FROM
  (SELECT t.*
  FROM  `album_to_photo` t,  `album` a,  `user` u, `photo` p
  WHERE p.id = t.id_photo
    AND a.id = t.id_album
    AND a.id_user = u.id
    AND a.id_user <> 1
    AND p.access = 0
    AND p.id_user = 1
  ) as `tmptable`
);

#8 Написать скрипт удаляющий все фотографии без альбома.
DELETE FROM photo
WHERE id NOT IN (
  SELECT id_photo
  FROM album_to_photo
)

#9 Написать запрос, выводящий 2 колонки: 1 — фотография, 2 — пользователь, который может смотреть фотографию.
SELECT p.name, CONCAT( u.`firstname` ,  ' ', u.`surname` )  'Name of person'
FROM photo p
INNER JOIN user u 
ON p.id_user = u.id
WHERE p.access = 0
UNION
SELECT p.name, CONCAT( u.`firstname` ,  ' ', u.`surname` )  'Name of person'
FROM photo p
INNER JOIN user u
WHERE p.access = 1
LIMIT 30