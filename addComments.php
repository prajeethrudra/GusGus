<?php
	include 'config.php';
	$postid=$_SERVER["HTTP_POSTID"];
	$userid=$_SERVER["HTTP_USERID"];
	$comment=$_SERVER["HTTP_COMMENT"];
	date_default_timezone_set("Asia/Kolkata");
	$dt = (new DateTime())->format('Y-m-d H:i:s');
    if($comment){
    	mysql_query("INSERT INTO comments (post_id,user_id,comment,time) VALUES ('$postid','$userid','$comment','$dt')");
    	echo "success";
    }
 ?>