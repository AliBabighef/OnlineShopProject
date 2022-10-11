<?php

$dbSrc = "mysql:host=localhost;dbname=ecommerce";
$user = 'root';
$pass = '';
$option = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',

);


try {

    $con = new PDO($dbSrc, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOExeception $e) {

    echo 'not connect' . $e->getMessage();
}
