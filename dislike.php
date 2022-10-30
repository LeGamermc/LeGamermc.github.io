<?php include 'global.php';?>
<?php
include("header.php");
?>

<head>
    <link rel="stylesheet" type="text/css" href="./css/global.css">
    <link rel="stylesheet" type="text/css" href="./css/index.css">
</head>
<?php

if(!isset($_SESSION['profileuser3'])) {
    die("login to dislike...");
} else {
    if(!isset($_GET['id'])){
        die("no");
    } else {
        $a = (int)$_GET['id'];
        if(isset($_SESSION['liked' . $a])) {
            die("you have already disliked this video");
        }
        if(isset($_SESSION['liked' . $a] = false;)) {
            die("you did not liked the video before");
        }
        $_SESSION['liked' . $a] = true;
        mysqli_query($mysqli, "UPDATE videos SET likes = likes-1 WHERE id = '" . (int)$_GET['id'] . "'");


        $_SESSION['liked' . $a] = true;
        echo "disliked the video! you can go back now.";
    }
}
?>
<?php $mysqli->close();?>
