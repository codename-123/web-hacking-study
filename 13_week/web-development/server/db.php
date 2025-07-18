<?php

$servername = 'localhost';
$dbuser = 'admin';
$dbpassword = 'student1234';
$dbname = 'user';

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpassword);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e){
    echo $e->getMessage();
}

?>
