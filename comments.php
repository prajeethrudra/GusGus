<?php
include 'config.php';
$pid=$_SERVER["HTTP_POSTID"];
$prevcommentid=$_SERVER["HTTP_PREVCOMMENTID"];
$retval = mysql_query("SELECT * FROM comments WHERE post_id='$pid' AND s_no>'$prevcommentid'");
    $count=mysql_num_rows($retval);
$cmnt_id=0;
$stmt="";
  while($row = mysql_fetch_assoc($retval))
  {
    $post_id = $row['post_id'];
    $commenter_id = $row['user_id'];
    $comment = $row['comment'];
    $cmnt_id=$row['s_no'];
    $retval1 = mysql_query("SELECT * from profile WHERE user_id='$commenter_id'");
      $row2 = mysql_fetch_assoc($retval1);
      $pp=$row2['profile_pic'];
      $name = $row2['name'];           
      $stmt.="<div id='comment_".$cmnt_id."' class='comments_section' style='width:700px;margin-left:0px;border-top:1px solid #ccc;height:60px;'>";
      $stmt.="<div class='commenter_pic' style='background:url(".$pp.");background-repeat:no-repeat;background-size:100% 100%;margin-left:40px;'></div>";
      $stmt.="<div class='comments' style='background-color:transparent;width:400px;' >";
      $stmt.=$name; 
      $stmt.=':-<br/>';
      $stmt.="<div style='font-size:14px;padding-top:4px;color:#000;overflow-wrap: break-word;' class='pavan'>".$comment."</div></div></div>";
      header("dataprevcommentid:".$cmnt_id);
}
if(!$prevcommentid) {
  header("dataprevcommentid:0");
} else if($cmnt_id==0){
  header("dataprevcommentid:".$prevcommentid);
}
$stmt.="";
echo $stmt;
?>