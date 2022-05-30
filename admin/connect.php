<?php

$dsn = 'mysql:host=sql6.freemysqlhosting.net;dbname=sql6496300';
$user = 'sql6496300';
$pass = 'Tyf1HeNgmD';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'You are connected <br>';
} catch (PDOException $e) {
    echo 'Failed to connect ' . $e->getMessage(). '<br>';
}

