<?php

$dsn = "mysql: host=localhost;dbname=gesvoiture"; //data sourse name
$user = "root";
$pwd = "";
$opt = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
);
try {
    $conPDO = new PDO($dsn,$user,$pwd,$opt);
    $conPDO -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e ){
    echo "ERROR: ". $e -> getMessage();
}