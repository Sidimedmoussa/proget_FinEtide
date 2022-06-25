<?php
session_start();
include 'admine/connect.php';
$action = (isset($_GET["action"]))? $_GET["action"]: "public";
if($action == "louer"){
    if(isset($_SESSION["nom"])){

        $dateRessError = array();
        $showDateRessError = "";
        $dureeRessError = array();
        $showDureeRessError = "";       
        $dureeTypeRessError = array();
        $showTypeDureeRessError="";

        if($_SERVER["REQUEST_METHOD"] == "POST"){
           $client = $_POST["client"];
           $voiture = $_POST["voiture"];
           $resDate = $_POST["dateress"];
           $dateret = "nul";
           $duree = $_POST["duree"];
           $typeDuree = $_POST["type-duree"];

           // validation 
                //date de reservation
                if(empty($resDate)){
                    $dateRessError[] = "la date de reservation ne peut pas etre vide";
                    $showDateRessError = "show-error-dateress";
                }
                if($resDate < date("Y-m-d H:i") && empty($dateRessError)){
                    $dateRessError[] = "ce date est passe";
                    $showDateRessError = "show-error-dateress";
                }
                //duree
                if(empty($duree)){
                    $dureeRessError[] = "le duree de reservation ne peut pas etre vide";
                    $showDureeRessError = "show-error-duree";
                }
                if(empty($typeDuree)){
                    $dureeTypeRessError[] = "selectinner le type de duree svp (exmple: heure ,jour ou mois)";
                    $showTypeDureeRessError = "show-error-type-duree";
                }
            // end validation
            
            if(empty($dateRessError) && empty($dureeRessError) && empty($dureeTypeRessError)){
                if($typeDuree == "heure"){
                    $dateret = date("Y-m-d H:i:s",strtotime("+ $duree  hours"));
                }elseif($typeDuree == "jour"){
                    $dateret = date("Y-m-d H:i:s",strtotime("+ $duree days"));
                }elseif($typeDuree == "mois"){
                    $dateret = date("Y-m-d H:i:s",strtotime("+ $duree months"));
                }
                $query = $conPDO -> prepare("INSERT INTO reservation (CLIENT, VOITURE, DUREE, TYPEDUREE, DATERESS, DATERETOUR)
                                                    VALUES (?,?,?,?,?,?)");
                $query -> execute(array($client, $voiture, $duree, $typeDuree, $resDate, $dateret));
                header("Location: index.php");
                exit;
            }
        }


        $query = $conPDO -> prepare("SELECT * FROM `voiture` where MATRICULE = ?");
        $query -> execute(array($_GET["matricule"]));
        $voiture = $query->fetch();
        // echo "<pre>";
        // print_r($_POST);
        // echo "</pre>";
        // echo $voiture['IMAGE'];
        include "html/header.php";
        ?>
        <div class="login-form-container signin">
  
                <form action="?action=louer&matricule=<?php echo $_GET["matricule"] ?>" method="post">
                    <h3>louer</h3>
                    <div class="reservation">
                       <div class="car-details">
                            <div class="car-img"><img src="admine/images/voiture/<?php echo $voiture['IMAGE'];?>" alt=""></div>
                            <div class="car-info">
                                <input type="hidden" name="client" value="<?php echo $_SESSION["client-id"]?>">
                                <input type="hidden" name="voiture" value="<?php echo $voiture['MATRICULE']?>">
                                <div><?php echo $voiture['MARQUE']?></div>
                                <div><?php echo 'Modele ' . $voiture['MODELE']?></div>
                                <div><?php echo $voiture['CARBURANT']?></div>
                                <div><?php echo '<span class="monie">' . $voiture['PRIHEURE'] . '</span> /Heure'?></div>
                                <div><?php echo '<span class="monie">' . $voiture['PRIXJOUR']. '</span> /Heure'?></div>
                            </div>
                        </div>
                        <div class="reservation-temps">
                            <div class="res-date">
                                <div>
                                    <label >date de reservation</label>
                                    <input type="datetime-local" name="dateress">
                                </div>
                                <div class="errors-aj <?php echo $showDateRessError ?>">
                                    <?php foreach( $dateRessError as $error){
                                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                                    }?>
                                </div>
                            </div>
                            <div class="res-duree">
                                <div>
                                    <label>duree </label>
                                    <div>
                                        <input type="number" name="duree">
                                        <select name="type-duree" >
                                            <option value="">selectionner</option>
                                            <option value="heure">Heure</option>
                                            <option value="jour">Joure</option>
                                            <option value="mois">Mois</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="errors-aj <?php echo $showDureeRessError ?>">
                                    <?php foreach( $dureeRessError as $error){
                                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                                    }?>
                                </div>
                                <div class="errors-aj <?php echo $showTypeDureeRessError ?>">
                                    <?php foreach( $dureeTypeRessError as $error){
                                            echo "<div><i class='fa-solid fa-circle-exclamation'></i> " .$error. '</div><br />';
                                    }?>
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
    }else{
        header('Location: login.php');
    }
}elseif($action == "voiture"){
    $prepareQr = $conPDO->prepare("SELECT * FROM voiture WHERE MARQUE = ?"); 
    $prepareQr-> execute(array($_GET["marque"])); 
    $voitures = $prepareQr -> fetchAll();
    
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="style/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="style/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style/css/css.css">

</head>
<body>
<header class="header" style="background-color: white;box-shadow: var(--box-shadow); height:50px">

    <div id="menu-btn" class="fas fa-bars"></div>

    <a href="index.php" class="logo">wet<span>TAK</span></a>

    <nav class="navbar">
        <a href="index.php?#home">Acceuil</a>
        <a href="index.php?#Marque">Marques</a>
        <a href="index.php?#Statistiques">Statistiques</a>
        <a href="index.php?#voitues">Voitures</a>
        <a href="index.php?#reviews">commentaires</a>
        <a href="index.php?#contact">contact</a>
    </nav>

    
    <?php if(isset($_SESSION["nom"])){ ?>
        <div id="profile-client">
        <img src="images/clients/<?php echo $_SESSION["img"];?>" alt="">
        <div class="profile">
            <a href="logout.php">Logout</a>
        </div>
        </div>
    <?php }else{ ?>
        <div id="login-btn">
          <a href="login.php" class="btn">login</a>  
        </div> 
    <?php } ?>
    

</header> 
<div class="marque-content">
    <?php foreach($voitures as $voiture){?>
        <div class="swiper-slide box "  style="width: 429px; margin-right: 20px;">
            <img src="admine/images/voiture/<?php echo $voiture["IMAGE"] ?>">
            <div class="content">
                <h3><?php echo $voiture["MODELE"] ?></h3>
                <div class="carburant"><?php echo $voiture["CARBURANT"] ?></div>
                <div class="price"><span><?php echo $voiture["PRIHEURE"] ?></span>/ Heure</div>
                <div class="price"><span><?php echo $voiture["PRIXJOUR"] ?></span>/ joure</div>
            </div>
            <a class="btn" href="actions.php?action=louer&amp;matricule=<?php echo $voiture["MATRICULE"] ?>">Louer</a>
        </div>
    <?php }?>
</div>

<script src="style/js/all.min.js"></script>
<!-- <script src="style/js/bootstrap.min.js"></script> -->
<script src="style/js/swiper-bundle.min.js"></script>
<script src="style/js/jquery.js"></script>
<script src="style/js/js.js"></script>

</body>
</html>
    <?php
}