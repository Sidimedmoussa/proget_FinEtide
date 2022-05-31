<?php
     session_start();
     if(isset($_SESSION["nom"])){
      include "html/header.php";
      include "connect.php"; 
      include "html/nav.php";
 
      $action = (isset($_GET["action"]))? $_GET["action"]: "controle";
      
      if($action == "ajouter"){ //ajouter page
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $matricule         = strtoupper($_POST["matricule"]);
            $marque            = $_POST["marque"];
            $modele            = $_POST["modele"];
            $carburant         = $_POST["carburant"];
            $prixHeure         = $_POST["prixHeure"];
            $prixJoure         = 24*$_POST["prixHeure"];
            $couleur           = $_POST["couleur"];
            $image             = $_FILES["image"];
            $imageName         = $image["name"];
            $tmpName           = $image["tmp_name"];
            $imageNameSuccuss  =  "";
            $explodeNameImg    = explode(".",$imageName);
            $imageExtension    = strtolower(end($explodeNameImg));
            $arrayImgExt       = array("png", "jpg", "jpeg");

            if(in_array($imageExtension,$arrayImgExt)){
               if($image["error"] === 0){
                   $specifieImg = uniqid(true).".".$imageExtension;
                   $imageNameSuccuss = $specifieImg;
                   echo $specifieImg;
                   $toFolder = "images/voiture/".$specifieImg;
                   move_uploaded_file($tmpName,$toFolder);
               }{
                   //eror
               }
            }else{
                // error
            }
            
            $prepareQr = $conPDO->prepare("INSERT INTO voiture (MATRICULE,MARQUE,MODELE,CARBURANT,`IMAGE`,PRIXJOUR,PRIHEURE,COULER)
                                                     values (?,?,?,?,?,?,?,?)"); 
            $prepareQr->execute(array($matricule, $marque, $modele, $carburant,$imageNameSuccuss, $prixJoure, $prixHeure, $couleur));
            header("Location: voiture.php?action=allvoiture");
        }
        $querymarque = $conPDO -> prepare("SELECT marqueName FROM marque");
        $querymarque -> execute();
        $querycol = $conPDO -> prepare("SELECT coulerName FROM couleur");
        $querycol -> execute();
            ?>
<div class="wrapper">
    <form action="?action=ajouter" method="POST" enctype="multipart/form-data">
        <div class="title">
        AJOUTE VOITURE
        </div>
        <div class="form">
                <div class="inputfield">
                    <label>MATRICULE</label>
                    <input type="text" name="matricule" class="input matricule" autocomplate="off">
                </div>
                <div class="inputfield">
                <label>MARQUE</label>
                <div class="custom_select">
                    <select name="marque" id="">
                            <option value="">Select</option>
                            <?php while($marque = $querymarque -> fetch()) { ?>
                            <option value="<?php echo $marque["marqueName"]; ?>"><?php echo $marque["marqueName"]; ?></option>
                            <?php } ?>
                    </select>  
                </div>
                </div>  
                <div class="inputfield">
                <label>MODELE</label>
                <div class="custom_select">
                    <select name="modele" id="">
                            <option value="">Select</option>
                            <?php for($i = 2006; $i <= 2500; $i++){ ;?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                    </select>  
                </div>       
                </div> 
                <div class="inputfield">
                <label>CARBURANT</label>
                <div class="custom_select">
                    <select name="carburant" id="">
                            <option value="">Select</option>
                            <option value="Gaz Oil">Gaz Oil</option>
                            <option value="issence">issence</option>
                    </select>  
                </div>              
                </div> 
                <div class="inputfield">
                <label>PRIX/HEURE</label>
                <input type="number" class="input" name="prixHeure" autocomplate="off">
                </div> 
                <div class="inputfield">
                    <label>PHOTO</label>
                    <input type="file" name="image" class="input">
                </div> 
                <div class="inputfield">
                    <label>COULEUR</label>
                    <div class="custom_select">
                        <select name="couleur" id="">
                                <option value="">Select</option>
                                <?php while($couleur = $querycol -> fetch()) { ?>
                                <option value="<?php echo $couleur["coulerName"]; ?>"><?php echo $couleur["coulerName"]; ?></option>
                                <?php } ?>
                        </select>  
                    </div>  
                </div> 
                <div class="inputfield">
                    <input type="submit" value="Enregistrer" class="btn">
                </div>
            </div>
        </form>
    </div>
    <?php

      } // end ajouter
      elseif($action == "sup"){ // suprimer
        $voitID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
        
        $query = $conPDO -> prepare("DELETE FROM voiture WHERE NUMVOITURE = ?");
        $query -> execute(array($voitID));
        header("location: voiture.php?action=allvoiture");
    }// end suprimer
    elseif($action == "editer"){ // EDITER VOITURE

        $voitID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
        $query = $conPDO -> prepare("SELECT * FROM voiture WHERE NUMVOITURE = ? LIMIT 1");
        $query -> execute(array($voitID));
        $voitInfo = $query -> fetch();
    
        $querymarque = $conPDO -> prepare("SELECT marqueName FROM marque");
        $querymarque -> execute();
        $querycol = $conPDO -> prepare("SELECT coulerName FROM couleur");
        $querycol -> execute();
        ?>
        <div class="wrapper" style="max-width: 700px">
            <form action="?action=update" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $voitInfo["NUMVOITURE"];?>">
                <div class="title">
                    EDITER VOITURE
                </div>
                <div class="form">
                    <div class="fields">
                        <div class="field-info">
                            <div class="inputfield">
                                <label>MATRICULE</label>
                                <input type="text" name="matricule" value="<?php echo $voitInfo["MATRICULE"];?>" class="input matricule" autocomplate="off">
                            </div>
                            <div class="inputfield">
                                <label>MARQUE</label>
                                <div class="custom_select">
                                    <select name="marque" >
                                        <option value="<?php echo $voitInfo["MARQUE"];?>"><?php echo $voitInfo["MARQUE"];?></option>
                                        <?php while($marque = $querymarque -> fetch()) { ?>
                                        <option value="<?php echo $marque["marqueName"]; ?>"><?php echo $marque["marqueName"]; ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>
                            </div>  
                            <div class="inputfield">
                                <label>MODELE</label>
                                <div class="custom_select">
                                    <select name="modele" >
                                        <option value="<?php echo $voitInfo["MODELE"];?>"><?php echo $voitInfo["MODELE"];?></option>
                                        <?php for($i = 2006; $i <= 2500; $i++){ ;?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>       
                            </div> 
                            <div class="inputfield">
                                <label>CARBURANT</label>
                                <div class="custom_select">
                                    <select name="carburant" id="">
                                            <option value="<?php echo $voitInfo["CARBURANT"];?>"><?php echo $voitInfo["CARBURANT"];?></option>
                                            <option value="Gaz Oil">Gaz Oil</option>
                                            <option value="issence">issence</option>
                                    </select>  
                                </div>              
                            </div> 
                            <div class="inputfield">
                                <label>PRIX/HEURE</label>
                                <input type="number" class="input" value="<?php echo $voitInfo["PRIHEURE"];?>" name="prixHeure" autocomplate="off">
                            </div> 
                            <div class="inputfield">
                                <label>COULEUR</label>
                                <div class="custom_select">
                                    <select name="couleur" id="">
                                        <option value="<?php echo $voitInfo["COULER"];?>"><?php echo $voitInfo["COULER"];?></option>
                                        <?php while($couleur = $querycol -> fetch()) { ?>
                                        <option value="<?php echo $couleur["coulerName"]; ?>"><?php echo $couleur["coulerName"]; ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>  
                            </div> 
                        </div>
                        <div class="field-img">
                            <div class="img">
                                <img src="images/voiture/<?php echo $voitInfo["IMAGE"];?>" alt="">
                            </div>
                            <div class="inputfield">
                                <input type="hidden" value="<?php echo "images/voiture/".$voitInfo["IMAGE"];?>" name="oldimage">
                                <input type="file"  name="newimage" class="input">
                             </div> 
                        </div>
                    </div> <!--end fields -->
                    <div class="inputfield editvoitbtn">
                        <input type="submit" value="Enregistrer" class="btn">
                    </div>
                </div> 
            </form>
        </div>
   <?php
    }elseif($action == "update"){ //update
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $voitID            = $_POST["id"];
            $matricule         = strtoupper($_POST["matricule"]);
            $marque            = $_POST["marque"];
            $modele            = $_POST["modele"];
            $carburant         = $_POST["carburant"];
            $prixHeure         = $_POST["prixHeure"];
            $prixJoure         = 24*$_POST["prixHeure"];
            $couleur           = $_POST["couleur"];
            $imageNameSuccuss  =  "";
            $oldImage          = $_POST["oldimage"];
            $newImage          = $_FILES["newimage"];
            if(empty($newImage["name"])){
                $imageNameSuccuss = $oldImage;
                echo "no new image uploded";
            }else{
                $imageName         = $newImage["name"];
                $tmpName           = $newImage["tmp_name"];
                
                $explodeNameImg    = explode(".",$imageName);
                $imageExtension    = strtolower(end($explodeNameImg));
                $arrayImgExt       = array("png", "jpg", "jpeg");
                if(in_array($imageExtension,$arrayImgExt)){
                    if($newImage["error"] === 0){
                        $specifieImg = uniqid(true).".".$imageExtension;
                        $imageNameSuccuss = $specifieImg;
                        $toFolder = "images/voiture/".$specifieImg;
                        move_uploaded_file($tmpName,$toFolder);
                    }else{
                        //eror
                    }
                 }else{
                     //error
                 }
            }
            $prepareQr = $conPDO->prepare("UPDATE voiture SET MATRICULE = ?,MARQUE = ?,MODELE = ?,CARBURANT = ?,`IMAGE` = ?,PRIXJOUR = ?,PRIHEURE = ?,COULER = ?
                                                      WHERE NUMVOITURE = ?"); 
            $prepareQr->execute(array($matricule, $marque, $modele, $carburant,$imageNameSuccuss, $prixJoure, $prixHeure, $couleur,$voitID));
            header("Location: voiture.php?action=allvoiture");
     }
 }
}
     include "html/footer.php";
     ?>