<?php

$dir_path = "/var/ss_manager";
$pid_path = $dir_path."/shadowsocks2.pid";
$log_path = $dir_path."/shadowsocks2.log";
$run_path = $dir_path."/shadowsocks-manyuser/servers.py";


$manager_password="admin";

define('DBHost', 'localhost');
define('DBName', 'shadowsocks');
define('DBUser', 'ssmanager');
define('DBPassword', 'ssmanager');
require(dirname(__FILE__)."/src/PDO.class.php");
$DB = new Db(DBHost, DBName, DBUser, DBPassword);


?>
