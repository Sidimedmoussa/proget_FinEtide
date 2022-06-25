<?php 
session_start();
if(isset($_SESSION["nom"])){ 
   include 'connect.php';
   $action = (isset($_GET["action"]))? $_GET["action"]: "controle";

   if($action == "afterRecept"){ //after reseption
    $contID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]) : 0;
    $prepareQr = $conPDO->prepare("SELECT 
                                    cl.*, 
                                    v.*,
                                    NUMCONTRACT,passedtime,DATEARRIVET,PRIXLOC,DATEDEPART,duree,typedure
                                    FROM contrats co, client cl, voiture v
                                    WHERE co.NUMCLIENT = cl.NUMCLIENT
                                    AND co.MATRICULE = v.MATRICULE
                                    AND NUMCONTRACT = ?"); 
    $prepareQr->execute(array($contID));
    $contratFromRespet = $prepareQr ->fetch();
   include "html/header.php";
?>
<form action="adminActions.php?action=recept" method="post">
    <input type="hidden" name="num-cont" value="<?php echo $contratFromRespet["NUMCONTRACT"]?>">
    <div class="rervation-preparation">
            <div class="client-voiture">
                <div class="client">
                    <div><label>Nom Complet: </label><?php echo $contratFromRespet["NOM"] ." / ".$contratFromRespet["PRENOM"]?></div>
                    <div><label>TEL: </label><?php echo $contratFromRespet["TEL"]?></div>
                    <div><label>NNI: </label><?php echo $contratFromRespet["NNI"]?></div>
                    <div><label>Adresse: </label><?php echo $contratFromRespet["ADRESSE"]?></div>
                    <div><label>Permis: </label><?php echo $contratFromRespet["PERMIS"]?></div>
                </div>   
                <div class="voiture">
                    <div class="carimage" ><img src="images/voiture/<?php echo $contratFromRespet["IMAGE"]?>" alt=""></div>
                    <div class="details" >
                    <span><?php echo $contratFromRespet["MATRICULE"]?></span>
                    <span><?php echo $contratFromRespet["MODELE"]?></span>
                    <span><?php echo $contratFromRespet["CARBURANT"]?></span>
                    <span ><?php echo $contratFromRespet["PRIHEURE"]?> / Heure</span>
                    <span><?php echo $contratFromRespet["PRIXJOUR"]?> / Joure</span>
                    </div>
                </div>
            </div>
            <div class="location-info">
                <div class="date-loc">
                        <div class="date"><span style='font-weight: bold'>Duree: </span><?php echo $contratFromRespet["duree"] .  $contratFromRespet["typedure"]?></div>
                        <div class="date"><span style='font-weight: bold'>De: </span><?php echo $contratFromRespet["DATEDEPART"] ?></div>
                        <div class="date"><span style='font-weight: bold'>A: </span><?php echo $contratFromRespet["DATEARRIVET"] ?></div>
                        <div class="date"><span style='font-weight: bold'>Montant: </span><?php echo $contratFromRespet["PRIXLOC"] . "UM" ?></div>
                </div>
                <div class="carb-info">
                     <div class="carb-prog">
                        <p>
                            <span style="transform: rotate(<?php echo 1.8 * $contratFromRespet["CARBURANTPROG"] + 135 ?>deg)"></span>
                            <small><?php echo $contratFromRespet["CARBURANTPROG"]?>%</small>
                        </p>
                        <input type="range" name="carb-reng" value="<?php echo 1.8 * $contratFromRespet["CARBURANTPROG"] + 135 ?>" id="max" min="135" max="315">
                     </div>
                </div>
            </div>    
            <div class="form">
                <div class="fields">
                    <div class="input">
                        <label>Prix de depannage</label>
                        <input type="number" name="prix-dep">
                    </div>
                    <div class="input">
                        <label >Date de reception</label>
                        <input type="datetime-local" name="res-date" value="<?php echo date("Y-m-d\TH:i",strtotime($contratFromRespet["DATEARRIVET"]))?>">
                    </div>
                </div>
               <div class="btn-class">
                    <div class="inputfield">
                        <input type="submit" value="Recevoir" class="btn">
                    </div>
                    <div class="inputfield">
                        <input type="reset" value="reinitialiser" class="btn">
                    </div>
                    <div class="inputfield">
                        <a href="admin.php" class="btn">Anuler</a>
                    </div>
               </div>
            </div>
    </div>
</form>


<?php
include "html/footer.php";

   }elseif ($action == "recept"){ //reception
       if($_SERVER['REQUEST_METHOD'] == "POST"){
        $numContract = $_POST["num-cont"];
        $carbReng    = $_POST["carb-reng"];
        $prixDep     = $_POST["prix-dep"];
        $dateRec     = $_POST["res-date"];
        $depan = (empty($prixDep))? "non": "oui";
        $prepareQr = $conPDO->prepare("SELECT MATRICULE FROM contrats WHERE NUMCONTRACT= ?"); 
        $prepareQr->execute(array($numContract)); 
        $matricule = $prepareQr->fetch();
        $matricule = $matricule["MATRICULE"];

        $prepareQr = $conPDO->prepare("UPDATE voiture SET depannage = ?, ETAT = ? WHERE MATRICULE =?"); 
        $prepareQr->execute(array($depan,"non",$matricule));

        $prepareQr = $conPDO->prepare("UPDATE contrats SET DETEDERESEPTION = ?, PRIXDEP = ?, ETAT = ?,resevoir = ? WHERE  NUMCONTRACT=?"); 
        $prepareQr->execute(array($dateRec,$prixDep,"termine","oui",$numContract));
        header("Location: factureActions.php?action=print&id=$numContract");
       }
     exit;
   }elseif($action == "regeter"){ // regeter
    $resID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;

    $prepareQr = $conPDO->prepare("DELETE FROM reservation WHERE NUMRESERVATION = ?"); 
    $prepareQr->execute(array($resID));
    header("Location: admin.php");

   }elseif($action == "ajouter"){// ajouter
    $resID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
    $query = $conPDO -> prepare("SELECT * FROM reservation WHERE NUMRESERVATION = ?");
    $query -> execute(array($resID));
    $resInfo = $query -> fetch();

    $idClient   = $resInfo["CLIENT"];
    $matricule  = $resInfo["VOITURE"];
    $dateDepart = $resInfo["DATERESS"];
    $dateretour = $resInfo["DATERETOUR"];
    $typedure   = $resInfo["TYPEDUREE"];
    $tmp        = $resInfo["DUREE"];
    $query = $conPDO -> prepare("SELECT PRIXJOUR,PRIHEURE FROM voiture WHERE MATRICULE = ?");
    $query -> execute(array($matricule));
    $voiture = $query -> fetch();
    if($typedure == "heure"){
        $typedure = "Jours";
        $prixLoc = $tmp * $voiture["PRIHEURE"];
    }elseif($typedure == "jour"){
        $typedure = "Jours";
        $prixLoc = $tmp * $voiture["PRIXJOUR"];
    }elseif($typedure =="mois"){
        $typedure = "Mois";
        $prixLoc = $tmp * $voiture["PRIXJOUR"] * 30;
    }
    $query = $conPDO -> prepare("INSERT INTO contrats (NUMCLIENT,MATRICULE, DATEDEPART, DATEARRIVET,PRIXLOC,ETAT,duree,typedure)
                                VALUES (?,?,?,?,?,?,?,?)");
    $query -> execute(array($idClient,$matricule,$dateDepart,$dateretour,$prixLoc,"encour",$tmp,$typedure));
    $prepareQr = $conPDO->prepare("DELETE FROM reservation WHERE NUMRESERVATION = ?"); 
    $prepareQr->execute(array($resID));
    $query = $conPDO -> prepare("UPDATE voiture SET ETAT = ? WHERE MATRICULE = ?");
            $query -> execute(array("oui",$matricule));
    header("Location: admin.php");
    exit;
  }elseif($action == "fixed"){
    $numvoit = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
    $query = $conPDO -> prepare("UPDATE voiture SET depannage = ? WHERE NUMVOITURE = ?");
    $query -> execute(array("non",$numvoit));
    header("Location: admin.php");
  }
}else{
    header("Location: index.php");
}