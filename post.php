<?php 
include 'config.php';
$userid=$_SESSION['userid'];
if($userid){
$post_id = $_GET['postid'];
$pic=mysql_query("SELECT * from profile where user_id='$userid'");
$result=mysql_fetch_assoc($pic);

?>
<html>
<head>
		<link href="css/p.css" type="text/css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <style>
    .content-switcher{
      display:none;
      height:100px;
      width:670px;
      background: white;
       
        }
    .content{display:none;}
   
    
    .caption{
    margin-top: 60px;
    display: none;
    }
    #status:hover.caption{
 display: block;
    }
    .profile_information{
      display: none;
      width:400px;height: 640px;background: #f5f5f5;z-index:999;padding: 6px;
      float: left;position: absolute;margin: auto;margin-left: 1000px;border-radius: 5px;

      }
      .blur{
        opacity: 0.2;
    filter: alpha(opacity=20);
      }
      .field {
        padding: 6px;}
.underline{border-bottom:1px solid #ccc;border-top:none;border-left:none;border-right:none;line-height:30px;}

    </style>
    <script type="text/javascript">
      function showimagepreview(input) {
      if (input.files && input.files[0]) {
      var filerdr = new FileReader();
      filerdr.onload = function(e) {
      $('#imgprvw').attr('src', e.target.result);
      }
      filerdr.readAsDataURL(input.files[0]);
      }
    }
    function showprofile(){
 $(".profile_information").toggle(); 
 $("#main").toggleClass("blur");

}
</script>
    <script>

 function selectElement(i){
 $(".content").show(); 
$(".content-switcher").hide();
$("#item"+i).show();
}
    </script>
</head>

<body>
<div id="heading">
      <p class="ourtitle">OTMM</p>
      <p class="ourtitleside">Gusa</p>
      <p class="ourtitleside">Gusalu</p>
      <a href="#" class="profile1" onclick="showprofile()">    </a>
      
      <a href="logout.php" class="logout">     </a>

          </div>
          <div class="profile_information">
          <div class="form-holder">
            <form method="POST" action="dashboard.php" enctype="multipart/form-data"/>
      <div class="field">
        <div class="right">Name:</div><div class="left"><input type="text" name="profilename" class="underline" value="<?=$result['name']?>"/></div>
      </div>
      <div class="field">
        <div class="right">Profile pic:</div><div class="left">
         <input type="file" name="filUpload" id="filUpload" onchange="showimagepreview(this)" style="float:left;" />
        <img id="imgprvw" alt="uploaded image preview"/>
        </div>
         
      </div>
      <div class="field">
        <div class="right">Birthday:</div><div class="left"><input type="date" name="bday" value="<?=$bday?>" class="underline"></div>
      </div>
      <div class="field">
        <div class="right">Enter new password:</div><div class="left"/><input type="password" name="password1" class="underline"/></div>
      </div>
      <div class="field">
        <div class="right">Re-enter password:</div><div class="left"/><input type="password" name="password2" class="underline"/></div>
      </div>
      <div id="edit">
        <input type="submit" class="Sub" value="Save" style="float:left;margin-left:6px;" name="savechanges">
     </div>
    </form>
    </div>
          </div>

        <div id="main">
   
   <?php
   $results=mysql_query("SELECT * FROM posts WHERE post_id='$post_id'");
   if($get_results=mysql_fetch_assoc($results)){
      $type = $get_results['post_type'];
      $user = $get_results['user_id'];
     $pic2=mysql_query("SELECT profile_pic from profile where user_id='$user'");
      $result2=mysql_fetch_assoc($pic2);

      $pcontent = $get_results['pcontent'];

      if($type==='image') { 
         
          $pimage = $get_results['pimage'];

        ?>
           <div class="top">
              <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
                <div class="ppost">
                <div class="content2" style="margin-top:-14px;">
                <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;"><?=$pcontent?></p>
                <img src="<?php echo $pimage?>" class="postimage"/>
              </div>      
            </div>
          </div>
    <?php  }
    if($type==='status') { 
      
      ?>
      <div class="top">
      <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
   
     <div class="ppost">
       <div class="content2" style="margin-top:-14px;">
        <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;">says:-</p>
        <p class="posttext">
        <?=$pcontent?>
          </p>
       </div>
      
     </div>
  </div>
      <?php
   }
    if($type==='youtube_url') { 
      $pvideo = $get_results['pvideo'];
      ?>
      <div class="top">
      <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
   
     <div class="ppost">
       <div class="content2" style="margin-top:-14px;">
        <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;"><?=$pcontent?></p>
     <div class="postvideo">
     <iframe width="560" height="315" src="http://www.youtube.com/embed/<?=$pvideo?>" frameborder="0" allowfullscreen>
     </iframe></div>

     

       </div>
      
     </div>

  </div>
      <?php
   }?>
   <?php
  if(isset($_POST['submit']))
  {

    $comment = $_POST['comment'];
    if($comment){
    mysql_query("INSERT INTO comments (post_id,user_id,comment) VALUES ('$post_id','$userid','$comment')");}
  }

  $retval = mysql_query("SELECT * FROM comments WHERE post_id='$post_id'");

  while($row = mysql_fetch_assoc($retval))
  {
    $post_id = $row['post_id'];
    $commenter_id = $row['user_id'];
    $comment = $row['comment'];
    $retval1 = mysql_query("SELECT * from profile WHERE user_id='$commenter_id'");
      $row2 = mysql_fetch_assoc($retval1);
      $name = $row2['name'];?>
      <div class="comments_section">
          <div class="commenter_pic" style="background:url('<?php echo $row2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
         <div class="comments" style="color:#56bc8a;" >
          <?php echo $name; echo ':-<br/>';?>
    <div style="font-size:14px;padding-top:4px;color:#000;"><?php
    echo $comment;?></div>
         </div>
      </div>
      <?php
  } 
   $pic=mysql_query("SELECT * from profile where user_id='$userid'");
   $result=mysql_fetch_assoc($pic);
?>
   <div class="comments_section">
          <div class="commenter_pic" style="background:url('<?php echo $result['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
         <div class="comments">
          <?php echo $result['name']; echo '<br>';?>
            <form action="post.php?postid=<?=$post_id?>" method="POST">
                <textarea type="text" placeholder="comment here" name="comment" class="commented" /></textarea>
                <input type="submit" value="comment" name="submit" class="Sub" style="margin-right:10px" />
            </form>
        </div>
  </div>
       


 <?php }

   ?>
      
	</div>
</body>
</html>
<?php }
else
{
header("Location:login.php");  
 } ?>