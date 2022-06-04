<?php 
session_start();
if(isset($_SESSION["nom"])){
   include 'connect.php';
   $action = (isset($_GET["action"]))? $_GET["action"]: "controle";
   if ($action == "recept"){
       $contID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;

       $prepareQr = $conPDO->prepare("SELECT MATRICULE FROM contrats WHERE NUMCONTRACT= ?"); 
       $prepareQr->execute(array($contID)); 
       $matricule = $prepareQr->fetch();
       $matricule = $matricule["MATRICULE"];
       $prepareQr = $conPDO->prepare("UPDATE voiture SET ETAT = ? WHERE MATRICULE =?"); 
       $prepareQr->execute(array("non",$matricule));
       $prepareQr = $conPDO->prepare("UPDATE contrats SET ETAT = ?,resevoir = ? WHERE  NUMCONTRACT=?"); 
       $prepareQr->execute(array("termine","oui",$contID));
       header("Location: admin.php");
        exit;
   }elseif($action == "regeter"){ // regeter
    $resID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;

    $prepareQr = $conPDO->prepare("DELETE FROM reservation WHERE NUMRESERVATION = ?"); 
    $prepareQr->execute(array($resID));
    header("Location: admin.php");
   }
}else{
    header("Location: index.php");
}