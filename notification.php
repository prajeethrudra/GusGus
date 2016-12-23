<?php
include 'config.php';
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$username=$_SESSION['userid'];

$p_comment = $_SESSION['prev_comment'];
$p_post = $_SESSION['prev_post'];
date_default_timezone_set("Asia/Kolkata");
$dt = (new DateTime())->format('Y-m-d H:i:s');
$ret_posts = mysql_query("SELECT * FROM posts WHERE ptime IS NOT NULL AND ptime > NOW()-INTERVAL 1 DAY AND post_id > '$p_post' AND user_id <> '$username'  ORDER BY ptime ASC");
$retval = mysql_query("SELECT * FROM comments WHERE time IS NOT NULL AND time > NOW()-INTERVAL 1 HOUR AND s_no > '$p_comment' AND user_id <> '$username' ORDER BY time ASC");
$count = mysql_num_rows($ret_posts)+mysql_num_rows($retval);

  echo "data: [\n";
   $dt_p=0;$dt_c=0;
    for($i=0,$j=0;$i+$j<$count;)
    {
      if($dt_p==0) {
        if($posts = mysql_fetch_assoc($ret_posts))
          $dt_p = $posts['ptime'];
        else {
            $dtt = strtotime($dt_p)+strtotime($dt)+86400;
            $dt_p= date('Y-m-d H:i:s',$dtt);
        } 
      }
      if($dt_c==0){
        if($row = mysql_fetch_assoc($retval))
            $dt_c = $row['time'];
        else {
            $dtt = strtotime($dt_c)+strtotime($dt)+86400;
            $dt_c= date('Y-m-d H:i:s',$dtt);
        }
      }

      if(strtotime($dt_p)<strtotime($dt_c)) {
        $i++;
        $post_id = $posts['post_id'];
        $user_id = $posts['user_id'];
        $type = $posts['post_type'];         
        $content = $posts['pcontent']; 
       $content=str_replace("\r\n", "<br>", $content); 
        $ret_post_user = mysql_query("SELECT * from profile WHERE user_id='$user_id'");
        $post_user = mysql_fetch_assoc($ret_post_user);
        $pp=$post_user['profile_pic'];
        $user_name = $post_user['name'];
        if($content)
          $stmt= "<a href='#post_post_".$post_id."' style='text-decoration:none;'><div class='modifier' id=post_".$post_id."><div class='ns-thumb' ><img src='".$pp."' id='notifications_pic'/></div><div class='ns-content'>{$user_name} posted '{$content}'<br></div><img src='images/close.png' class='closenote' onclick='javascript:closepost(".$post_id.");'/></div></a>";
        else
          $stmt= "<div class='modifier' id=post_".$post_id."><div class='ns-thumb' ><img src='".$pp."' id='notifications_pic'/></div><div class='ns-content'>{$user_name} posted {$type}<br></div><img src='images/close.png' class='closenote' onclick='javascript:closepost(".$post_id.");'/></div>";
        echo "data: { \"post_id\" :$post_id, \"post_notification\" : \"$stmt\"},\n";
        if($posts = mysql_fetch_assoc($ret_posts))
          $dt_p = $posts['ptime'];
        else {
            $dt = strtotime($dt_p)+86400;
            $dt_p= date('Y-m-d H:i:s',$dt);
        } 
      }
      else {
        $j++;
        $post_id = $row['post_id'];
        $commenter_id = $row['user_id'];
        $comment = $row['comment'];
        $comment_id = $row['s_no'];
        $retval1 = mysql_query("SELECT * from profile WHERE user_id='$commenter_id'");
        $row2 = mysql_fetch_assoc($retval1);
        $pp=$row2['profile_pic'];
        $commenter_name = $row2['name'];

        $retval2 = mysql_query("SELECT * from posts WHERE post_id='$post_id'");
        $row3 = mysql_fetch_assoc($retval2);
        $userid=$row3['user_id'];
        $post_user = mysql_fetch_assoc(mysql_query("SELECT * from profile WHERE user_id='$userid'"))['name'];
        $type = $row3['post_type'];        

        $stmt= "<a href='#post_post_".$post_id."'  style='text-decoration:none;'><div class='modifier' id='".$comment_id."'><div class='ns-thumb' ><img src='$pp' id='notifications_pic'/></div><div style='' class='ns-content'>{$commenter_name} commented on {$post_user} {$type}<br></div><img src='images/close.png' class='closenote' onclick='javascript:closeit(".$comment_id.");'/></div></a>";
        echo "data: { \"comment_id\" :$comment_id, \"notification\" : \"$stmt\"},\n";
        if($row = mysql_fetch_assoc($retval))
            $dt_c = $row['time'];
        else {
            $dt = strtotime($dt_c)+86400;
            $dt_c= date('Y-m-d H:i:s',$dt);
        }
        }
    }

   //$stmt="<div class='ns-thumb'><img src='images/photo.jpg'/></div><div class='ns-content'><p><a href='#'>Zoe Moulder</a> accepted your invitation.</p></div>";

   $retComments = mysql_query("SELECT *FROM posts");
   while($comments = mysql_fetch_assoc($retComments)) 
   {
   	$post_id = $comments['post_id'];
   	$retcount = mysql_query("SELECT * FROM comments WHERE post_id='$post_id'");
   	$count = mysql_num_rows($retcount);
   	echo "data: { \"id\" :$post_id, \"count\" : $count},\n";
   }

$retval4 = mysql_query("select user_id,name,profile_pic from profile where status=1");
while($row4 = mysql_fetch_assoc($retval4))
{    
    $id=$row4['user_id'];
    $name=$row4['name'];
    $path=$row4['profile_pic'];
    if($id!=$username) {
        echo "data: {\"uid\":\"$id\",\"name\":\"$name\",\"path\":\"$path\"},\n";
    }
}
$retval5 = mysql_query("SELECT username,count(id) FROM `chat` WHERE (status='0' and tousername='".$username."') Group by username");
while($row5 = mysql_fetch_assoc($retval5))
{    
    $id=$row5['username'];
    $msgCount=$row5['count(id)'];
    if($id!=$username) {
        echo "data: {\"fromusername\":\"$id\",\"msgCount\":\"$msgCount\"},\n";
    }
}
echo "data: {\"null\":\"null\"}\n";
echo "data: ]\n\n";


flush();
?>