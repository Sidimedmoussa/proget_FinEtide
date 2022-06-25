<?php 
session_start();
if(isset($_SESSION["nom"])){ 
   include 'connect.php';
   $action = (isset($_GET["action"]))? $_GET["action"]: "controle";

   if($action == "print"){ 
    include "html/header.php";
    include "html/nav.php";
    $contID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]) : 0;
    $prepareQr = $conPDO->prepare("SELECT 
       NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM,cl.PRENOM,co.PRIXDEP
     FROM contrats co, voiture v ,client cl 
     WHERE co.MATRICULE = v.MATRICULE
     AND co.NUMCLIENT = cl.NUMCLIENT 
     AND NUMCONTRACT = ?");
     $prepareQr->execute(array($contID));
     $fact = $prepareQr -> fetch();
    ?>
    <div class="recue">
        <div class="recue-content">
           <div class="logo-contact">
               <span class="num-fact">
                <span style="font-weight: bold">N<sup>o</sup>: <?php echo $fact["NUMCONTRACT"] ?></span>
               </span>
               <span class="logo">
                <img src="images/logotoprint.png" alt="">
                </span>
                <span class="contact">
                    +222 41 74 70 47
                </span>
           </div>
           <div class="fact-details">
               <div class="loyer"><label>Nom Complet:</label> <?php echo $fact["NOM"] . " / " . $fact["PRENOM"]?></div>
               <div class="voit">
                   <span><label>Matricule De Voiture: </label>  <?php echo $fact["MATRICULE"] ?></span>
                   <span><label>Marque: </label> <?php echo $fact["MARQUE"] ?></span>
               </div>
               <div class="date">
                   <span><label>De: </label> <?php echo $fact["DATEDEPART"] ?></span>
                   <span><label>A: </label> <?php echo $fact["DATEARRIVET"] ?></span>
               </div>
               <div class="prix"> 
                   <label >Montant:</label><span><?php echo " " . $fact["PRIXLOC"] ?>UM</span>
               </div>
               <div class="prix"> 
                   <label >Montant Final:</label><span><?php echo " " . $fact["PRIXLOC"] + $fact["PRIXDEP"] ?>UM</span>
               </div>
           </div>
           <div class="date-now"><?php echo date("d/m/Y") ?></div>
        </div> 
        <button onclick="print()">Imprimer</button>
    </div>
    <?php
    include "html/footer.php";
}
}