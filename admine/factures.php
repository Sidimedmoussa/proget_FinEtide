<?php 
 session_start();
 if(isset($_SESSION["nom"])){
     include "html/header.php";
     include "html/nav.php";
     include "connect.php";
     if(isset($_POST["search"])){
         $s = $_POST["search"];
        $prepareQr = $conPDO->prepare("SELECT 
        NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM,cl.PRENOM,co.PRIXDEP
      FROM contrats co, voiture v ,client cl 
      WHERE co.MATRICULE = v.MATRICULE
      AND co.NUMCLIENT = cl.NUMCLIENT 
      AND (NUMCONTRACT = :n
      OR v.MARQUE LIKE :S OR co.MATRICULE LIKE :S OR cl.PRENOM LIKE :S OR cl.NOM LIKE :S)");
      $prepareQr->execute(array("S" => "%".$s."%", "n" => $s));

     }elseif(isset($_POST["search-date"]) && (!empty($_POST["datedep"] || !empty($_POST["dateret"])))){
         $dep = $_POST["datedep"];
         $ret = $_POST["dateret"];

    $prepareQr = $conPDO->prepare("SELECT 
        NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM,cl.PRENOM,co.PRIXDEP
      FROM contrats co, voiture v ,client cl 
      WHERE co.MATRICULE = v.MATRICULE
      AND co.NUMCLIENT = cl.NUMCLIENT 
      AND (DATEDEPART BETWEEN ? AND ? )");
      $prepareQr->execute(array($dep,$ret));
     }
     else{
        $prepareQr = $conPDO->prepare("SELECT 
        NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM,cl.PRENOM,co.PRIXDEP
      FROM contrats co, voiture v ,client cl 
      WHERE co.MATRICULE = v.MATRICULE
      AND co.NUMCLIENT = cl.NUMCLIENT ");
      $prepareQr->execute();
     }
     $fact = $prepareQr -> fetchAll();
     $facts = array_reverse($fact);
    //  echo "<pre>";
    // print_r($fact);
    //  echo "<pre>";
    ?> 
    <div class="tools fact-tools">
        <div class="filter-by" >
            <form action=""   method="post">
                <div class="text">
                <input type="search" name="search" class="form-control">
                <button class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
            <form action=""   method="post">
                <div class="time">
                    <div class="de">
                        <label>De</label>
                    <input type="date" name="datedep" class="form-control">
                    </div>
                    <div class="a">
                    <label>A</label>
                    <input type="date" name="dateret" class="form-control">
                    </div>
                <button name="search-date" class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
            <?php if((isset($_POST["search"]) && !empty($_POST["search"])) || (isset($_POST["search-date"]) && (!empty($_POST["datedep"] || !empty($_POST["dateret"])))) ){?>
            <form action="" method="post">
                <button class="btn btn-primary">Tout</button>
            </form>
            <?php } ?>
        </div>
            
     </div>
     <div class="container">
        <div class="table-responsive" id="get_data">
            <table class="main-table table table-bordered">
                <tr >
                    <th>N<sup>o</sup> DE FACTURE</th>
                    <th>CLIENT</th>
                    <th>MARQUE</th>
                    <th>MATRICULE</th>
                    <th>MONTANT</th>
                    <th>MONTANT FINAL</th>
                    <th>DATE DE LOCTION</th>
                    <th>DATE RETOUR</th>
                    <th>OPTIONS</th>
                </tr>
                <?php
                foreach( $facts as $fact) 
                { ?>
                     <tr class="" >
                        <td><?php echo $fact["NUMCONTRACT"] ?></td>
                        <td><?php echo $fact["NOM"] . " / " . $fact["PRENOM"]?></td>
                        <td><?php echo $fact["MARQUE"] ?></td>
                        <td><?php echo $fact["MATRICULE"] ?></td>
                        <td><?php echo $fact["PRIXLOC"] . " UM"?></td>
                        <td><?php if(empty($fact["PRIXDEP"])){echo " ";}else{echo $fact["PRIXLOC"] + $fact["PRIXDEP"] . " UM";}?></td>
                        <td><?php echo $fact["DATEDEPART"];?></td>
                        <td><?php echo $fact["DATEARRIVET"] ?></td>
                        <td>
                        <a href="factureActions.php?action=print&id=<?php echo $fact["NUMCONTRACT"] ?>"><i class="fa-solid fa-print" ></i></a>
                        <a href="factureActions.php?action=sup&id=<?php echo $fact["NUMCONTRACT"] ?>"><i class="fa-solid fa-trash"></i></a>
                        <a href="factureActions.php?action=editer&id=<?php echo $fact["NUMCONTRACT"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php

     include "html/footer.php";
 } else{
     header("Location: index.php");
 }