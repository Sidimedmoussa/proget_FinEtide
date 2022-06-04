<?php 
    include "connect.php";
    $marqueName        = $_POST["marquename"];
    $marqueImg         = $_FILES["marqueimage"];
    $imageName         = $marqueImg["name"];
    $tmpName           = $marqueImg["tmp_name"];
    $imageNameSuccuss  =  "";
    $explodeNameImg    = explode(".",$imageName);
    $imageExtension    = strtolower(end($explodeNameImg));
    if(empty($marqueName) || empty($imageName)){
        echo "there is an empty field";
    }elseif(!empty($imageName)){

        if($imageExtension === "png"){
        if($marqueImg["error"] === 0){
            $specifieImg = uniqid(true).".".$imageExtension;
            $imageNameSuccuss = $specifieImg;
            $toFolder = "images/marque/".$specifieImg;
            move_uploaded_file($tmpName,$toFolder);
        }{
            //eror
        }
        }else{
            // error
        }
    }

    $querymarque = $conPDO -> prepare("INSERT INTO marque  (marqueName,marqueImg) VALUES (?,?)");
    $querymarque -> execute(array($marqueName,$imageNameSuccuss));
header("location: voiture.php?action=allvoiture");