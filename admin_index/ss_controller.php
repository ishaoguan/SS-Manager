<?php
include("admin_auth.php");
include("config.php");

$action=$_GET['action'];

if ($action!='if_running') {
	admin_cookie_auth(True);
}

if ($action=='stop') ss_stop();
if ($action=='start') ss_start();
if ($action=='restart') ss_restart();
if ($action=='if_running') ajax_if_running();
if ($action=='refresh_log') refresh_log();
if ($action=='all_log') all_log();
if ($action=='update_config') update_config();


function ss_start(){
	//echo 'ssserver -c "'.$GLOBALS['json_path'].'" -d start --pid-file="shadowsocks.pid" --log-file="'.$GLOBALS['log_path'].'"'.' 2>&1';

	echo shell_exec('ssserver -c "'.$GLOBALS['json_path'].'" -d start --pid-file="shadowsocks.pid" --log-file="'.$GLOBALS['log_path'].'"'.' 2>&1');
	sleep(1);
	header("location: ./admin_index.php");
}

function ss_stop(){
	echo shell_exec('ssserver -d stop --pid-file="./shadowsocks.pid" 2>&1');
	sleep(1);
	header("location: ./admin_index.php");
}

function ss_restart(){
	echo shell_exec('ssserver -c "'.$GLOBALS['json_path'].'" -d restart --pid-file="shadowsocks.pid" --log-file="'.$GLOBALS['log_path'].'"'.' 2>&1');
	sleep(1);
	header("location: ./admin_index.php");
}

function ajax_if_running(){
	$pid_file_name='shadowsocks.pid';
	if (!file_exists($pid_file_name)){
		echo 'stopped';
	} else {
		$pid_file = fopen($pid_file_name, "r") or die("Unable to open file!");
		$pid = fread($pid_file,filesize($pid_file_name));
		fclose($pid_file);
		exec('ps -A |grep '.$pid , $outputs1);
		exec('ps -A |grep ssserver', $outputs2);
		if (count($outputs1)>0 and count($outputs2)>0){
			echo 'Running';
		} else {
			echo 'Stopped';
		}
	}
}

function refresh_log(){
	$path=$GLOBALS['log_path'];
	$log_text=shell_exec("tail -n 11 ".$path);
	echo $log_text;
}

function all_log(){
	$path=$GLOBALS['log_path'];
	echo nl2br(shell_exec("tac ".$path." 2>&1"));
}

function update_config(){
	
}

?>
