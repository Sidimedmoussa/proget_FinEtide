<?php 
session_start();
if(isset($_SESSION["nom"])){
    include "html/header.php";
    include "html/nav.php";
    include "connect.php";
    $action = (isset($_GET['action']))? $_GET['action'] : 'index';
  ?>
<div class="voiture">
        <div class="marqueside">
            <div class="addbrands">
                <i class="fa-solid fa-plus" style="font-size: 30px;cursor:pointer"></i>
                <div class="message">Ajouter Une Marque</div>
            </div>
            <div class="ajoute-brand-form wrapper">
                <div class="xmark"><i class="fa-solid fa-xmark" style="position:absolute;top:7px;right:10px;cursor:pointer"></i></div>
        <form action="addbrands.php" method="post" enctype="multipart/form-data">
            <div class="form">
                <div class="inputfield">
                    <label>NOM DE MARQUE</label>
                    <input type="text" name="marquename" class="input"  autocomplate="off">
                </div>
                <div class="inputfield">
                    <label>NOM DE MARQUE</label>
                    <input type="file" name="marqueimage" class="input">
                </div>
                <div class="inputfield">
                    <input type="submit" value="Enregistrer" class="btn">
                </div>
            </div>
        </form>
    </div>
        <?php 
            $querymarque = $conPDO -> prepare("SELECT marqueName,marqueImg FROM marque");
            $querymarque -> execute();

           while ($marque = $querymarque -> fetch()){
        ?>
            <div class="brands"><a href="?action=marque&marque=<?php echo $marque["marqueName"];?>"><img src="images/marque/<?php echo $marque["marqueImg"]?>" alt="" ></a></div>
            <?php } ?>
        </div>
        <!-- carside -->
        <div class="carside">
       
    <?php  
        if($action == "allvoiture"){
            $prepareQr = $conPDO->prepare("SELECT * FROM  voiture");
            $prepareQr->execute();
            ?>
                <div class="tools container">
                    <form action="" class="col-sm-4">
                        <input type="search" name="" id="" class="form-control">
                    </form>
                    <a href="voitactions.php?action=ajouter">
                        <i class="fa-solid fa-car"></i>
                        <i class="fa-solid fa-plus" style="font-size: 5px"></i>
                    </a>
                    <a href="#"><i class="fa-solid fa-folder-plus"></i></a>                
                </div>
                <div class="container">
                    <div class="table-responsive">
                        <table class="main-table table table-bordered">
                            <tr >
                                <th>MATRICULE</th>
                                <th>MARQUE </th>
                                <th>MODELE</th>
                                <th>CARBURANT</th>
                                <th>COULER</th>
                                <th>PRIX/JOUR</th>
                                <th>PRIX/HEURE</th>
                                <th>OPTIONS</th>
                            </tr>
                            <?php
                            while ($voiture = $prepareQr->fetch()) 
                            { ?>
                                <tr class="" >
                                    <td><?php echo $voiture["MATRICULE"] ?></td>
                                    <td><?php echo $voiture["MARQUE"] ?></td>
                                    <td><?php echo $voiture["MODELE"] ?></td>
                                    <td><?php echo $voiture["CARBURANT"] ?></td>
                                    <td><?php echo $voiture["COULER"] ?></td>
                                    <td><?php echo $voiture["PRIXJOUR"] ?></td>
                                    <td><?php echo $voiture["PRIHEURE"] ?></td>
                                    <td>
                                    <a href="voitactions.php?action=sup&id=<?php echo $voiture["NUMVOITURE"];?>"><i class="fa-solid fa-trash"></i></a>
                                    <a href="voitactions.php?action=editer&id=<?php echo $voiture["NUMVOITURE"];?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>
                        </div>
                    </div>
                <?php } // endallvoiture
                        elseif($action = "marque"){ // marque
                           $marque = $_GET["marque"];
                           $prepareQr = $conPDO->prepare("SELECT * FROM  voiture WHERE MARQUE = ?");
                           $prepareQr->execute(array($marque));
                           $row = $prepareQr->rowCount();
                           ?>
                           <div class="container whenbrands">
                               <?php
                               if ($row > 0){
                                while ($voitDetail = $prepareQr->fetch()) 
                                {
                                ?>
                           <div class="voitdetail">
                               <div class="carimage"><img src="<?php echo "images/voiture/" . $voitDetail["IMAGE"];?>" alt=""></div>
                               <div class="details">
                                  <span><?php echo $voitDetail["MATRICULE"];?></span>
                                  <span><?php echo $voitDetail["MODELE"];?></span>
                                  <span><?php echo $voitDetail["CARBURANT"];?></span>
                                  <span><?php echo $voitDetail["PRIXJOUR"] . " UM/JOUR";?></span>
                                  <span><?php echo $voitDetail["PRIHEURE"] . " UM/HEURE";?></span>
                                  <span><?php echo "non reserve";?></span>
                               </div>
                           </div>
                           
                           <?php } 
                           }
                           ?>
                           </div>
                           
                        <?php
                        } // end marque

                ?>
        </div> 
        <!-- end carside  -->
    </div>
<?php
    include "html/footer.php";
} else{
    header("Location: index.php");
}