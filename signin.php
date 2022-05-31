<?php 
include "admine/connect.php";
  include "html/header.php";
        $NameEror = array();
        $erorshow = "";
        $preNameEror = array();
        $erorshowpreN = "";
        $nniEror = array();
        $erorshowNNI = "";
        $telEror = array();
        $erorshowtel = "";
        $adrEror = array();
        $erorshowAdr = "";
        $permisEror = array();
        $erorshowPermis = "";
        $passEror = array();
        $erorsShowPass = "";
        $datenessEror = array();
        $erorshowdateNess = "";
        $passEror   = array();
        $erorshowpass = "";
        $passconfEror = "";
        $erorshowpassconf = "";
        $erorimg = "";
        $erorshowimg = "";
   if($_SERVER["REQUEST_METHOD"] == "POST"){
            $nom             = $_POST["nom"];
            $prenom          = $_POST["prenom"];
            $nni             = $_POST["nni"];
            $tel             = $_POST["tel"];
            $adr             = $_POST["adress"];
            $deliver         = date("Y-m-d H:i:s");
            $permis          = $_POST["permis"];
            $email           = $_POST["email"];
            $passConf        = $_POST["pass"];
            $pass            = $_POST["passconf"];
            $dateness        = $_POST["dateness"];
            $image             = $_FILES["photo"];
            $imageName         = $image["name"];
            $tmpName           = $image["tmp_name"];

            $imageNameSuccuss  =  "default.jpg";
            $explodeNameImg    = explode(".",$imageName);
            $imageExtension    = strtolower(end($explodeNameImg));
            $arrayImgExt       = array("png", "jpg", "jpeg");

            if(in_array($imageExtension,$arrayImgExt)){
               if($image["error"] === 0){
                   $specifieImg = uniqid(true).".".$imageExtension;
                   $imageNameSuccuss = $specifieImg;
                //    $toFolder = "images/clients/".$specifieImg;
                //    move_uploaded_file($tmpName,$toFolder);
               }else{
                $erorimg = "cette photo n'est pas autoriser";
                $erorshowimg = "show-error-img-aj";
               }
            }elseif(empty($imageName)){
                $imageNameSuccuss  =  "default.jpg";
            }else{
                $erorimg = "<div><i class='fa-solid fa-circle-exclamation'></i>cette extention n'est pas autorise</div>";
                $erorshowimg = "show-error-img-aj";
            }

            // validation 
                // name and prename 
                if(filter_var($nom,FILTER_SANITIZE_STRING) != $nom){
                    $NameEror[] = "Le character". trime($nom) ." non autorise dans le nom";
                    $erorshow ="show-error-name-aj";
                } 
                if(empty($nom)){
                    $NameEror[] = "le nom de client ne peut pas etre vide";
                    $erorshow ="show-error-name-aj";
                 }

                 if(filter_var($prenom,FILTER_SANITIZE_STRING) != $prenom){
                    $preNameEror[] = "Le character" . trime($prenom) ." non autorise dans le prenom";
                    $erorshowpreN ="show-error-prename-aj";
                } 
                if(empty($prenom)){
                    $preNameEror[] = "le prenom de client ne peut pas etre vide";
                    $erorshowpreN ="show-error-prename-aj";
                 }

                //  NNI
                $query = $conPDO -> prepare("SELECT NNI FROM client WHERE NNI = ?");
                $query -> execute(array($nni));
                $result = $query -> rowCount();
                if($result > 0){
                    $nniEror[] = "Cette NNI est deja existe";
                    $erorshowNNI = "show-error-nni-aj";
                }
                if(strlen($nni) !== 10){
                    $nniEror[] = "Le NNI doit etre 10 chiffres";
                    $erorshowNNI = "show-error-nni-aj";
                }
                if(filter_var($nni,FILTER_SANITIZE_NUMBER_INT) != intval($nni)){
                    $nniEror[] = "Le NNI ne peut contenir que les chiffres";
                    $erorshowNNI = "show-error-nni-aj";
                }
                // TEL
                if(filter_var($tel,FILTER_SANITIZE_NUMBER_INT) != intval($tel)){
                    $telEror[] = "Le numero de telephone ne peut contenir que les chiffres";
                    $erorshowtel = "show-error-tel-aj";
                }
                if(empty($tel)){
                    $telEror[] = "Le numero de telephone ne peut pas etre vide";
                    $erorshowtel = "show-error-tel-aj";
                }
                if(strlen($tel) !== 8){
                    $telEror[] = "Le numero de telephone doit contenir 8 chiffres";
                    $erorshowtel = "show-error-tel-aj";
                }
                // adress 
                if(filter_var($adr,FILTER_SANITIZE_STRING) !== $adr){
                    $adrEror[] = "Le character ".trime($adr) ." non autorise";
                    $erorshowAdr ="show-error-adr-aj";
                }
                if(empty($adr)){
                    $adrEror[] = "L'adresse ne peut pas etre vide";
                    $erorshowAdr = "show-error-adr-aj";
                }
                //permis 
                if(empty($permis)){
                    $permisEror[] = "Le numero de permis ne peut pas etre vide";
                    $erorshowPermis = "show-error-permis-aj";
                }
                if(filter_var($permis,FILTER_SANITIZE_NUMBER_INT) != intval($permis)){
                    $permisEror[] = "Le numero de permis ne peut contenir que des chiffres";
                    $erorshowPermis = "show-error-permis-aj";
                }
                if(strlen($permis) !== 6){
                    $permisEror[] = "Le numero de permis doit contenir 6 chiffres";
                    $erorshowPermis = "show-error-permis-aj";
                }
                //email
                if(filter_var($email,FILTER_VALIDATE_EMAIL) ==""){
                    header("Location: logout.php");
                }
                //password
                if(filter_var($pass,FILTER_SANITIZE_STRING) !==$pass){
                    $passEror[] = "Le character ".trime($pass) ." non autorise";
                    $erorsShowPass ="show-error-pass-aj";
                 }
                 if(empty($pass)){
                    $passEror[] = "le mot de pass ne peut pas etre vide";
                    $erorsShowPass ="show-error-pass-aj";
                 }
                 if(strlen($pass) < 4){
                    $passEror[] = "le mot de pass doit contient au mois 4 characteres";
                    $erorshowpass ="show-error-pass-aj";
                 }
                 if($passConf !== $pass){
                    $passconfEror = "<div><i class='fa-solid fa-circle-exclamation'></i> N'est pas identique avec le mot de pass </div>";
                    $erorshowpassconf ="show-error-passconf-aj";
                 }
                 //date de nessence
                 if(!empty($dateness)){
                    $datenessArray   = explode("-",$dateness);
                    $dateNowArray   = explode("-",date("Y-m-d"));
                    $years = $dateNowArray[0] - $datenessArray[0];
                    $month = abs($dateNowArray[1] - $datenessArray[1]);
                    $day = abs($dateNowArray[2] - $datenessArray[2]);
                    $age = floor(( $years* 12 + $month +  $day/ 30 )/12);
                    if($age < 18){
                        $datenessEror[] = "Votre age doit etre au mois 18 ans";
                        $erorshowdateNess = "show-error-age-aj";
                     }
                 }else{
                    $datenessEror[] = "le date de naissance est vide";
                    $erorshowdateNess = "show-error-age-aj";
                 }
                 

            if(empty($NameEror) && empty($preNameEror) && empty($nniEror) && empty($telEror) && empty($adrEror) && empty($delEror) && empty($permisEror)){
               
            }

        }   
  ?>
  <div class="erorrdiv">

  </div>

  <div class="login-form-container signin">
  
      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
          <h3>registrer</h3>
          <div class="input">
              <div>
                <input type="text" name="nom" placeholder="NOM" class="box">
                <div class="errors-aj <?php echo $erorshow ?>">
                    <?php foreach( $NameEror as $errorN){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$errorN . '</div><br />';
                    }?>  
                </div>
              </div>
              <div>
                <input type="text" name="prenom" placeholder="PRENOM" class="box">
                <div class="errors-aj <?php echo $erorshowpreN ?>">
                    <?php foreach( $preNameEror as $errorPN){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " . $errorPN . ' </div><br />';
                    }?>  
                </div>
               </div>
          </div>
          <div class="input">
            <div>
                <input type="number" name="nni" placeholder="NNI" class="box">
                <div class="errors-aj <?php echo $erorshowNNI ?>">
                    <?php foreach($nniEror as $errorPN){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$errorPN . '</div><br />';
                    }?>  
                </div>
            </div>
            <div>
                <input type="number" name="tel" placeholder="TEL" class="box">
                <div class="errors-aj <?php echo $erorshowtel ?>">
                    <?php foreach( $telEror as $error){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                    }?>  
                </div>
            </div>
          </div>
          <div class="input">
              <div>
                <input type="text" name="adress" placeholder="ADRESSE" class="box">
                <div class="errors-aj <?php echo $erorshowAdr ?>">
                    <?php foreach( $adrEror as $error){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                    }?>  
                </div>
              </div>
              <div>
                <input type="number" name="permis" placeholder="PERMIS" class="box">
                <div class="errors-aj <?php echo $erorshowPermis ?>">
                    <?php foreach( $permisEror as $error){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                    }?>  
                </div>
              </div>
           </div>
          <div class="input">
              <div>
                <input type="file" name="photo" placeholder="PHOTO" class="box">
                <div class="errors-aj <?php echo $erorshowimg ?>">
                    <?php foreach( $datenessEror as $error){
                            echo $erorimg;
                    }?>  
                </div>
              </div>
              <div>
                 <input type="email" name="email" placeholder="EMAIL" class="box">
              </div>
          </div>
          <div >
             <div class="dateness">
                 <label>DATE DE NESSENCE</label>
                 <input type="date" name="dateness" class="box">
             </div>
                <div class="errors-aj <?php echo $erorshowdateNess ?>">
                    <?php foreach( $datenessEror as $error){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " . $error . '</div><br />';
                    }?>  
                </div>
          </div>
          <div class="input"> 
            <div>
                <input type="password" name="pass" placeholder="PASSWORD" class="box">
                <div class="errors-aj <?php echo $erorsShowPass ?>">
                    <?php foreach( $passEror as $error){
                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " . $error . '</div><br />';
                    }?>  
                </div>
            </div>
            <div>
                <input type="password" name="passconf" placeholder="CONFIRMER LE PASSWORD" class="box">
                <div class="errors-aj <?php echo $erorshowpassconf ?>">
                   <?php echo $passconfEror;?>
                </div>
            </div>
          </div>
          <div class="input">
            <input type="submit" value="registrer" class="btn-s">
           <a href="login.php" class="btn-s">Annuler</a>
          </div>
          
      </form>
  
  </div>

  <?php
  include "html/footer.php";