<?php
function security_filter($str){
	if (preg_match("(,| |'|\")", $str)) {
		echo "security check fail";
		die();
	} else {
		return $str;
	}
}
?>