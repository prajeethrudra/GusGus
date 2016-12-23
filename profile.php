<?php
    $user_id=$_SESSION['userid'];
  if(isset($_POST['savechanges'])) {
    //create connection
      $pname = $_POST['profilename'];
      $pbday = $_POST['bday'];
     
     mysql_query("UPDATE profile SET name = '$pname', bday = '$pbday' WHERE user_id = '$user_id'") ;
       $p_pwd1 = $_POST['password1'];
       $p_pwd2 = $_POST['password2'];
       if($p_pwd1&&($p_pwd1==$p_pwd2)) {
           mysql_query("UPDATE profile SET password = '$p_pwd1' WHERE user_id = '$user_id'") ;
       }
       /*function to get image extension*/
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
      if(!empty($_FILES["filUpload"]["name"]))
      {
          $file_name=$_FILES["filUpload"]["name"];
          $temp_name=$_FILES["filUpload"]["tmp_name"];
          $imgtype=$_FILES["filUpload"]["type"];
          $ext= GetImageExtension($imgtype);
          $imagename="$user_id".$ext;
          $target_path = "profile_pics/".$imagename;
          if(move_uploaded_file($temp_name,$target_path))
          {
            
              $image_upload="UPDATE profile SET profile_pic = '$target_path' WHERE user_id = '$user_id'";
              mysql_query($image_upload);
          }
      }
  } 
   $result = mysql_query("SELECT * FROM profile where user_id='$user_id'");
    if($row = mysql_fetch_array($result)) {
        $name = $row['name'];
        $bday = $row['bday'];
        //echo "<img src=",$row['profile_pic'],">";
    }
 
?>
