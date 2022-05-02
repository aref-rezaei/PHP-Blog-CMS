<?php

$Option = [
    PDO::ATTR_PERSISTENT => TRUE,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

try {

    $con = new PDO('mysql:host=localhost;dbname=php_blog;charset=utf8', 'root', '');

} catch (PDOException $error) {
    
    echo 'Error' . $error->getMessage();
}