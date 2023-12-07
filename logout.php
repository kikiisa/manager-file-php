<?php 
session_start();
$_SESSION["device"] = "";
session_destroy();
header("location:index.php");



?>