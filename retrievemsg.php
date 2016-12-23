<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
mysql_connect("127.0.0.1","root","","otmmg") or die('not connected');
$username = $_SERVER["HTTP_USERNAME"];
$tousername = $_SERVER["HTTP_TOUSERNAME"];
$data_prev_msg_id = $_SERVER["HTTP_DATAPREVMSGID"];
$id=$data_prev_msg_id;
$result=mysql_db_query("otmmg", "select * from chat where ((username='".$username."' and tousername='".$tousername."') or (username='".$tousername."' and tousername='".$username."')) and id>'".$data_prev_msg_id."'");
if ($result) {
    $stmts="";
    while ($row = mysql_fetch_array($result)) {    
        $id=$row[3];
        if($row[2]===$username && $row[4]!=1) {
                $status=mysql_db_query("otmmg", "update chat set status=1 where id='".$id."' and username='".$tousername."'");
        }
        if($id>$data_prev_msg_id){
            if((strpos($row[0], $username) !== false) && (strpos($row[2], $tousername) !== false)) {            
                $stmts.="<div class='chatMessageEndStyle'></div><div class='chatMessage'><span class='chatMessageSpanStyle'>".$row[1]."</span></div>";
            } else if((strpos($row[0], $tousername) !== false) && (strpos($row[2], $username) !== false)) {
                $stmts.="<div class='chatMessageEndStyle1'></div><div class='chatMessage1'><span class='chatMessageSpanStyle'>".$row[1]."</span></div>";
            }
        }              
    }  
    header("x-last-message-id:".$id);
    echo $stmts;
} else {
    header("x-last-message-id:".$id);
    echo 'failed';
}
mysql_close();