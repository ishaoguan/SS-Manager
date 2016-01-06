<?php
session_start();
$user=@$_SESSION['myemail'];
if($user==NULL) {
  header("location: ./../index.php");
  die();
}
require './../config.php';
require './../src/security.php';

$which	=	security_filter(@$_POST['which']);
$old	=	security_filter(@$_POST['old']);
$new	=	security_filter(@$_POST['new']);

if ($which=="login") {
	$count=count($DB->query("SELECT * FROM user WHERE email=? and pass=? and activated='1' ", array($user,$old)));
	if($count==1){
		$result=$DB->query("UPDATE user SET pass=? WHERE email=?",array($new,$user));
		echo "success";
    } else {
    	echo "old login password is wrong";
	}
}
if ($which=="ss") {
	$count=count($DB->query("SELECT * FROM user WHERE email=? and passwd=? and activated='1' ", array($user,$old)));
	if($count==1){
		$result=$DB->query("UPDATE user SET passwd=? WHERE email=?",array($new,$user));
		echo "success";
    } else {
    	echo "old ss password is wrong";
	}
}


?>