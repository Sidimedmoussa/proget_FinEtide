<?php
session_start();
if(isset($_SESSION["nom"])){
    include "html/header.php";
    include "html/nav.php";
    include "connect.php";
    $action = (isset($_GET["action"]))? $_GET["action"]: "controle";
    if($action == "ajouter"){ // ajouter
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $idClient = $_POST["idclient"];
            $matricule = $_POST["matricule"];
            $dateDepart = date("Y-m-d H:i:s");
           
            $queryvoit = $conPDO -> prepare("SELECT MARQUE,PRIXJOUR,PRIHEURE FROM voiture WHERE MATRICULE = ?");
            $queryvoit -> execute(array($matricule));
            $voiture = $queryvoit -> fetch();
            
            if(isset($_POST["Heurs"])){
                $tmp =  intval($_POST["Heurs"]) + 30;
                $typedure = "Heurs";
                $dateretour = date("Y-m-d H:i:s",strtotime("+ $tmp  hours"));
                $prixLoc = $tmp * $voiture["PRIHEURE"];
            }elseif(isset($_POST["Jours"])){
                $tmp =  intval($_POST["Jours"]);
                $typedure = "Jours";
                $dateretour = date("Y-m-d H:i:s",strtotime("+ $tmp days"));
                $prixLoc = $tmp * $voiture["PRIXJOUR"];
            }elseif(isset($_POST["Mois"])){
                $tmp =  intval($_POST["Mois"]);
                $typedure = "Mois";
                $dateretour = date("Y-m-d H:i:s",strtotime("+ $tmp months"));
                $prixLoc = $tmp * $voiture["PRIXJOUR"] * 30;
            }
            $query = $conPDO -> prepare("INSERT INTO contrats (NUMCLIENT,MATRICULE, DATEDEPART, DATEARRIVET,PRIXLOC,ETAT,duree,typedure)
                                       VALUES (?,?,?,?,?,?,?,?)");
            $query -> execute(array($idClient,$matricule,$dateDepart,$dateretour,$prixLoc,"encour",$tmp,$typedure));
            $query = $conPDO -> prepare("UPDATE voiture SET ETAT = ? WHERE MATRICULE = ?");
            $query -> execute(array("oui",$matricule));
            header("Location: contract.php");
            exit;
        }
        $queryvoit = $conPDO -> prepare("SELECT * FROM voiture WHERE ETAT = ?");
        $queryvoit -> execute(array("non"));
        $querycl = $conPDO -> prepare("SELECT * FROM client");
        $querycl -> execute();
            ?>
<div class="wrapper">
    <form action="?action=ajouter" method="POST">
        <div class="form">
            <div class="clientlist">
                    <div class="add-nouvau-client">
                    <a href="clientactions.php?action=ajoute&from=clientcontract"><i class="fa-solid fa-user-plus"></i></a>
                    <div class="client-list-xmark"><i class="fa fa-xmark"></i></div>
                    </div>
                    <?php while($client = $querycl -> fetch()){ ?>
                    <div class="clientdetails">
                            <div><label>Nom Complet: </label><?php echo " ".$client["NOM"]." / ".$client["PRENOM"];?></div>
                            <div><label>TEL: </label><?php echo " ".$client["TEL"];?></div>
                            <div><label>NNI: </label><?php echo " ".$client["NNI"];?></div>
                            <div><label>Adresse: </label><?php echo " ".$client["ADRESSE"];?></div>
                            <div><label>Permis: </label><?php echo " ".$client["PERMIS"];?></div>
                            <div class="over" data-id="<?php echo $client["NUMCLIENT"];?>"></div>
                    </div>
                    <?php } ?>
            </div>
            <div class="inputfield">
                <label>CLIENT</label>
                <div class="selclient" >Selectionner le client</div>
            </div>  
            <div class="selectvoit">
                <div class="voit-list-xmark">
                <div class="voit-xmark"><i class="fa fa-xmark" style="cursor: pointer"></i></div>
                </div>
                <?php while($voit = $queryvoit->fetch()){ ?>
                <div class="voitcontdetail">
                    <div class="carimage" ><img src="<?php echo "images/voiture/" .  $voit["IMAGE"];?>" alt=""></div>
                    <div class="details" >
                        <span><?php echo $voit["MATRICULE"];?></span>
                        <span><?php echo $voit["MODELE"];?></span>
                        <span><?php echo $voit["MARQUE"];?></span>
                        <span><?php echo $voit["CARBURANT"];?></span>
                        <span><?php echo $voit["PRIXJOUR"] . " UM/JOUR";?></span>
                        <span><?php echo $voit["PRIHEURE"] . " UM/HEURE";?></span>
                        <div class="over" data-matricule="<?php echo $voit["MATRICULE"];?>"></div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="inputfield">
                <label>VOITURE</label>
                <div class="selvoit" >Selectionner une voiture</div>
            </div> 
            <div class="inputfield">
                <label>DURET</label>
                <div class="tmp">
                    <span data-tmp = "Heurs">Par heurs</span>
                    <span data-tmp = "Jours">Par Jours</span>
                    <span data-tmp = "Mois">Par Mois</span>
                </div>       
            </div>  
            <div class="inputfield">
                    <input type="submit" value="Ajouter" class="btn">
                    <a href="contract.php" class="btn" style="margin-left: 5px;">Anuler</a>
            </div>
        </div>
    </form>
</div>
<?php } //end ajouter 
    elseif($action == 'sup'){ //suprimer
        $contID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
        $query = $conPDO -> prepare("DELETE FROM contrats WHERE NUMCONTRACT = ?");
        $query -> execute(array($contID));
        header("location: contract.php");
    }elseif($action == "archive"){ // archive
        $contratID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
        $query = $conPDO -> prepare("UPDATE contrats SET archived = ? WHERE NUMCONTRACT = ?");
        $query -> execute(array("oui",$contratID));
        header("Location: contract.php");
    }elseif($action == "editer"){ // editer
        $contratID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
        $query = $conPDO -> prepare("SELECT * FROM contrats WHERE NUMCONTRACT = ?");
        $query -> execute(array($contratID));
        $contract = $query -> fetch();
        
        $clientID = intval($contract["NUMCLIENT"]);
        $querycl = $conPDO -> prepare("SELECT * FROM client WHERE NUMCLIENT = ?");
        $querycl -> execute(array($clientID));
        $client = $querycl -> fetch();
        
        $queryfrlist = $conPDO -> prepare("SELECT * FROM client ");
        $queryfrlist -> execute();

        $voitureID =$contract["MATRICULE"];
        $queryvoit = $conPDO -> prepare("SELECT * FROM voiture WHERE MATRICULE = ?");
        $queryvoit -> execute(array($voitureID));
        $voit = $queryvoit -> fetch();

        $queryvoitlist = $conPDO -> prepare("SELECT * FROM voiture WHERE ETAT = ?");
        $queryvoitlist -> execute(array("non"));
        ?>
        <!-- client list for edit -->
        <div class="clientlist-from-edit"> 
                    <div class="add-nouvau-client-from-edit">
                    <a href="clientactions.php?action=ajoute&from=fromcontratedit"><i class="fa-solid fa-user-plus"></i></a>
                    <div class="client-list-xmark"><i class="fa fa-xmark"></i></div>
                    </div>
                    <?php while($clientFromList = $queryfrlist -> fetch()){ ?>
                    <div class="clientdetails">
                            <div><label>Nom Complet: </label><?php echo " ".$clientFromList["NOM"]." / ".$clientFromList["PRENOM"];?></div>
                            <div><label>TEL: </label><?php echo " ".$clientFromList["TEL"];?></div>
                            <div><label>NNI: </label><?php echo " ".$clientFromList["NNI"];?></div>
                            <div><label>Adresse: </label><?php echo " ".$clientFromList["ADRESSE"];?></div>
                            <div><label>Permis: </label><?php echo " ".$clientFromList["PERMIS"];?></div>
                            <div class="over" NNI="<?php echo " ".$clientFromList["NNI"];?>" prm="<?php echo " ".$clientFromList["PERMIS"];?>" adr="<?php echo " ".$clientFromList["ADRESSE"];?>" tel="<?php echo " ".$clientFromList["TEL"];?>" data-id-edit="<?php echo $clientFromList["NUMCLIENT"];?>" name="<?php echo " ".$clientFromList["NOM"]." / ".$clientFromList["PRENOM"];?>"></div>
                    </div>
                    <?php } ?>                                                                                              
            </div>
            <!--  end client list for edit -->

            <!--  voitue list for edit -->
            <div class="voitlist-from-edit">
                <div class="voit-list-xmark-edit">
                <div class="voit-xmark"><i class="fa fa-xmark" style="cursor: pointer"></i></div>
                </div>
                <?php while($voiture = $queryvoitlist->fetch()){ ?>
                <div class="voitcontdetail">
                    <div class="carimage" ><img src="<?php echo "images/voiture/" .  $voiture["IMAGE"];?>" alt=""></div>
                    <div class="details" >
                        <span><?php echo $voiture["MATRICULE"];?></span>
                        <span><?php echo $voiture["MODELE"];?></span>
                        <span><?php echo $voiture["MARQUE"];?></span>
                        <span><?php echo $voiture["CARBURANT"];?></span>
                        <span><?php echo $voiture["PRIXJOUR"] . " UM/JOUR";?></span>
                        <span><?php echo $voiture["PRIHEURE"] . " UM/HEURE";?></span>
                        <div class="overedit" img="<?php echo "images/voiture/" .  $voiture["IMAGE"];?>" prh="<?php echo $voiture["PRIHEURE"] . " UM/HEURE";?>" prj="<?php echo $voiture["PRIXJOUR"] . " UM/JOUR";?>" carb="<?php echo $voiture["CARBURANT"];?>" mq="<?php echo $voiture["MARQUE"];?>" mod="<?php echo $voiture["MODELE"];?>" data-matricule-edit="<?php echo $voiture["MATRICULE"];?>"></div>
                    </div>
                    
                </div>
                <?php } ?>
            </div>
            <!--  end voitue list for edit -->
            <br><br><br><br>
    <form action="?action=update" method="POST">
    <input type="hidden" value="<?php echo $contract["MATRICULE"]?>" name="oldvoitmat"> 
     <input type="hidden" value="<?php echo $contract["NUMCONTRACT"]?>" name="contratID">
        <div class="edit-contrat"> 
            <div class="client-voiture">
                <div class="client">
                    <div><label>Nom Complet: </label><?php echo " ".$client["NOM"]." / ".$client["PRENOM"];?></div>
                    <div><label>TEL: </label><?php echo " ".$client["TEL"];?></div>
                    <div><label>NNI: </label><?php echo " ".$client["NNI"];?></div>
                    <div><label>Adresse: </label><?php echo " ".$client["ADRESSE"];?></div>
                    <div><label>Permis: </label><?php echo " ".$client["PERMIS"];?></div>
                    <input type="hidden" value="<?php echo $client["NUMCLIENT"]?>" name="clientID">
                    <div class="overedit"></div>
                </div>
                <div class="voiture">
                    <div class="carimage" ><img src="<?php echo "images/voiture/" .  $voit["IMAGE"];?>" alt=""></div>
                    <div class="details">
                        <span><?php echo $voit["MATRICULE"];?></span>
                        <span><?php echo $voit["MODELE"];?></span>
                        <span><?php echo $voit["MARQUE"];?></span>
                        <span><?php echo $voit["CARBURANT"];?></span>
                        <span><?php echo $voit["PRIXJOUR"] . " UM/JOUR";?></span>
                        <span><?php echo $voit["PRIHEURE"] . " UM/HEURE";?></span>
                        <div class="overedit"></div>
                        <input type="hidden" value="<?php echo $voit["MATRICULE"]?>" name="matricule">
                        <input type="hidden" value="<?php echo $voit["PRIXJOUR"]?>" name="prixJ">
                        <input type="hidden" value="<?php echo $voit["PRIHEURE"]?>" name="prixH">
                    </div>
                </div>
            </div>
            <div class="contract-info">
                <div>
                    <div class="input">
                        <label>Date De Location</label>
                        <input type="datetime-local" name="datedepart" value="<?php echo date("Y-m-d\TH:i",strtotime($contract["DATEDEPART"]))?>">
                    </div>
                    <div class="input">
                        <label>Date De Retour</label>
                        <div><input type="datetime-local" readonly name="dateretour" value="<?php echo date("Y-m-d\TH:i",strtotime($contract["DATEARRIVET"]))?>"></div>
                    </div>
                </div>
                <div>
                    <div class="input">
                        <label>Prix De Location</label>
                        <input type="text" readonly value="<?php echo $contract["PRIXLOC"] . " UM"?>">
                    </div>
                    <div class="input">
                        <label>Duree</label>
                        <div class="dure-sel">
                            <input type="text" name="duree" value="<?php echo $contract["duree"]?>">
                            <div class="custom_select">
                                <select name="typeduree" id="">
                                    <option value="<?php echo $contract["typedure"];?>"><?php echo $contract["typedure"];?></option>
                                    <option value="Heures">Heures</option>
                                    <option value="Jours">Jours</option>
                                    <option value="Mois">Mois</option>
                                </select> 
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="btn-class">
                <div class="inputfield">
                    <input type="submit" value="Editer" class="btn">
                </div>
                <div class="inputfield">
                    <input type="reset" value="reinitialiser" class="btn">
                </div>
                <div class="inputfield">
                    <a href="#" class="btn">Anuler</a>
                </div>
            </div>
        </div>
    </form>
        <?php
    }elseif($action == "update"){ // UPDATE page
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $contratID  = $_POST["contratID"];
            $clientID   = $_POST["clientID"];
            $oldvoitmat = $_POST["oldvoitmat"];
            $newvoitmat  = $_POST["matricule"];
            $dateDepart = $_POST["datedepart"];
            $duree      = intval($_POST["duree"]);
            $typeduree  = $_POST["typeduree"];
            $prixH      = intval($_POST["prixH"]);
            $prixJ      = intval($_POST["prixJ"]);
            if($typeduree == "Heures"){
                $prixLoc    = $duree * $prixH;
                $dateretour = date("Y-m-d H:i:s",strtotime("$dateDepart + $duree  hours"));
            }elseif($typeduree == "Jours"){
                $prixLoc = $duree * $prixJ;
                $dateretour = date("Y-m-d H:i:s",strtotime("$dateDepart + $duree  days"));
            }else{
                $prixLoc = $duree * $prixJ * 30;
                $dateretour = date("Y-m-d H:i:s",strtotime("$dateDepart + $duree  months"));
            }
            echo "old: ".$oldvoitmat. " new: " . $newvoitmat;
            if( $newvoitmat !== $oldvoitmat ){
                $matricule = $newvoitmat;
                $query = $conPDO -> prepare("UPDATE voiture SET ETAT = ? WHERE MATRICULE = ?");
                $query -> execute(array("oui",$matricule));
                $query = $conPDO -> prepare("UPDATE voiture SET ETAT = ? WHERE MATRICULE = ?");
                $query -> execute(array("non",$oldvoitmat));
            }else{
                $matricule = $oldvoitmat;
            }
            $query = $conPDO -> prepare("UPDATE contrats SET  
                                                NUMCLIENT = ?,
                                                MATRICULE = ?,
                                                DATEDEPART =?,
                                                DATEARRIVET =?,
                                                PRIXLOC =?,
                                                duree =?,
                                                typedure =?
                                         WHERE NUMCONTRACT = ?");
            $query -> execute(array($clientID, 
                                    $matricule, 
                                    $dateDepart,
                                    $dateretour, 
                                    $prixLoc, 
                                    $duree, 
                                    $typeduree, 
                                    $contratID));
            
        header("Location: contract.php");
        exit;
    }

    }
    include "html/footer.php";
} else{
    header("Location: index.php");
}