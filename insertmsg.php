<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$username = $_SERVER["HTTP_USERNAME"];
$message = $_SERVER["HTTP_MESSAGE"];
$tousername = $_SERVER["HTTP_TOUSERNAME"];
mysql_connect("127.0.0.1","root","","otmmg") or die('not connected');
$result=mysql_db_query("otmmg", "INSERT INTO chat VALUES('".$username."','".$message."','".$tousername."',null,0)");
if ($result) {
    echo 'success';
} else {
    echo 'failed'.mysql_errno();
}
mysql_close();