<?php 
$userid=$_SESSION['userid'];
date_default_timezone_set("Asia/Kolkata");
$dt = (new DateTime())->format('Y-m-d H:i:s');
if(isset($_POST['image_submit'])){

 function GetImageExtension($imagetype)
        {
          
          if(empty($imagetype))
          {
              return false;
          }
          switch($imagetype)
          {
              case 'image/bmp':
                return '.bmp';
              case 'image/gif':
                return '.gif';
              case 'image/jpeg':
                return '.jpg';
              case 'image/png':
                return '.png';
              default: return false;
          }
        }
      /*code to respond to the submission of image*/
      if(!empty($_FILES["fileUpload"]["name"]))
      {
         
          $file_name=$_FILES["fileUpload"]["name"];
          $temp_name=$_FILES["fileUpload"]["tmp_name"];
          $imgtype=$_FILES["fileUpload"]["type"];
          $ext= GetImageExtension($imgtype);
          $imagename=uniqid().$ext;
          $target_path = "posts/".$imagename;
         // echo $imagename;
          
          $pcontent=$_POST['image_title'];
         // echo $target_path;
          if(move_uploaded_file($temp_name,$target_path))
          {
              $image_upload="INSERT INTO posts (pimage,user_id,post_type,pcontent,ptime) values('$target_path','$userid','image','$pcontent','$dt')";
              mysql_query($image_upload);

              header("Location:dashboard.php");
              header("Refresh: 1; url=dashboard.php");
          }
      }

  
}
if(isset($_POST['url_submit'])){
	$url=$_POST['youtube_url'];
	$pcontent=$_POST['url_title'];
	$vid=split("=", $url);
	$videoid=$vid[1];
	if($videoid){
	$url_upload="INSERT INTO posts (pvideo,user_id,post_type,pcontent,ptime) values('$videoid','$userid','youtube_url','$pcontent','$dt')";
              mysql_query($url_upload);
              header("Location:dashboard.php");
              header("Refresh: 1; url=dashboard.php");
}
}

if(isset($_POST['status_submit'])){
	$pcontent=$_POST['status'];
  
	$status_upload="INSERT INTO posts (user_id,post_type,pcontent,ptime) values('$userid','status','$pcontent','$dt')";
              mysql_query($status_upload);
            

              header("Location:dashboard.php");
              header("Refresh: 1; url=dashboard.php");

}
?>