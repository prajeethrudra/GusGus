<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'config.php';
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$retval = mysql_query("select user_id from profile where status=1");
  echo "[";
while($row = mysql_fetch_assoc($retval))
{    
    $id.=$row['user_id'];
}
echo "null]\n\n";

flush();

