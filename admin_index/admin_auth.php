<?php
$secret_password="smrutgersadmin";
function admin_cookie_auth($ifdie){
	$encoded_composition=$_COOKIE["pass"];
	$date=date("Ymd");
	$ip=$_SERVER['REMOTE_ADDR'];
	$composition=$date.$ip.$GLOBALS['secret_password'];
	#echo $composition;
	$correct_composition=base64_encode($composition);
	#echo $correct_composition;
	if ($encoded_composition==$correct_composition) {
		return True;
	} else {
		if ($ifdie) {
			die('<a href="../login.html">Permission denied.</a>');
		} else {
			return False;
		}
	}

}

function set_admin_cookie(){
	$date=date("Ymd");
	$ip=$_SERVER['REMOTE_ADDR'];
	$composition=$date.$ip.$GLOBALS['secret_password'];
	$correct_composition=base64_encode($composition);
	setcookie("pass",$correct_composition,time()+3600*6,'/');
}

function remove_admin_cookie(){
	setcookie("pass","",time()+3600*6,'/');
}

#echo admin_cookie_auth();
#set_admin_cookie();

?>
