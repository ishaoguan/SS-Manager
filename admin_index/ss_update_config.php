<?php
include("admin_auth.php");
admin_cookie_auth(True);

include("global_variables.php");

$new_config=$_POST["config_code"];

$pos1=strpos($new_config,"'");
$pos2=strpos($new_config,"/");
$pos3=strpos($new_config,"\\");
if (!($pos1===False and $pos2===False and $pos3===False)) {
	die("<a href='./admin_index.php'>Illegal!");
}

shell_exec("echo '".$new_config."'>".$config_path."shadowsocks.json");
header("location: ./admin_index.php");

?>
