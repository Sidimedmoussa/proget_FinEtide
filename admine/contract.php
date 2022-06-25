<?php 
session_start();
if(isset($_SESSION["nom"])){
    include "html/header.php";
    include "html/nav.php";
    include "connect.php";
    $prepareQr = $conPDO->prepare("SELECT NUMCONTRACT,DATEARRIVET FROM contrats WHERE archived = ?");
    $prepareQr->execute(array("non"));
    $action = (isset($_GET["action"]))? $_GET["action"]: "depas";
    if($action = "depas"){
        while($checkFinsh = $prepareQr -> fetch()){
            if(date("Y-m-d H:i:s") >= $checkFinsh["DATEARRIVET"]){
                $idCont = intval($checkFinsh["NUMCONTRACT"]);
                    $query = $conPDO -> prepare("UPDATE contrats SET passedtime = ? WHERE NUMCONTRACT = ?");
                    $query->execute(array("depa",$idCont));
                }
            }
    }
    if(isset($_POST["search"])){
        $s = $_POST["search"];
        $prepareQr = $conPDO->prepare("SELECT NUMCONTRACT,cl.NUMCLIENT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM, passedtime,cl.PRENOM,co.ETAT 
        FROM contrats co, voiture v ,client cl 
        WHERE co.MATRICULE = v.MATRICULE
        AND co.NUMCLIENT = cl.NUMCLIENT 
        AND archived = :non
        AND (NUMCONTRACT = :n
        OR v.MARQUE LIKE :S OR co.MATRICULE LIKE :S OR cl.PRENOM LIKE :S OR cl.NOM LIKE :S)");
        $prepareQr->execute(array("non" => "non","S" => "%".$s."%", "n" => $s));
    }elseif(isset($_POST["search-date"]) && (!empty($_POST["datedep"] || !empty($_POST["dateret"])))){
        $dep = $_POST["datedep"];
         $ret = $_POST["dateret"];
        $prepareQr = $conPDO->prepare("SELECT NUMCONTRACT,cl.NUMCLIENT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM, passedtime,cl.PRENOM,co.ETAT 
        FROM contrats co, voiture v ,client cl 
        WHERE co.MATRICULE = v.MATRICULE
        AND co.NUMCLIENT = cl.NUMCLIENT 
        AND archived = ?
        AND (DATEDEPART BETWEEN ? AND ? )");
        $prepareQr->execute(array("non",$dep,$ret));
    }else{
        $prepareQr = $conPDO->prepare("SELECT NUMCONTRACT,cl.NUMCLIENT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM, passedtime,cl.PRENOM,co.ETAT 
        FROM contrats co, voiture v ,client cl 
        WHERE co.MATRICULE = v.MATRICULE
        AND co.NUMCLIENT = cl.NUMCLIENT 
        AND archived = ?");
        $prepareQr->execute(array("non"));
    }
    
    ?>                                                                                                                                
     <div class="tools contract-tools">
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
        <div class="add-contrat">
            <a href="contracactions.php?action=ajouter">
                <i class="fa-solid fa-file-signature" style="font-size: 25px;margin-right: 10px"></i>
            </a>
            <div class="archive"><i class="fa-solid fa-folder" style="font-size:25px; color: grey"></i></div>               
        </div>
     </div>
     <div class="container">
        <div class="table-responsive">
            <table class="main-table table table-bordered">
                <tr >
                    <th>N<sup>o</sup> DE CONTRACT</th>
                    <th>CLIENT</th>
                    <th>MARQUE</th>
                    <th>MATRICULE</th>
                    <th>PRIX DE LOCATION</th>
                    <th>DATE DE LOCTION</th>
                    <th>DATE RETOUR</th>
                    <th>ETAT</th>
                    <th>OPTIONS</th>
                </tr>
                <?php
                while ($contrat = $prepareQr->fetch()) 
                { ?>
                    <tr class="" >
                        <td><?php echo $contrat["NUMCONTRACT"] ?></td>
                        <td><?php echo $contrat["NOM"] . " / " . $contrat["PRENOM"]?></td>
                        <td><?php echo $contrat["MARQUE"] ?></td>
                        <td><?php echo $contrat["MATRICULE"] ?></td>
                        <td><?php echo $contrat["PRIXLOC"] . " UM"?></td>
                        <td><?php echo $contrat["DATEDEPART"];?></td>
                        <td class="<?php echo $contrat["passedtime"];?>"><?php echo $contrat["DATEARRIVET"] ?></td>
                        <td><i class="fa-solid fa-dice-one <?php echo $contrat["ETAT"] ?>"></i></td>
                        <td>
                        <a href="contracactions.php?action=sup&id=<?php echo $contrat["NUMCONTRACT"] ?>"><i class="fa-solid fa-trash"></i></a>
                        <a href="contracactions.php?action=editer&id=<?php echo $contrat["NUMCONTRACT"] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <?php if ($contrat["ETAT"] == "termine"){ ?>
                        <a href="contracactions.php?action=archive&id=<?php echo $contrat["NUMCONTRACT"] ?>"><i class="fa-solid fa-folder-plus"></i></a>
                        <?php }?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php //archive page
        $prepareQr = $conPDO->prepare("SELECT NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM, cl.PRENOM,co.ETAT 
        FROM contrats co, voiture v ,client cl 
        WHERE co.MATRICULE = v.MATRICULE
        AND co.NUMCLIENT = cl.NUMCLIENT
        AND archived = ?");
        $prepareQr->execute(array("oui"));
        ?>
        <div class="archived">
            <div class="xmark" style="font-size: 20px;position: absolute; top: 10px; right: 10px"> <i class="fa fa-xmark"></i></div>
           
            <div class="table-responsive">
                <table class="main-table table table-bordered">
                    <tr >
                        <th>N<sup>o</sup> DE CONTRACT</th>
                        <th>CLIENT</th>
                        <th>MARQUE</th>
                        <th>MATRICULE</th>
                        <th>PRIX DE LOCATION</th>
                        <th>DATE DE LOCTION</th>
                        <th>DATE DE RETOUR</th>
                        <th>DATE DE RECEPTION</th>
                        <th>OPTIONS</th>
                    </tr>
                    <?php
                    while ($contrat = $prepareQr->fetch()) 
                    { ?>
                        <tr class="" >
                            <td><?php echo $contrat["NUMCONTRACT"] ?></td>
                            <td><?php echo $contrat["NOM"] . " / " . $contrat["PRENOM"]?></td>
                            <td><?php echo $contrat["MARQUE"] ?></td>
                            <td><?php echo $contrat["MATRICULE"] ?></td>
                            <td><?php echo $contrat["PRIXLOC"] . " UM"?></td>
                            <td><?php echo $contrat["DATEDEPART"] ?></td>
                            <td><?php echo $contrat["DATEARRIVET"] ?></td>
                            <td><i class="fa-solid fa-dice-one <?php echo $contrat["ETAT"] ?>"></i></td>
                            <td>
                            <a href="contracactions.php?action=sup&id=<?php echo $contrat["NUMCONTRACT"] ?>"><i class="fa-solid fa-trash"></i></a>
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