<?php
    session_start();
    if(isset($_SESSION["nom"])){
     include "html/header.php";
     include "html/nav.php";
     include "connect.php";  

     $action = (isset($_GET["action"]))? $_GET["action"]: "controle";
    if ($action == "ajoute"){  //ajoute page
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
        $delEror = array();
        $erorshowdel = "";
        $permisEror = array();
        $erorshowPermis = "";
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $nom             = $_POST["nom"];
            $prenom          = $_POST["prenom"];
            $nni             = $_POST["nni"];
            $tel             = $_POST["tel"];
            $adr             = $_POST["adress"];
            $deliver         = date("Y-m-d",strtotime($_POST["delivredate"]));
            $permis          = $_POST["permis"];   
            // validation 
                // name and prename 
                if(filter_var($nom,FILTER_SANITIZE_STRING) != $nom){
                    $NameEror[] = "Le character".trime($adr) ." non autorise dans le nom";
                    $erorshow ="show-error-name-aj";
                } 
                if(empty($nom)){
                    $NameEror[] = "le nom de client ne peut pas etre vide";
                    $erorshow ="show-error-name-aj";
                 }

                 if(filter_var($prenom,FILTER_SANITIZE_STRING) != $prenom){
                    $preNameEror[] = "Le character" . trime($adr) ." non autorise dans le prenom";
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
                    $nniEror[] = "Le NNI doit constituer a 10 chiffres";
                    $erorshowNNI = "show-error-nni-aj";
                }
                if(filter_var($nni,FILTER_SANITIZE_NUMBER_INT) != intval($nni)){
                    $nniEror[] = "Le NNI ne peut contiener que le chifre";
                    $erorshowNNI = "show-error-nni-aj";
                }
                // TEL
                if(filter_var($tel,FILTER_SANITIZE_NUMBER_INT) != intval($tel)){
                    $telEror[] = "Le numero de telephone ne peut contiener que le chifre";
                    $erorshowtel = "show-error-tel-aj";
                }
                if(empty($tel)){
                    $telEror[] = "Le numero de telephone ne peut pas etre vide";
                    $erorshowtel = "show-error-tel-aj";
                }
                if(strlen($tel) !== 8){
                    $telEror[] = "Le numero de telephone doit constituer a 8 chiffres";
                    $erorshowtel = "show-error-tel-aj";
                }
                // adress 
                if(filter_var($adr,FILTER_SANITIZE_STRING) !== $adr){
                    $adrEror[] = "Le character ".trime($adr) ." non autorise dans l'Adresse";
                    $erorshowAdr ="show-error-adr-aj";
                }
                if(empty($adr)){
                    $adrEror[] = "L'adresse ne peut pas etre vide";
                    $erorshowAdr = "show-error-adr-aj";
                }
                // delivre date
                // if(filter_var($nom,FILTER_SANITIZE_STRING) !== $deliver){
                //     header("Location: logout.php");
                // }
                if(empty($deliver)){
                    $delEror[] = "La date ne peut pas etre vide";
                    $erorshowdel = "show-error-deldate-aj";
                }
                //permis 
                if(empty($permis)){
                    $permisEror[] = "Le numero de permis ne peut pas etre vide";
                    $erorshowPermis = "show-error-permis-aj";
                }
                if(filter_var($permis,FILTER_SANITIZE_NUMBER_INT) != intval($permis)){
                    $permisEror[] = "Le numero de permis ne peut contiener que le chifre";
                    $erorshowPermis = "show-error-permis-aj";
                }
                if(strlen($permis) !== 6){
                    $permisEror[] = "Le numero de permis doit constituer a 6 chiffres";
                    $erorshowPermis = "show-error-permis-aj";
                }
            if(empty($NameEror) && empty($preNameEror) && empty($nniEror) && empty($telEror) && empty($adrEror) && empty($delEror) && empty($permisEror)){
                echo "<pre>";
        print_r($_POST);
        echo "</pre>";
                $query = $conPDO -> prepare("INSERT INTO client (NOM, PRENOM, NNI, TEL, ADRESSE, DELEVRER_LE, PERMIS)
                                                VALUES (?,?,?,?,?,?,?)");
                $query -> execute(array($nom, $prenom, $nni, $tel,$adr, $deliver, $permis)); 
                if(isset($_POST["fromcontrat"])){
                    header("location: contracactions.php?action=ajouter");
                }elseif(isset($_POST["fromcontratedit"])){
                    header("location: contracactions.php?action=editer");
                }else{
                    header("location: client.php");  
                }
            }
            exit;
            }
                ?>
            <!-- error -->
            <div class="errors-div">
                <div class=".errors-aj <?php echo $erorshow ?>">
                    <?php foreach( $NameEror as $errorN){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$errorN . '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowpreN ?>">
                    <?php foreach( $preNameEror as $errorPN){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " . $errorPN . '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowNNI ?>">
                    <?php foreach(  $nniEror as $errorPN){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$errorPN . '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowtel ?>">
                    <?php foreach( $telEror as $error){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$error. '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowAdr ?>">
                    <?php foreach( $adrEror as $error){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$error. '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowdel ?>">
                    <?php foreach( $delEror as $error){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$error. '<br />';
                    }?>  
                </div>
                <div class=".errors-aj <?php echo $erorshowPermis ?>">
                    <?php foreach( $permisEror as $error){
                            echo "<i class='fa-solid fa-circle-exclamation'></i> " .$error. '<br />';
                    }?>  
                </div>
            </div>
            <!-- end error -->
            <div class="wrapper add">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="title">
                    ajouter client
                </div>
                <div class="form">
                <div class="inputfield">
                    <label>NOM</label>
                    <input type="text" name="nom" class="input"  autocomplate="off">
                </div>  
                    <div class="inputfield">
                    <label>PRENOM</label>
                    <input type="text" name="prenom"  class="input" autocomplate="off">
                </div>  
                <div class="inputfield">
                    <label>NNI</label>
                    <input type="text" name="nni"  class="input">  
                </div> 
                <div class="inputfield">
                    <label>TEL</label>
                    <input type="text" class="input"  name="tel" autocomplate="off">
                </div> 
                <div class="inputfield">
                    <label>ADRESSE</label>
                    <input type="text" class="input"  name="adress" autocomplate="off">
                </div> 
                <div class="inputfield">
                    <label>DELEVRER LE</label>
                    <input type="date" name="delivredate"  autocomplate="off" class="input">
                </div> 
                <div class="inputfield">
                    <label>PERMIS</label>  
                    <input type="text" class="input"  name="permis" autocomplate="off">
                </div> 
                <?php  
                
                if(isset($_GET["from"]) && $_GET["from"] == "clientcontract"){ ?>
                    <div class="inputfield">
                        <input type="submit" name="fromcontrat" value="Ajouter" class="btn">
                    </div>
                <?php }elseif(isset($_GET["from"]) && $_GET["from"] == "fromcontratedit"){ ?>
                    <div class="inputfield">
                         <input type="submit" name="fromcontratedit" value="Ajouter" class="btn">
                    </div>
               <?php } else {?>
                    <div class="inputfield">
                        <input type="submit"  value="Ajouter" class="btn">
                    </div>
                    <?php }?>
                </div>
            </form>
        </div>
        <?php 
        
        } // end ajouter page
        elseif($action == "sup"){ // supp
            $clientID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
            $contID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0;
            $query = $conPDO -> prepare("DELETE FROM contrats WHERE NUMCLIENT = ?");
            $query -> execute(array($clientID));
            $query = $conPDO -> prepare("DELETE FROM client WHERE NUMCLIENT = ?");
            $query -> execute(array($clientID));
            header("location: client.php");
            exit;
        }elseif($action == "edit"){// edite page
            $clientID = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? intval($_GET["id"]): 0; 
            $prepareQr = $conPDO->prepare("SELECT * FROM  client WHERE NUMCLIENT = ?"); 
            $prepareQr->execute(array($clientID));
            $clientInfo = $prepareQr->fetch();
            ?>
                <div class="wrapper">
                <form action="?action=update" method="POST">
                    <div class="title">
                    editer client
                    </div>
                    <div class="form">
                        <input type="hidden" name="id" value="<?php echo $clientInfo["NUMCLIENT"];?>">
                    <div class="inputfield">
                        <label>NOM</label>
                        <input type="text" name="nom" class="input" value="<?php echo $clientInfo["NOM"];?>" autocomplate="off">
                    </div>  
                        <div class="inputfield">
                        <label>PRENOM</label>
                        <input type="text" name="prenom" value="<?php echo $clientInfo["PRENOM"];?>" class="input" autocomplate="off">
                    </div>  
                    <div class="inputfield">
                        <label>NNI</label>
                        <input type="number" name="nni" value="<?php echo $clientInfo["NNI"];?>" class="input">  
                    </div> 
                    <div class="inputfield">
                        <label>TEL</label>
                        <input type="text" class="input" value="<?php echo $clientInfo["TEL"];?>" name="tel" autocomplate="off">
                    </div> 
                    <div class="inputfield">
                        <label>ADRESSE</label>
                        <input type="text" class="input" value="<?php echo $clientInfo["ADRESSE"];?>" name="adress" autocomplate="off">
                    </div> 
                    <div class="inputfield">
                        <label>DELEVRER LE</label>
                        <input type="date" name="delivredate" value="<?php echo $clientInfo["DELEVRER_LE"];?>" autocomplate="off" class="input">
                    </div> 
                    <div class="inputfield">
                        <label>PERMIS</label>
                        <input type="text" class="input" value="<?php echo $clientInfo["PERMIS"];?>" name="permis" autocomplate="off">
                    </div> 
                    <div class="inputfield">
                        <input type="submit" value="Enregistrer" class="btn">
                    </div>
                    </div>
                </form>
                </div>

                <div class="<?php if (isset($_GET["up"])){echo 'updated';} ?>"><i class="fa-solid fa-check" style="color: #c90752"></i></div>
            <?php
        }elseif($action == "update"){ //update page
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $idclient        = $_POST["id"];
                    $nom             = $_POST["nom"];
                    $prenom          = $_POST["prenom"];
                    $nni             = $_POST["nni"];
                    $tel             = $_POST["tel"];
                    $adr             = $_POST["adress"];
                    $deliver         = $_POST["delivredate"];
                    $permis          = $_POST["permis"];
                    // validation 
                        // name and prename 
                    //     if(filter_var($nom,FILTER_SANITIZE_STRING) != $nom){
                    //         $NameEror[] = "Le character".trime($adr) ." non autorise dans le nom";
                    //         $erorshow ="show-error-name-aj";
                    //     } 
                    //     if(empty($nom)){
                    //         $NameEror[] = "le nom de client ne peut pas etre vide";
                    //         $erorshow ="show-error-name-aj";
                    //     }

                    //     if(filter_var($prenom,FILTER_SANITIZE_STRING) != $prenom){
                    //         $preNameEror[] = "Le character" . trime($adr) ." non autorise dans le prenom";
                    //         $erorshowpreN ="show-error-prename-aj";
                    //     } 
                    //     if(empty($prenom)){
                    //         $preNameEror[] = "le prenom de client ne peut pas etre vide";
                    //         $erorshowpreN ="show-error-prename-aj";
                    //     }

                    //     //  NNI
                    //     $query = $conPDO -> prepare("SELECT NNI FROM client WHERE NNI = ?");
                    //     $query -> execute(array($nni));
                    //     $result = $query -> rowCount();
                    //     if($result > 0){
                    //         $nniEror[] = "Cette NNI est deja existe";
                    //         $erorshowNNI = "show-error-nni-aj";
                    //     }
                    //     if(strlen($nni) !== 10){
                    //         $nniEror[] = "Le NNI doit constituer a 10 chiffres";
                    //         $erorshowNNI = "show-error-nni-aj";
                    //     }
                    //     if(filter_var($nni,FILTER_SANITIZE_NUMBER_INT) != intval($nni)){
                    //         $nniEror[] = "Le NNI ne peut contiener que le chifre";
                    //         $erorshowNNI = "show-error-nni-aj";
                    //     }
                    //     // TEL
                    //     if(filter_var($tel,FILTER_SANITIZE_NUMBER_INT) != intval($tel)){
                    //         $telEror[] = "Le numero de telephone ne peut contiener que le chifre";
                    //         $erorshowtel = "show-error-tel-aj";
                    //     }
                    //     if(empty($tel)){
                    //         $telEror[] = "Le numero de telephone ne peut pas etre vide";
                    //         $erorshowtel = "show-error-tel-aj";
                    //     }
                    //     if(strlen($tel) !== 8){
                    //         $telEror[] = "Le numero de telephone doit constituer a 8 chiffres";
                    //         $erorshowtel = "show-error-tel-aj";
                    //     }
                    //     // adress 
                    //     if(filter_var($adr,FILTER_SANITIZE_STRING) !== $adr){
                    //         $adrEror[] = "Le character ".trime($adr) ." non autorise dans l'Adresse";
                    //         $erorshowAdr ="show-error-adr-aj";
                    //     }
                    //     if(empty($adr)){
                    //         $adrEror[] = "L'adresse ne peut pas etre vide";
                    //         $erorshowAdr = "show-error-adr-aj";
                    //     }
                    //     // delivre date
                    //     // if(filter_var($nom,FILTER_SANITIZE_STRING) !== $deliver){
                    //     //     header("Location: logout.php");
                    //     // }
                    //     if(empty($deliver)){
                    //         $delEror[] = "La date ne peut pas etre vide";
                    //         $erorshowdel = "show-error-deldate-aj";
                    //     }
                    //     //permis 
                    //     if(empty($permis)){
                    //         $permisEror[] = "Le numero de permis ne peut pas etre vide";
                    //         $erorshowPermis = "show-error-permis-aj";
                    //     }
                    //     if(filter_var($permis,FILTER_SANITIZE_NUMBER_INT) != intval($permis)){
                    //         $permisEror[] = "Le numero de permis ne peut contiener que le chifre";
                    //         $erorshowPermis = "show-error-permis-aj";
                    //     }
                    //     if(strlen($permis) !== 6){
                    //         $permisEror[] = "Le numero de permis doit constituer a 6 chiffres";
                    //         $erorshowPermis = "show-error-permis-aj";
                    //     }
                    // if(!empty($NameEror) || !empty($preNameEror) || !empty($nniEror) || !empty($telEror) || !empty($adrEror) || !empty($delEror) || !empty($permisEror)){
                        
                    // }

                    $prepareQr = $conPDO->prepare("UPDATE  client SET NOM = ?, PRENOM = ?, NNI = ?, TEL = ?, ADRESSE = ?, DELEVRER_LE = ?, PERMIS = ?
                                                    WHERE NUMCLIENT = ?"); 
                    $prepareQr->execute(array($nom,$prenom,$nni,$tel,$adr,$deliver,$permis,$idclient)); 
                }
                header("Location: clientactions.php?action=edit&id=$idclient&up");
        }else{
                header("location: admin.php");
        }
     include "html/footer.php";
    } else {
        header("Location: index.php");
        exit;
    }
?>