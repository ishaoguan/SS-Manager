<?php
session_start();
$user=@$_SESSION['myemail'];

require "./../config.php";

$action=@$_GET['action'];

if ($action!='if_running') {
	if($user!="admin") {
		header("location: ./../index.php");
		die();
	}
}

if ($action=='stop') ss_stop();
if ($action=='start') ss_start();
if ($action=='restart') ss_restart();
if ($action=='if_running') ajax_if_running();
if ($action=='refresh_log') refresh_log();
if ($action=='all_log') all_log();

function ss_start(){
	//echo 'ssserver -c "'.$GLOBALS['json_path'].'" -d start --pid-file="shadowsocks.pid" --log-file="'.$GLOBALS['log_path'].'"'.' 2>&1';
	//echo shell_exec('ssserver -c "'.$GLOBALS['json_path'].'" -d start --pid-file="'.$GLOBALS['pid_path'].'" --log-file="'.$GLOBALS['log_path'].'"'.' 2>&1');
	//$result=shell_exec(eval $(ps -ef | grep "[0-9] python server\\.py m" | awk '{print "kill "$2}'))
	ss_stop();
	$cmd="nohup python ".$GLOBALS["run_path"]." >> ".$GLOBALS["log_path"]." 2>&1 &";
	echo shell_exec($cmd);

	header("location: ./admin_index.php");
}

function ss_stop(){
	//echo shell_exec('ssserver -d stop --pid-file="'.$GLOBALS['pid_path'].'" 2>&1');
	
	$cmd="eval $(ps -ef | grep \"[0-9] python ".$GLOBALS["run_path"]."\" | awk '{print \"kill \"$2}')";
	echo shell_exec($cmd);

	header("location: ./admin_index.php");
}

function ss_restart(){
	
}

function ajax_if_running(){
	/*
	if (!file_exists($GLOBALS['pid_path'])){
		echo 'stopped';
	} else {
		$pid_file = fopen($GLOBALS['pid_path'], "r") or die("Unable to open file!");
		$pid = fread($pid_file,filesize($GLOBALS['pid_path']));
		fclose($pid_file);
		exec('ps -A |grep '.$pid , $outputs1);
		exec('ps -A |grep ssserver', $outputs2);
		if (count($outputs1)>0 and count($outputs2)>0){
			echo 'Running';
		} else {
			echo 'Stopped';
		}
	}
	*/
	$cmd='ps -ef | grep "[0-9] python '.$GLOBALS["run_path"].'"';
	//echo $cmd."</br>";
	$result=shell_exec($cmd);
	//echo $result;
	if ($result=="") {
		echo "Stopped";
	} else {
		echo "Running";
	}
}

function refresh_log(){
	$path=$GLOBALS['log_path'];
	$log_text=shell_exec("tail -n 11 ".$path);
	echo nl2br($log_text);
}

function all_log(){
	$path=$GLOBALS['log_path'];
	echo nl2br(shell_exec("tac ".$path." 2>&1"));
}

?>
