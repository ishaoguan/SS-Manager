<?php
include "admin_auth.php";
$username=$_POST["username"];
$password=$_POST["password"];
if ($username=="admin") {
	if ($password==$secret_password) {
		set_admin_cookie();
		header("location: ./admin_index.php");
	} else {
		header("location: ./login_error.php");
	}
} else {
	header("location: ./login_error.php");
}
 

?>
