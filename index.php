<?php
	session_start();
	$user=@$_SESSION['myemail'];
	if($user==NULL) {
		header("location: status.html");
		die();
	} elseif ($user=="admin") {
		header("location: ./admin_index/admin_index.php");
		die();
	} else {
		header("location: ./user_index/index.php");
		die();
	}
?>