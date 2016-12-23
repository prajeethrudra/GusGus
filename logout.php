<?php
//$_SESSION = array(); 
include 'config.php';
session_start();
$user=$_SESSION['userid'];
echo $user;
mysql_query("UPDATE profile SET status='0' WHERE user_id = '$user' ");

session_unset();
session_destroy();
unset($_SESSION['userid']);
header("Location:login.php");
?>