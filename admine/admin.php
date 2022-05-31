<?php
 session_start();
 if(isset($_SESSION["nom"])){
    include 'connect.php';
    $prepareQr = $conPDO->prepare("SELECT NUMVOITURE FROM voiture WHERE ETAT ='non'"); 
    $prepareQr->execute(); 
    $voitDisp = $prepareQr-> rowCount();
    $prepareQr = $conPDO->prepare("SELECT * FROM contrats WHERE ETAT ='encour'"); 
    $prepareQr->execute(); 
    $contEncour = $prepareQr-> rowCount();
    $prepareQr = $conPDO->prepare("SELECT * FROM client"); 
    $prepareQr->execute();
    $clientCont = $prepareQr-> rowCount();
    $prepareQr = $conPDO->prepare("SELECT NUMVOITURE FROM voiture"); 
    $prepareQr-> execute(); 
    $voiture = $prepareQr -> rowCount();
    $prepareQr = $conPDO->prepare("SELECT 
                                    cl.*, 
                                    v.MATRICULE ,MODELE,CARBURANT, MARQUE,`IMAGE`,
                                    NUMCONTRACT,passedtime,DATEARRIVET,PRIXLOC,DATEDEPART,duree,typedure
                                    FROM contrats co, client cl, voiture v
                                    WHERE co.NUMCLIENT = cl.NUMCLIENT
                                    AND co.MATRICULE = v.MATRICULE
                                    AND co.ETAT ='encour'"); 
    $prepareQr->execute();
    $contratFromRespet = $prepareQr ->fetchAll();
    $contratFromRespet = array_reverse($contratFromRespet);


    
    include 'html/header.php';
    include 'html/nav.php';
     ?>
    <div class="admin">
       <div class="genrale-infos">
            <div class="stat-info">
                <i class="fa-solid fa-file-contract" style="flex-basis: 40%;font-size: 85px;color: #c90752"></i>
                <div class="stat">
                    <span ><?php echo $contEncour;?></span> contrats encour
                </div>
            </div>
            <div class="stat-info">
                <i class="fa-solid fa-car" style="flex-basis: 40%;font-size: 80px;color: #c90752"></i>
                <div class="stat">
                    <span><?php echo $voitDisp;?></span> voitures disponible
                </div>
            </div>
            <div class="stat-info">
                <i class="fa-solid fa-user" style="flex-basis: 40%;font-size: 80px;color: #c90752"></i>
                <div class="stat">
                    <span><?php echo $clientCont;?></span> Clients
                </div>
            </div>
            <div class="stat-info">
                <i class="fa-solid fa-car-side" style="flex-basis: 40%;font-size: 80px;color: #c90752"></i>
                <div class="stat">
                    <span><?php echo $voiture;?></span> voitures
                </div>
            </div>
       </div>
       <div class="genrale-details">
           <div class="reception">
               <div class="title">reception</div>
               <div class="contrats-encour">
                   <?php if(!empty($contratFromRespet)) {
                       foreach($contratFromRespet as $info){
                           ?>
                   <!-- un seul contract -->
                    <div class="contrat-encour">
                        <div class="cont-detals">
                            <h4>contrat N<sup>o</sup>: <?php if($info["NUMCONTRACT"] < 10){echo "0" . $info["NUMCONTRACT"];}else{echo $info["NUMCONTRACT"];} ?></h4>
                            <div><span>Client : </span> <?php echo $info["NOM"] . " / " . $info["PRENOM"]?> </div>
                            <div><span>voiture : </span><?php echo $info["MATRICULE"] ?> </div>
                        </div>
                        <div class="date-actions">
                            <div class="<?php echo $info["passedtime"];?>">
                                Retour a: </br>
                                <?php echo $info["DATEARRIVET"] ?>
                            </div>
                            <div class="actions">
                                <a href="adminActions.php?action=recept&id=<?php echo $info["NUMCONTRACT"] ?>"><i class="fa-solid fa-circle-down" style="font-size: 23px;color: rgb(20, 212, 20)"></i></a>
                                <div class="ibtn">
                                    <div class="overxm" tduree="<?php echo $info["typedure"]?>" duree="<?php echo $info["duree"]?>" prloc="<?php echo $info["PRIXLOC"]?>" dateret="<?php echo $info["DATEARRIVET"]?>" dateloc="<?php echo $info["DATEDEPART"]?>" carb="<?php echo $info["CARBURANT"]?>" mod="<?php echo $info["MODELE"]?>" mat="<?php echo $info["MATRICULE"]?>" img ="<?php echo "images/voiture/". $info["IMAGE"]?> "permis="<?php echo $info["PERMIS"]?>" adr="<?php echo $info["ADRESSE"]?>" nni="<?php echo $info["NNI"]?>" tel="<?php echo $info["TEL"]?>" cmp-name="<?php echo $info["NOM"] . " / ".$info["PRENOM"]?>" ibtn-info="">
                                    </div>
                                    <i class="fa-solid fa-circle-info" style="cursor: pointer;font-size: 23px;color: grey ;margin:0 10px 0">
                                    </i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } 
                    }else{ ?>
                            <div class="empty"style="width: 100%; text-align: center;">Pas de contrat encour</div>
                   <?php } ?>
               </div>
           </div>
       </div>
        <!-- info btn list -->
        <div class="list-informations-contrat">
            <div class="xmark">
                <div class="overx" xmark-ibtn=""></div>
                <i  class="fa fa-xmark" style="font-size: 25px;cursor: pointer"></i>
            </div>
            <div class="infos-contrat">
            </div>
        </div>
    <?php
    include 'html/footer.php';
 }else{
     header('Location: index.php');
 }