<?php 
function trime($str){
    return trim($str,filter_var($str,FILTER_SANITIZE_STRING));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="style/css/all.min.css"> -->
    <!-- <link rel="stylesheet" href="style/css/bootstrap.min.css" /> -->
    <link rel="stylesheet" href="style/css/swiper-bundle.min.css" />
    <link rel="stylesheet" href="style/css/css.css">

</head>
<body>