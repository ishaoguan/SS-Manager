<?php

$dir_path = "/var/ss_manager";
$pid_path = $dir_path."/shadowsocks.pid";
$log_path = $dir_path."/shadowsocks.log";
$run_path = $dir_path."/shadowsocks-manyuser/servers.py";

$manager_password="";

$port_begin	=	8801;
$port_end	=	8899;

$smtp_server 		=	"";
$smtp_server_port	=	25;
$smtp_user_mail		=	"";
$smtp_user_pass 	=	"";

define('DBHost', '');
define('DBName', '');
define('DBUser', '');
define('DBPassword', '');
require(dirname(__FILE__)."/src/PDO.class.php");
$DB = new Db(DBHost, DBName, DBUser, DBPassword);


?>
