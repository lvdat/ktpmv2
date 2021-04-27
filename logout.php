<?php
setcookie("path", "", time() - 60, "/","", 0);
require './inc/all.php';
if(login()){
    unset($_SESSION['logged']);
    $path = $_COOKIE['path'];
    $sql = "DELETE FROM cookie WHERE path = '$path'";
    $conn->query($sql);
    if(!isset($_GET['redirect']))
    header("Location: /");
    else
    header("Location: ".$_GET['redirect']);
}else{
    header("Location: /dangnhap");
}
?>