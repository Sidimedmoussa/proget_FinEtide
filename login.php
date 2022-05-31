<?php 
  session_start();
include 'admine/connect.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
        $email = $_POST["email"];
        $pass  = $_POST["pass"];

        $query = $conPDO -> prepare("SELECT * FROM `client` WHERE EMAIL = ? AND PASS = ? LIMIT 1");
        $query -> execute(array($email,$pass));
        $row = $query -> rowCount();
        $client = $query -> fetch();
        if($row > 0){
            $_SESSION["nom"] = $client["NOM"];
            $_SESSION["img"] = $client["CLIENTIMG"];
            header("Location: index.php");
        }else{
            $wornning = "L'email et le mot de pass sont incompatible";
            $wornningClass = "worning";
        }
    }
    include "html/header.php";
?>

<div class="login-form-container">

    <span id="close-login-form" class="fas fa-times" style="background-color:red"></span>

    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
        <h3>Client Login</h3>
        <input type="email" name="email" placeholder="email" class="box">
        <input type="password" name="pass" placeholder="password" class="box">
        <p> Mot de passe oublie<a href="#">click here</a> </p>
        <input type="submit" value="login" class="btn">
        <p> Vous n'avez pas de compte?<a href="signin.php">creer un</a> </p>
    </form>

</div>
    <div class="<?php if(isset($wornningClass)) echo $wornningClass; ?>"><?php if(isset($wornning)) echo $wornning; ?></div>
<?php
include "html/footer.php";