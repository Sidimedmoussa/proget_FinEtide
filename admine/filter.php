<?php
if(isset($_POST["data_picker"])){
include "connect.php";
$output = "";
$prepareQr = $conPDO->prepare("SELECT 
       NUMCONTRACT,v.MARQUE, co.MATRICULE,DATEDEPART,DATEARRIVET,PRIXLOC,cl.NOM,cl.PRENOM,co.PRIXDEP
     FROM contrats co, voiture v ,client cl 
     WHERE co.MATRICULE = v.MATRICULE
     AND co.NUMCLIENT = cl.NUMCLIENT 
     AND NUMCONTRACT = '".$_POST["data_picker"]."'");
$prepareQr->execute();
$fact = $prepareQr -> fetchAll();
$output .= '
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
                </tr>';
               
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

}