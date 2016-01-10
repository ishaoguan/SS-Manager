<?php
session_start();
$user=@$_SESSION['myemail'];
if($user==NULL) {
  header("location: ./../index.php");
  die();
}
require './../config.php';
$which=@$_GET['action'];
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Change Password</title>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="ch_password.css">
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>

<body>
	<div class="container">
      <div class="form-signin">
        <h3 class="form-signin-heading"><?php echo $user;?></h3>
        <label for="inputEmail" class="sr-only">Old password</label>
        <input type="password" id="old_password" class="form-control" placeholder="Old password" required autofocus>
        <label for="inputPassword" class="sr-only">New Password</label>
        <input type="password" id="new_password" class="form-control" placeholder="New Password" required>
        <button class="btn btn-lg btn-primary btn-block" onclick="submit();">Change</button>
      </div>
    </div> <!-- /container -->
    <script type="text/javascript">
    	<?php
    		if ($which=="login_password"){
    			echo "var which='login';";
    		}
    		if ($which=="ss_password"){
    			echo "var which='ss';";
    		}
    	?>
    function submit(){
    	var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            if (xmlhttp.responseText == "old login password is wrong") {
            	alert("The old login password you input is wrong!");
          	} else if (xmlhttp.responseText == "old ss password is wrong") {
            	alert("The old ss password you input is wrong!");
          	} else if (xmlhttp.responseText == "success") {
            	alert("Success!");
            	if (which=="login") {
            		window.location.href='./sign_out.php';
            	}
            	if (which=="ss") {
            		window.location.href='./index.php';
            	}
          	} else {
            	alert(xmlhttp.responseText);
          	}
        }
      	}
      	xmlhttp.open("POST", "ch_password_backend.php", false);
      	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      	var oldpass=document.getElementById("old_password").value;
      	var newpass=document.getElementById("new_password").value;
      	xmlhttp.send("which=" + which + "&old=" + oldpass + "&new=" + newpass);
    }
    </script>
</body>
</html>
