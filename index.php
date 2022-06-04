<?php 
    session_start();
    include 'admine/connect.php';
    $query = $conPDO -> prepare("SELECT * FROM `marque`");
    $query -> execute();
    $marques = $query->fetchAll();

    $query = $conPDO -> prepare("SELECT * FROM `voiture`");
    $query -> execute();
    $voitCount = $query -> rowCount();

    $query = $conPDO -> prepare("SELECT * FROM `client`");
    $query -> execute();
    $clientCount = $query -> rowCount();

    $query = $conPDO -> prepare("SELECT * FROM `voiture` where ETAT = ?");
    $query -> execute(array("non"));
    $voitures = $query->fetchAll();
    // echo "<pre>";
    // print_r($voitures);
    // echo "</pre>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="style/css/bootstrap.min.css" /> -->
    <link rel="icon" href="images/car-1.png" type="image/-icon">
    <link rel="stylesheet" href="style/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style/css/css.css">
    <title>wettak</title>
</head>
<body>
<header class="header">

    <div id="menu-btn" class="fas fa-bars"></div>

    <a href="#" class="logo">wet<span>TAK</span></a>

    <nav class="navbar">
        <a href="#home">Acceuil</a>
        <a href="#Marque">Marques</a>
        <a href="#Statistiques">Statistiques</a>
        <a href="#voitues">Voitures</a>
        <a href="#reviews">commentaires</a>
        <a href="#contact">contact</a>
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
    
<div class="login-form-container" style="display: none">

    <span id="close-login-form" class="fas fa-times" style="background-color:red"></span>
</div>

<!-- intro -->
<section class="bg-intro home">
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading" style="color: black">bienvenues</h1>
                        <p class="intro-text">
                        Vous êtes au bon endroit où se trouvent les meilleurs options
                        </p>
                        <a href="#Marque" class="btn btn-circle page-scroll blink">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
</section>  
<!-- marque -->
<section class="vehicles" id="Marque">

    <h1 class="heading"> <span>Marques</span> disponibles </h1>

    <div class="swiper vehicles-slider">

        <div class="swiper-wrapper">
<?php foreach($marques as $marque){ ?>
            <div class="swiper-slide box">
                <img src="admine/images/marque/<?php echo $marque['marqueImg'];?>" alt="">
                <div class="content">
                    <h3><?php echo $marque['marqueName']?></h3>
                    <a href="actions.php?action=voiture&marque=<?php echo $marque['marqueName']?>" class="btn">voire les voitures</a>
                </div>
            </div>
<?php } ?>

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>
<!-- details -->
<section class="icons-container" id="Statistiques">
<h1 class="heading" style="width: 100%;"><span>statistiques</span> </h1>
<div class="icons-container-info">
    <div class="icons">
        <i class="fas fa-home"></i>
        <div class="content">
            <h3><?php echo count($marques)?></h3>
            <p>marques</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-car"></i>
        <div class="content">
            <h3><?php echo $voitCount; ?>+</h3>
            <p>voitures</p>
        </div>
    </div>

    <div class="icons">
        <i class="fas fa-users"></i>
        <div class="content">
            <h3><?php echo $clientCount; ?>+</h3>
            <p>clients satisfaits</p>
        </div>
    </div>
</div>
</section>
<!-- voiture -->
<section class="featured" id="voitues">

    <h1 class="heading"> <span>Les voitures</span> disponibles </h1>

</section>
<!-- end -->

<section class="reviews" id="reviews">

    <h1 class="heading"><span>commentaires</span> de client</h1>

    <div class="swiper review-slider">

            <!-- <div class="swiper-slide box">
                <img src="images/pic-6.png" alt="">
                <div class="content">
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsam incidunt quod praesentium iusto id autem possimus assumenda at ut saepe.</p>
                    <h3>john deo</h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star-half-alt"></i>
                    </div>
                </div>
            </div> -->

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>

<section class="contact" id="contact">

    <h1 class="heading"><span>contacter</span> nous</h1>

    <div class="row">


        <form action="">
            <h3>votre belle commentire</h3>
            <textarea placeholder="votre message" class="box" cols="30" rows="10"></textarea>
            <input type="submit" value="envoyer message" class="btn">
        </form>

    </div>

</section>

<section class="footer" id="footer">

    <div class="box-container">

        <div class="box">
            <?php if(!isset($_SESSION["nom"])){ ?>
                <a href="admine/index.php"> <i class="fas fa-arrow-right"></i> connexion des admines </a>
            <?php } ?>
        </div>

        <div class="box">
            <h3>info de contact</h3>
            <a href="#"> <i class="fas fa-phone"></i>+222 43 85 52 80 </a>
            <a href="#"> <i class="fas fa-phone"></i> +222 41 89 26 87 </a>
            <a href="#"> <i class="fas fa-phone"></i> +222 41747047</a>
            <a href="#"> <i class="fas fa-envelope"></i> wettak@gmail.com </a>
        </div>

        <div class="box">
            <h3>media sociaux</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> facebook </a>
            <a hr ef="#"> <i class="fab fa-twitter"></i> twitter </a>
        </div>

    </div>

    <div class="credit">tout les droits sont reserves|<?php echo date("Y") ?></div>

</section>







<script>
    let voituresList = <?php echo json_encode($voitures); ?>;
    let slidesNumb = 0;
          let arraySlise = [];
          let section = document.querySelector(".featured");
          if(voituresList.length % 4 == 0){
            slidesNumb = voituresList.length / 4;
          }else if(voituresList.length < 4){
            slidesNumb = 1;
          }else{
            slidesNumb = Math.ceil(voituresList.length / 4);
          }
          for(let i = 0; i < slidesNumb; i++){
            arraySlise.push([]);
          }
          let j = 0;
          for(let i = 0; i < arraySlise.length; i++){
            let  k = 0;
            while( k < 4){
                arraySlise[i].push(voituresList[k + j]);
                k++;
            }
            j += 4;
          }
          for( let i = 0; i < arraySlise.length; i++ ) {
            let slide = document.createElement("div");
            slide.classList.add("swiper","featured-slider");
            let slideContent = document.createElement("div");
            slideContent.className = "swiper-wrapper";
            slide.appendChild(slideContent);
            console.log(arraySlise);
            for ( let j = 0; j < arraySlise[i].length; j++){
                if(arraySlise[i][j] != undefined){
                let voiturebox = document.createElement("div");
                voiturebox.classList.add("swiper-slide","box");
                let voituresImg = document.createElement("img");
                voituresImg.setAttribute("src",`admine/images/voiture/${arraySlise[i][j]["IMAGE"]}`);
               
                let content = document.createElement("div");
                content.className = "content";

                let cont0 = document.createElement("h3");
                cont0.appendChild(document.createTextNode(arraySlise[i][j]["MARQUE"]));
                let cont1 = document.createElement("h3");
                cont1.appendChild(document.createTextNode(`Modele ${arraySlise[i][j]["MODELE"]}`));
                let cont2 = document.createElement("div");
                cont2.appendChild(document.createTextNode(arraySlise[i][j]["CARBURANT"]));
                cont2.className = "carburant";
                let cont3 = document.createElement("div");
                cont3.className = "price";
                let span1 = document.createElement("span");
                span1.appendChild(document.createTextNode(`${arraySlise[i][j]["PRIHEURE"]} UM`));
                cont3.appendChild(span1);
                cont3.appendChild(document.createTextNode("/ Heure"));
                let cont4 = document.createElement("div");
                cont4.className = "price";
                let span2 = document.createElement("span");
                span2.appendChild(document.createTextNode(`${arraySlise[i][j]["PRIXJOUR"]} UM`));
                cont4.appendChild(span2);
                cont4.appendChild(document.createTextNode("/ joure"));
-
                content.appendChild(cont0);
                content.appendChild(cont1);
                content.appendChild(cont2);
                content.appendChild(cont3);
                content.appendChild(cont4);
                
                let btn = document.createElement("a");
                btn.className = "btn";
                btn.setAttribute("href",`actions.php?action=louer&matricule=${arraySlise[i][j]["MATRICULE"]}`);
                btn.appendChild(document.createTextNode("Louer"));

                voiturebox.appendChild(voituresImg);
                voiturebox.appendChild(content);
                voiturebox.appendChild(btn);
                slideContent.appendChild(voiturebox);

                } 
            }
            let circles = document.createElement("div");
            circles.className = "swiper-pagination";
            slide.appendChild(circles);
            section.appendChild(slide);
          }
</script>

<script src="style/js/all.min.js"></script>
<!-- <script src="style/js/bootstrap.min.js"></script> -->
<script src="style/js/swiper-bundle.min.js"></script>
<script src="style/js/jquery.js"></script>
<script src="style/js/js.js"></script>

</body>
</html>