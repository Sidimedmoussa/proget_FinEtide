<?php 
   session_start();
   if (isset($_SESSION["nom"])){
        header("Location: admin.php");
    }
    include "html/header.php";
    include "connect.php";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
       $nom = $_POST["nom"];
       $pass = $_POST["pass"];
      //  $cachpass = sha1($pass);
       $query = $conPDO -> prepare("SELECT * FROM admine WHERE nom = ? AND pasword = ? LIMIT 1");
       $query -> execute(array($nom, $pass));
       $arr = $query->fetch(); 
       $isRowExist = $query -> rowCount();
       if($isRowExist > 0){
           $_SESSION["nom"] = $nom;
           $_SESSION["id"] = $arr["idAD"];
           header("Location: admin.php");
           exit;
       }
    }
 ?>
 <img src="images/1.jpg" alt="loginbg"> 
 <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" class="login">
    <h3>Login Admin: </h3>
  <input type="text" name="nom" id="" placeholder="NOM" class="form-control">   
  <input type="password" name="pass" value="" placeholder="PASSWORD" class="form-control">
  <input type="submit"  value="ENTER" class="btn btn-primary">
 </form>
 <?php 
 include "html/footer.php";

