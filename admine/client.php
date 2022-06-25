<?php
session_start();

require_once("connect.php");  
if(isset($_POST["search"])){
    $s = $_POST["search"];
$prepareQr = $conPDO->prepare("SELECT * FROM  client
                                WHERE NNI LIKE :s OR NOM LIKE :s OR PRENOM LIKE :s OR TEL LIKE :s OR ADRESSE LIKE :s OR PERMIS LIKE :s"); 
$prepareQr->execute(array("s" => "%".$s."%")); 
$clients = $prepareQr->fetchAll();
$clients = array_reverse($clients);
}
$prepareQr = $conPDO->prepare("SELECT * FROM  client"); 
$prepareQr->execute(); 
$clients = $prepareQr->fetchAll();
$clients = array_reverse($clients);




include "html/header.php";
include "html/nav.php";
?>
    <div class="tools client-tools">
    <div class="filter-by" >
            <form action=""   method="post">
                <div class="text">
                <input type="search" name="search" class="form-control">
                <button class="btn btn-primary"><i class="fa-solid fa-search"></i></button>
                </div>
            </form>
            <form action="" method="post">
                <div class="time">
                    <div class="de">
                        <label>Delivrer le</label>
                        <input type="date" name="deliver_le" class="form-control">
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
    <a href="clientactions.php?action=ajoute"><i class="fa-solid fa-user-plus"></i></a>
    </div>
    <div class="container">
        <div class="table-responsive">
        <table class="main-table table table-bordered">
            <tr >
                <th>NNI</th>
                <th>NOM </th>
                <th>PRENOM</th>
                <th>TEL</th>
                <th>ADRESSE</th>
                <th>DELEVRER LE</th>
                <th>PERMIS</th>
                <th>OPTIONS</th>
            </tr>
            <?php
            foreach ($clients as $client)                                                            // fetch return each line of the table
            { ?>
                <tr class="infoclient" >
                    <td><?php echo $client["NNI"] ?></td>
                    <td><?php echo $client["NOM"] ?></td>
                    <td><?php echo $client["PRENOM"] ?></td>
                    <td><?php echo $client["TEL"] ?></td>
                    <td><?php echo $client["ADRESSE"] ?></td>
                    <td><?php echo $client["DELEVRER_LE"] ?></td>
                    <td><?php echo $client["PERMIS"] ?></td>
                    <td>
                    <a href="clientactions.php?action=sup&id=<?php echo $client["NUMCLIENT"]?>"><i class="fa-solid fa-trash"></i></a>
                    <a href="clientactions.php?action=edit&id=<?php echo $client["NUMCLIENT"]?>"><i class="fa-solid fa-pen-to-square"></i></a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        </div>
    </div>
    
<?php
// include "html/editfile.php";

include "html/footer.php";

?>
