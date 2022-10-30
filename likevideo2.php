<?php include 'global.php';?>
<?php
include("header.php");
if(!isset($_SESSION['profileuser3'])) {
    die("please login to like...");
} 
else{
    if(!isset($_GET['id'])){
        die("no");
    } 
    else{
        $a = (int)$_GET['id'];
        $u = $_GET['u'];
        echo $u;
        if((bool)$u === true){
            $mysqli->query("UPDATE videos SET likes = likes+1 WHERE id = '".$a."' LIMIT 1");
            $_SESSION['liked'.$a] = false;
        }
        else{
            $mysqli->query("UPDATE videos SET likes = likes-1 WHERE id = '".$a."'");
            $_SESSION['liked'.$a] = true;
        }
        header("Location: ".$_SERVER['HTTP_REFERER']."");
    }
}
?>
<?php $mysqli->close();?>
