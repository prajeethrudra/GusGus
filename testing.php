<?php 

include 'config.php';


$userid=$_SESSION['userid'];

if($userid){
  if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    header("Location:logout.php");
}
include 'imageupload.php';
include 'profile.php';
include 'chatterbox.php';
$pic=mysql_query("SELECT * from profile where user_id='$userid'");

$result=mysql_fetch_assoc($pic);

?>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="css/ns-style-other.css" />
    <script src="js/modernizr.custom.js"></script>

    <meta http-equiv="refresh" content="1020">
    <link href="css/p.css" type="text/css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:700' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <link href="css/jquery.cssemoticons.css" media="screen" rel="stylesheet" type="text/css" />
  <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>
  <script src="js/jquery.cssemoticons.min.js" type="text/javascript"></script>
  
  
    <style>
    .content-switcher{
      display:none;
      height:100px;
      width:670px;
      background: white;
       
        }
    .content,.commentsDisplay{display:none;}
   
    
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
#hider{display: none;}
#hider,#shower{text-decoration: none;color: #56bc8a;padding-top: 4px;}   
#notifications::-webkit-scrollbar{
    width:8px;
    background-color:#f5f5f5;border-radius:10px;
    

} 
#notifications::-webkit-scrollbar-thumb{
    background-color: white;
    border-radius:10px;
}
#notifications::-webkit-scrollbar-thumb:hover{
    background-color:#56bc8a;
    border:1px solid #333333;display: block;
}
#notifications::-webkit-scrollbar-thumb:active{
    background-color:#56bc8a;
    border:1px solid #333333;display: block;
}
#notifications::-webkit-scrollbar-track{
      border:1px gray solid;
      border-radius:10px;
     -webkit-box-shadow:0 0 6px gray inset;
}
.ns-effect-thumbslider .ns-content {
  background-color:#2c4762;color:white;
  font-weight: lighter;
  padding: 0 40px 0 80px;
  height: 64px;
  line-height: 20px;
}
.modifier:hover > *{
  background-color: #56bc8a;
  color:#fff;
}

    </style>
      <script type="text/javascript">

$(function() { //When the document loads
  $(".modifier").bind("click", function() {
    $(window).scrollTop($("#comments_81").offset().top); //scroll to div with container as ID.
    return false; //Prevent Default and event bubbling.
  });
});

      </script>
      <script type="text/javascript">
    function emot()
    {
        $('.pavan').emoticonize({
        //delay: 800,
        //animate: false,
        //exclude: 'pre, code, .no-emoticons'
      });
     }
   
      
   
  </script>
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
     function showimagepreview2(input) {
      if (input.files && input.files[0]) {
      var filerdr = new FileReader();
      filerdr.onload = function(e) {
      $('#imgprvwe').attr('src', e.target.result);
      }
      filerdr.readAsDataURL(input.files[0]);
      }
    }
</script>
    <script>
    var intervalVar;

function hidecomments(postid){
    $("#"+postid).slideUp();
   $(".loadmore"+postid).show();
    $(".hidemore"+postid).hide();
    clearInterval(intervalVar);
}
 function selectElement(i){
 $(".content").show(); 
$(".content-switcher").hide();
$("#item"+i).show();
}
function showprofile(){
 $(".profile_information").toggle(); 
 $("#main").toggleClass("blur");

}
function showcomments(postid){
   $("#"+postid).slideDown();
  $(".hidemore"+postid).show();
  $(".loadmore"+postid).hide();
 

  
}
function setCommentsInterval(postid) {
  getComments(postid);
  intervalVar=setInterval(function() { getComments(postid); },1000);
  //console.log(intervalVar);                
}

function getComments(postid){
  
                        var request=new XMLHttpRequest();
                        if(!request)
                            request=new ActiveXObject(Microsoft.XMLHTTP);
                        request.open('POST','comments.php',false);                        
                        request.setRequestHeader('postid',postid);                        
                        request.send(null);                      
                        container=document.getElementById("comments_"+postid);   
                        console.log(request.getResponseHeader('dataprevcommentid')+" "+container.getAttribute('data-prev-cmnt-id'));
                        if(request.getResponseHeader('dataprevcommentid')!=container.getAttribute('data-prev-cmnt-id')) {
                          container.innerHTML+=request.responseText;
                          emot();
                          container.setAttribute('data-prev-cmnt-id',request.getResponseHeader('dataprevcommentid'));
                        }
                                                                      
}
function addComments(postid, userid, comment){
                        if(comment !== "\n" && comment !== "") { 
                            comment=comment.replace(/(\n|\n|\r)/gm,"");
                            var request=new XMLHttpRequest();
                            if(!request)
                              request=new ActiveXObject(Microsoft.XMLHTTP);
                            request.open('POST','addComments.php',false);                        
                            request.setRequestHeader('postid',postid);
                            request.setRequestHeader('userid',userid);  
                            request.setRequestHeader('comment',comment);                          
                            request.send(null);   
                      }
                        document.getElementById('comment'+postid).value="";

}
function setSession(variable, value) {
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "setSession.php?variable=" + variable + "&value=" + value, true);
        xmlhttp.send();
        }
    </script>
    <script>
  function tonePlay(){
       var audio = document.getElementById("audio");
       audio.play();
                 }
   </script>
    <script>
if(typeof(EventSource) !== "undefined") {
    setSession("prev_comment",0);
    setSession("prev_post",0);
    var source = new EventSource("notification.php");

    source.onmessage = function(event) {
       
       var json = JSON.parse(event.data);
       var prev_comment = 0;
       var prev_post = 0;
//console.log(json);
        for(var i=0;i<document.getElementById("chatarea").childElementCount*2;i++) {         
           if(document.getElementById("chatarea").childNodes[i]) {
               if(document.getElementById("chatarea").childNodes[i].nodeName==="DIV"){
                   resetUserStatus(document.getElementById("chatarea").childNodes[i]);
               }               
            }
        }

       for(var i=0;i<json.length-1;i++) {
           if(json[i].id) {               
               document.getElementById("comments_count_"+json[i].id).innerHTML = "<p>comments("+json[i].count+")</p>";          
           } else if(json[i].uid && document.getElementById("chatterman_status_"+json[i].uid).className!=="green_circle"){
               var chatterman='<div id="chatterman_'+json[i].uid+'" class="chatterman"  data-id="'+json[i].uid+'" data-name="'+json[i].name+'" onclick="javascript:addChatBox(this);displayChatBox(this);">\n\
                               <img src="'+json[i].path+'" class="chatpicture"/>\n\
                               <span class="chattername">'+json[i].name+'</span>\n\
                             <div id="chatterman_status_'+json[i].uid+'" class="green_circle"></div></div>';
                var msgCount=document.getElementById("chatterman_"+json[i].uid).getAttribute('data-msg-count');
               document.getElementById("chatarea").removeChild(document.getElementById("chatterman_"+json[i].uid));
               document.getElementById("chatarea").innerHTML=chatterman+document.getElementById("chatarea").innerHTML;               
               document.getElementById("chatterman_"+json[i].uid).setAttribute('data-msg-count',msgCount);
               document.getElementById("chatterman_status_"+json[i].uid).className="green_circle";
           } else if(json[i].fromusername) {
                  var child='<p style="color:red;background-color:white;border:2px solid white;border-radius:4px;position:absolute;width:5px;padding:0px 16px 0px 6px;margin-left:220px;margin-top:10px;">'+json[i].msgCount+'</p>';
                  var chattermanID=document.getElementById("chatterman_"+json[i].fromusername);   
                  console.log(chattermanID.getAttribute('data-msg-count')+" "+json[i].msgCount);               
                  //if(chattermanID.getAttribute('data-msg-count')!='null') {
                      if(chattermanID.getAttribute('data-msg-count')!=json[i].msgCount) {                        
                        tonePlay();
                    }
                  //}
                  chattermanID.removeAttribute('data-msg-count');
                  chattermanID.innerHTML=child+chattermanID.innerHTML;
           } else if(json[i].comment_id) {
             nameraja(json[i].notification);
             if(prev_comment<json[i].comment_id)
              prev_comment = json[i].comment_id;
          } else if(json[i].post_id) {
                nameraja(json[i].post_notification);
                if(prev_post<json[i].post_id)
                    prev_post = json[i].post_id;
          }
       }       
       if(prev_comment>0)
         setSession("prev_comment",prev_comment);     
       if(prev_post>0)
         setSession("prev_post",prev_post);    
      //document.getElementById("notifications").innerHTML = json[json.length-1].notifications + "<br>";  
      //nameraja(json[json.length-1].notifications);
    };
    
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
}
function resetUserStatus(object){
    var chattermanID=document.getElementById("chatterman_"+object.getAttribute('data-id'));
    var chatterman_status=document.getElementById("chatterman_status_"+object.getAttribute('data-id'));
    chatterman_status.className="red_circle";
    if(chattermanID.firstChild.nodeName==="P"){
        chattermanID.setAttribute('data-msg-count',chattermanID.firstChild.innerHTML);
        chattermanID.removeChild(chattermanID.firstChild);
    }    
}
</script>

</head>
<?php
$result5 = mysql_query("SELECT * FROM profile where user_id='$userid'");
    if($row5 = mysql_fetch_array($result5)) {
        $name = $row5['name'];
        $bday = $row5['bday'];
        //echo "<img src=",$row['profile_pic'],">";
    }
?>
<body>
<audio id="audio" src="images/tone.mp3" style="display:none;" ></audio>
<div class="maincontent">
<div id="heading" style="background: url(images/background.png);position:fixed;z-index:1000;">
      <p class="ourtitle">OTMM</p>
      <p class="ourtitleside">Gusa</p>
      <p class="ourtitleside">Gusalu</p>
      <div class="ourname"><?php echo $name;?></div>
     <a href="#" class="profile1" onclick="showprofile()">    </a>
      
      <a href="logout.php" class="logout">     </a>

          </div>
          <div class="profile_information">
          <div class="form-holder">
            <form method="POST" action="dashboard.php" enctype="multipart/form-data"/>
      <div class="field">
        <div class="right">Name:</div><div class="left"><input type="text" name="profilename" class="underline" value="<?=$name?>"/></div>
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
        <div class="right">Re-enter password:</div><div class="left"/><input type="password " name="password2" class="underline"/></div>
      </div>
      <div id="edit">
        <input type="submit" class="Sub" value="Save" style="float:left;margin-left:6px;" name="savechanges">
     </div>
    </form>
    </div>
          </div>

        <div id="main" style="float:left;margin-left:450px;">
    
    <div class="top" style="margin-top:60px;">
      <div class="profile" style="background:url('<?php echo $result['profile_pic'] ?>');
      background-repeat:no-repeat;background-size:100% 100%;"></div>
       
      <div class="post">
          <div class="content-switcher" id="item4">
          <form id="form2" method="post" action="dashboard.php">
            <textarea class="statusarea" name="status" placeholder="Whats on your mind..."></textarea>
            <input type="submit" class="Sub" value="Post" name="status_submit">
            </form>
          </div> 

          <div class="content-switcher" id="item1">
          <form id="form1" runat="server" style="padding:10px 0px 0px 10px;" action="dashboard.php" method="POST" enctype="multipart/form-data">
          <input type="text" name="image_title" style="float:left;width:650px; border-bottom:1px solid #ccc;border-top:none;border-left:none;border-right:none;line-height:30px;" placeholder="Title">
            <div class="form_image" style="clear:both;padding-top:5px;">
            <input type="file" name="fileUpload" onchange="showimagepreview2(this)" style="float:left;" />
              </div>
              <img id="imgprvwe" alt="uploaded image preview"/>
               <input type="submit" class="Sub2"  value="Post" name="image_submit">
            </form>
            </div>   

          <div class="content-switcher" id="item2">
          <form id="form3"  style="padding:10px 0px 0px 10px;" method="post" action="dashboard.php">
          <input name="url_title" type="text" style="float:left;width:650px; border-bottom:1px solid #ccc;border-top:none;border-left:none;border-right:none;line-height:30px;" placeholder="Title">
          <input name="youtube_url" type="text" style="float:left;width:650px; border-bottom:1px solid #ccc;border-top:none;border-left:none;border-right:none;line-height:30px;" placeholder="YouTube Url">
          <input type="submit" class="Sub"  value="Post" name="url_submit"/>
            </form>
            </div> 

          <div class="content-switcher" id="item3">
             <form id="form4"  style="padding:10px 0px 0px 10px;">
          this optipon is under construction
            </form>
          </div> 


        <div id="status" onclick="selectElement(4); return false;"></div>
        <div id="photo" onclick="selectElement(1); return false;"></div>
        <div id="video"  onclick="selectElement(2);"></div>    
        <div id="videoupload"  onclick="selectElement(3);"></div>

     </div>
    </div>
   
   <?php
   $results=mysql_query("SELECT * FROM posts ORDER BY post_id DESC ");
   while($get_results=mysql_fetch_assoc($results)){
      $type = $get_results['post_type'];
      $user = $get_results['user_id'];
      $post_id = $get_results['post_id'];
      $retcomment = mysql_query("SELECT * FROM comments WHERE post_id='$post_id'");
      $count = mysql_num_rows($retcomment);
      $pic2=mysql_query("SELECT profile_pic,name from profile where user_id='$user'");
      $result2=mysql_fetch_assoc($pic2);

      $pcontent = $get_results['pcontent'];

      if($type==='image') { 
         
          $pimage = $get_results['pimage'];

        ?>
           <div class="top" id="post_post_<?php echo $post_id;?>">
              <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
                
                <div class="ppost" style="" >
                <div class="content2" style="margin-top:-14px;">
                <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;"><?php echo $result2['name'];?> posted:-<br/><?=$pcontent?></p>
                <img src="<?php echo $pimage?>" class="postimage"/>
              </div>
              <div id="comments_count_<?php echo $post_id;?>"><p><?php echo "comments(".$count.")"; ?></p></div>
               <a href="javascript:setCommentsInterval('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>');"id="shower"  class="loadmore<?php echo $post_id ?>">Show Comments...</a> 
               <a href="javascript:hidecomments('<?php echo $post_id ?>');"  class="hidemore<?php echo $post_id ?>" id="hider">Hide Comments...</a>
              
             <div id="comments_<?php echo $post_id;?>" class="emoticons"> 
             :-)         
             </div>
             
             <div class="comments_section" style="width:700px;margin-left:-10px;height:60px;border-radius:4px;">
                
                <div class="comments" id="writercomments"style="width:680px;height:60px;background-color:none;">
                <?php echo $result['name'];?>
                <form action="post.php?postid=<?=$post_id?>" method="POST" enctype="multipart/form-data">
                  
                <textarea rows="4" cols="50" 
                onkeypress="javascript:if (event.keyCode==13||event.keyCode==13) { addComments('<?php echo $post_id ?>', '<?php echo $userid?>', this.value); getComments('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>'); }" type="text" 
                    placeholder="comment here" id="comment<?php echo $post_id ?>" class="commented" width="300" style="overflow:none;" /></textarea>
                <img src="images/camera-64.png" class="img-comment" onclick="javascript:document.getElementById('x').click();" />
                <input id="x" type="file" style="display:none;visibility:hidden;" name="filUpload" id="filUpload" onchange="showimagepreview(this)" style="float:left;" />
                </form>
                </div>
              </div>


            </div>
          </div>
    <?php  }
    if($type==='status') { 
      
      ?>
      <div class="top" id="post_post_<?php echo $post_id;?>">
      <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
   
     <div class="ppost" >
       <div class="content2" style="margin-top:-14px;">
        <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;"><?php echo $result2['name'];?> says:-</p>
        <p class="posttext">
        <?=$pcontent=str_replace("\r\n", "<br>", $pcontent); ?>
          </p>
       </div>
        <div id="comments_count_<?php echo $post_id;?>"><p><?php echo "comments(".$count.")"; ?></p></div>
        <a href="javascript:setCommentsInterval('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>');"id="shower"  class="loadmore<?php echo $post_id ?>">Show Comments...</a> 
               <a href="javascript:hidecomments('<?php echo $post_id ?>');"  class="hidemore<?php echo $post_id ?>" id="hider">Hide Comments...</a>
              
             <div id="comments_<?php echo $post_id;?>">          
             </div>
             <div class="comments_section" style="width:700px;margin-left:-10px;height:60px;border-radius:4px;">
                
                <div class="comments" id="writercomments"style="width:680px;height:60px;background-color:none;">
                <?php echo $result['name'];?>
                <form action="post.php?postid=<?=$post_id?>" method="POST" enctype="multipart/form-data">
                  
                <textarea rows="4" cols="50" 
                onkeypress="javascript:if (event.keyCode==13||event.keyCode==13) { addComments('<?php echo $post_id ?>', '<?php echo $userid?>', this.value); getComments('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>'); }" type="text" 
                    placeholder="comment here" id="comment<?php echo $post_id ?>" class="commented" width="300" style="overflow:none;" /></textarea>
                <img src="images/camera-64.png" class="img-comment" />
                </form>
                </div>
              </div>


            </div>
  </div>
      <?php
   }
    if($type==='youtube_url') { 
      $pvideo = $get_results['pvideo'];
      ?>
      <div class="top" id="post_post_<?php echo $post_id;?>">
      <div class="profile" style="background:url('<?php echo $result2['profile_pic'] ?>');background-repeat:no-repeat;background-size:100% 100%;"></div>
   
     <div class="ppost" >
       <div class="content2" style="margin-top:-14px;">
        <p style="width:650px; border:none;line-height:30px;color:#a7a7a7;"><?php echo $result2['name'];?> posted:-<br/><?=$pcontent?></p>
     <div class="postvideo">
     <iframe width="560" height="315" src="http://www.youtube.com/embed/<?=$pvideo?>" frameborder="0" allowfullscreen>
     </iframe></div>
       </div>
       <div id="comments_count_<?php echo $post_id;?>"><p><?php echo "comments(".$count.")"; ?></p></div>
         <a href="javascript:setCommentsInterval('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>');"id="shower"  class="loadmore<?php echo $post_id ?>">Show Comments...</a> 
               <a href="javascript:hidecomments('<?php echo $post_id ?>');"  class="hidemore<?php echo $post_id ?>" id="hider">Hide Comments...</a>
              
              <div id="comments_<?php echo $post_id;?>">          
             </div>
             
             <div class="comments_section" style="width:700px;margin-left:-10px;height:60px;border-radius:4px;">
                
                <div class="comments" id="writercomments"style="width:680px;height:60px;background-color:none;">
                <?php echo $result['name'];?>
                <form action="post.php?postid=<?=$post_id?>" method="POST">
                  
                <textarea rows="4" cols="50" 
                onkeypress="javascript:if (event.keyCode==13||event.keyCode==13) { addComments('<?php echo $post_id ?>', '<?php echo $userid?>', this.value); getComments('<?php echo $post_id ?>');showcomments('<?php echo $post_id ?>'); }" type="text" 
                    placeholder="comment here" id="comment<?php echo $post_id ?>" class="commented" width="300" style="overflow:none;" /></textarea>
                <img src="images/camera-64.png" class="img-comment" />
                </form>
                </div>
              </div>


            
     </div>
  </div>
      <?php
   }

 }

   ?>

  </div>

 </div>

   <div   style="position:fixed;max-height:830px; width:400px;">
    
    <div id="notifications" style="max-height:800px;overflow-y:scroll;margin-top:65px;"></div>
  </div>

  
  


        
  
  <script src="js/classie.js"></script>
    <script src="js/notificationFx.js"></script>
    <script>
      function nameraja(msg) {
      setTimeout( function() {
              var notification = new NotificationFx({
              wrapper : document.getElementById( 'notifications' ),
              message :msg, //'<div class="ns-thumb"><img src="images/photo.jpg"/></div><div class="ns-content"><p><a href="#">Zoe Moulder</a> accepted your invitation.</p></div>',
              layout : 'other',
              ttl : 10000000,
              effect : 'thumbslider',
              type : 'notice', // notice, warning, error or success
             
            });

            // show the notification
            notification.show();

          }, 3000 );      
      }
 
    function closeit(cid){
      $("#"+cid).hide();
     // console.log(cid);

     } 
     function closepost(cid){
      $("#post_"+cid).hide();
    //  console.log(cid);

     } 


     
    </script>

  <script>
    $("#top").click(function(){
     // console.log("hello");
      $(window).scrollTop("0px");
    })
  </script>
 
</body>
</html>
<?php }
else
{
header("Location:login.php");  
 } ?>