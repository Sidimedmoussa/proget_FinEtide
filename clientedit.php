<?php
session_start();
include 'admine/connect.php';
if(isset($_SESSION["NOM"])){
    $numvoit = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;

}