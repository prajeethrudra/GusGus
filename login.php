<?php
include 'config.php'; 


	if($_POST) {
		//create connection
 		
			
		$user = $_POST['username'];
		$pass = $_POST['password'];

		$result = mysql_query("SELECT * FROM profile where user_id='$user' and password='$pass'");
		
		if($row = mysql_fetch_array($result)) {
				echo "login successful";
		$_SESSION['LAST_ACTIVITY'] = time(); 
		$_SESSION['userid']=$user;
		mysql_query("UPDATE profile SET status = '1' WHERE user_id = '$user'");
		header('Location:dashboard.php');
		}
		
	
	}	
?>
<html>
<head>
	<title>
		OTMM Gusa Gusalu
	</title>

    <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
	<style type="text/css">
	body{
  background: url(images/background.png);
  background-size: 100% 100%;
  font-family: 'Montserrat', sans-serif;
}
#main{
  width:800px;
  margin:auto;
  overflow:hidden;
  background: #2c4762;
  padding-left: 40px;
  padding-top: 20px;
  border-radius:20px; 
}
.project_heading {
  position:relative;
  width:960px;
  height:100px;
  background-color:;
  margin-left: 640px;
  margin-bottom:20px;
  border-radius:10px;
  overflow:hidden;
  padding-left: 10px;
  margin-top: 240px;
}
#bigdada{
	font-family: 'Montserrat', sans-serif;font-weight: bold;
  color:white;
  font-size: 100px;margin-top: 0px;float: left;
	}
	.version{font-family: 'Pacifico', cursive;color: white;font-style: normal;
	position:absolute;margin-top: -40px;margin-left: 1080px;line-height: 20px;font-size: 20px;}

.ourtitleside{font-family: 'Pacifico', cursive;line-height: 10px;color: white;font-style: normal;padding-top:10px; 
font-size: 24px;}
.ourtitleside2{font-family: 'Pacifico', cursive;line-height: 10px;color: white;font-style: normal;padding-top:0px; font-size: 24px;}
}

.adjuster
{
	float: left;border-radius: 5px;
}
.Sub{
  background-color: #56bc8a;
  width: 80px;
  height: 40px;
  border: none;
  font-family: 'Montserrat', sans-serif;
  color: white;
  float: right;margin-right: 40px;
  box-shadow: 0px 2px 2px black;
  border-radius: 25px;
}
	</style>

</head>
<body>
<div class="project_heading"><p id="bigdada">OTMM</p> 
	 <p class="ourtitleside">Gusa</p>
      <p class="ourtitleside2">Gusalu</p>
      </div>
      <p class="version">Version 2.3 ( Pani Puri )</p>
	<div id="main">
	  
	  <form method="POST" action="login.php">
			<input type="text" name="username" placeholder="UserName" class="adjuster" 
			style="border-radius: 25px;height:40px;width: 300px;padding-left:20px;" />
			<input type="password" name="password" placeholder="Password" class="adjuster" 
			style="border-radius: 25px;height:40px;width: 300px;padding-left:20px;margin-left:20px;"/>
		<input type="submit" class="Sub" name="login" value="login">
	
	  </form>
	</div>

</body>
</html>
