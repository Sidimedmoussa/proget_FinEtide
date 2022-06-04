<?php
session_start();

require_once("connect.php");  
$prepareQr = $conPDO->prepare("SELECT * FROM  client"); 
$prepareQr->execute(); 
$clients = $prepareQr->fetchAll();

$clients = array_reverse($clients);





include "html/header.php";
include "html/nav.php";
?>
    <div class="tools container">
    <form action="" class="col-sm-4">
        <input type="search" name="" id="" class="form-control">
    </form>
    <a href="clientactions.php?action=ajoute"><i class="fa-solid fa-user-plus"></i></a>
    <a href="#"><i class="fa-solid fa-folder-plus"></i></a>
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
