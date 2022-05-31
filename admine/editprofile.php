<?php
session_start();
if(isset($_SESSION["nom"])){
include "html/header.php";
include "html/nav.php";
include "connect.php";  
 
       if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_POST["id"];
        $nom = $_POST["nom"];
        $enspass = $_POST["ancienpass"];
        $novpass = $_POST["nouveaupass"];
        $Email = $_POST["email"];
        $pass = (empty($novpass))? $enspass : $novpass;
        // validation 
           //user naime
           
            $userNameEror = array();
            $erorshow = "";
            if(filter_var($nom,FILTER_SANITIZE_STRING) !== $nom){
               $userNameEror[] = "il y a de character non autorise ";
               $erorshow ="show-error-name";
            }
            if(empty($nom)){
               $userNameEror[] = "le nom d'utilisateur ne peut pas etre vide";
               $erorshow ="show-error-name";
            }
            $query = $conPDO -> prepare("SELECT nom,idAD FROM admine WHERE nom = ?");
            $query -> execute(array($nom));
            $checkName = $query -> fetch();
            $result = $query -> rowCount();
            if($result > 0 && $checkName["idAD"] !== $id){
               $userNameEror[] = "cette nom est utilise";
               $erorshow ="show-error-name";
            }
            if(strlen($nom) == 1){
               $userNameEror[] = "le nom d'utilisateur ne peut pas etre un seul charactere";
               $erorshow ="show-error-name";
            }
         
            //password 
            $passEror = array();
            $erorsShowPass = "";
            if(filter_var($pass,FILTER_SANITIZE_STRING) !==$pass){
               $passEror[] = "il y a de character non autorise ";
               $erorsShowPass ="show-error-pass";
            }
            if(empty($pass)){
               $passEror[] = "le mot de pass ne peut pas etre vide";
               $erorsShowPass ="show-error-pass";
            }
            if(strlen($pass) < 4){
               $passEror[] = "le mot de pass doit contient au mois 4 characteres";
               $erorsShowPass ="show-error-pass";
            }
            // email 
            if(filter_var($Email,FILTER_VALIDATE_EMAIL) ==""){
                header("Location: logout.php");
            }
            if(empty($passEror) && empty($userNameEror)){
               $query = $conPDO -> prepare("UPDATE  admine 
                                                   SET nom = ?,pasword = ?,email = ? 
                                                   WHERE idAD = ?");
               $query -> execute(array($nom,$pass,$Email,$id)); 
            }
       }
       $idAD  = (isset($_GET["id"]) && is_numeric($_GET["id"])) ? $_GET["id"]: 0;
       $query = $conPDO -> prepare("SELECT * FROM admine WHERE idAD = ? LIMIT 1");
       $query -> execute(array($idAD));
       $khadija = $query->fetch();
?>
      <div class="wrapper">
            <form action="" method="post">    
               <input type="hidden" name="id" value="<?php echo $khadija["idAD"];?>"> 
               <div class="title">
                  EDITER PROFILE
               </div>
               <div class="form">
                     <div class="errors <?php echo $erorshow ?>">
                           <?php foreach( $userNameEror as $errorN){
                                 echo $errorN . '<br />';
                           }?>
                     </div>
                     <div class="errors <?php echo $erorsShowPass ?>">
                           <?php foreach( $passEror as $errorP){
                                 echo $errorP . '<br />';
                           }?>
                     </div>
                  <div class="inputfield">
                        <label>NOM</label>
                        <input type="text" name="nom" value="<?php echo $khadija["nom"];?>" class="input"  autocomplate="off">
                     </div> 
                    
                  <div class="inputfield">
                        <label>PASSWORD</label>
                        <input type="password" name="nouveaupass" class="input"  autocomplate="off">
                        <input type="hidden" name="ancienpass" value="<?php echo $khadija["pasword"];?>"> 
                  </div> 
                  <div class="inputfield">
                        <label>EMAIL</label>
                        <input type="email" name="email" value="<?php echo $khadija["Email"];?>" class="input"  autocomplate="off">
                  </div>  
                  <div class="inputfield">
                     <input type="submit" value="ENREGISTRER" class="btn">
                  </div>
               </div>
            </form>
      </div>
<?php
include "html/footer.php";
}else{
    header("Location: index.php");
}