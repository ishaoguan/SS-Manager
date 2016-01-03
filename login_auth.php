<?php
require "config.php";

function checkemail($str){
    return (preg_match('/^[_.0-9a-z-a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,4}$/',$str))?true:false;
}

function echoandexit($str){
	echo $str;
	$GLOBALS['DB']->CloseConnection();
	die();
}

if ( (!empty($_POST["username"])) and (!empty($_POST["password"])) ) {
	$email=$_POST["username"];
	$password=$_POST["password"];
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
		if (!checkemail($email)) {
			echoandexit("illegal email!");
		}

		$count=count($DB->query("SELECT * FROM user WHERE email=? and pass=?", array($email,$password)));
    	
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