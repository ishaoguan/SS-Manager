<?php
require "config.php";
require "./src/security.php";

function echoandexit($str){
	echo $str;
	$GLOBALS['DB']->CloseConnection();
	die();
}

if ( (!empty($_POST["username"])) and (!empty($_POST["password"])) ) {
	$email		=	security_filter($_POST["username"]);
	$password 	=	security_filter($_POST["password"]);
	//$password=MD5($password.'ssmanager');

	if ($email=="admin") {
		if ($password==$GLOBALS['manager_password']) {
			session_start();
			$_SESSION['myemail']="admin";
			echoandexit("success_admin");
		} else {
			echoandexit("admin auth failed!"); 
		}
	}
	else
	{
		$count=count($DB->query("SELECT * FROM user WHERE email=? and pass=? and activated='1' ", array($email,$password)));
    	
    	if($count==1){
        	session_start();
        	$_SESSION['myemail']=$email;
        	$_SESSION['mypassword']=$password;
        	echoandexit("success_user");
    	} else {
	        echoandexit("user auth failed!");
	    }
	}
	
} else {
	echoandexit("no post data!");
}




?>