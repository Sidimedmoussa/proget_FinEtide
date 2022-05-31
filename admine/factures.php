<?php 
 session_start();
 if(isset($_SESSION["nom"])){
     include "html/header.php";
     include "html/nav.php";
     include "connect.php";
    ?>
    <!-- <div class="div-carb-prog">
        <div class="carbur-prog">70%</div>
    </div> -->
<?php

     include "html/footer.php";
 } else{
     header("Location: index.php");
 }