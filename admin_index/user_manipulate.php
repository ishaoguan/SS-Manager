<?php
session_start();
$user=@$_SESSION['myemail'];
if($user!="admin") {
	header("location: ./../index.php");
	die();
}
require './../config.php';

$action = @$_POST['action'];
/*
$id 	= @$_POST['id'];
$value 	= @$_POST['value'];
$new_email		= @$_POST['new_email'];
$new_pass 		= @$_POST['new_pass'];
$new_passwd 	= @$_POST['new_passwd'];
$new_port 		= @$_POST['new_port'];
$new_transfer 	= @$_POST['new_transfer'];
*/

if ($action=='show_table') 				show_table();
if ($action=='delete_row') 				delete_row();
if ($action=='new_row')					new_row();
if (preg_match('/change/', $action)) 	change($action);


function show_table(){
	$data = $GLOBALS['DB']->query("SELECT * FROM user");
	echo json_encode($data);
}

function delete_row(){
	$id = (int) @$_POST['id'];
	$GLOBALS['DB']->query("DELETE FROM user WHERE id=?",array($id));
}

function change($action){
	$id = (int) @$_POST['id'];
	$value = @$_POST['value'];

	if ($action=='change_email') {
		$GLOBALS['DB']->query("UPDATE user SET email = ? WHERE id = ?",array($value,$id));
	}
	if ($action=='change_pass') {
		$GLOBALS['DB']->query("UPDATE user SET pass = ? WHERE id = ?",array($value,$id));
	}
	if ($action=='change_passwd') {
		$GLOBALS['DB']->query("UPDATE user SET passwd = ? WHERE id = ?",array($value,$id));
	}
	if ($action=='change_port') {
		$GLOBALS['DB']->query("UPDATE user SET port = ? WHERE id = ?",array($value,$id));
	}
	if ($action=='change_u') {
		$GLOBALS['DB']->query("UPDATE user SET u = ? WHERE id = ?",array(((int)$value)*1024*1024,$id));
	}
	if ($action=='change_d') {
		$GLOBALS['DB']->query("UPDATE user SET d = ? WHERE id = ?",array(((int)$value)*1024*1024,$id));
	}
	if ($action=='change_transfer') {
		$GLOBALS['DB']->query("UPDATE user SET transfer_enable = ? WHERE id = ?",array(((int)$value)*1024*1024,$id));
	}
	if ($action=='change_enable') {
		$GLOBALS['DB']->query("UPDATE user SET enable = ? WHERE id = ?",array($value,$id));
	}
}

function new_row(){
	$new_email		= @$_POST['new_email'];
	$new_pass 		= @$_POST['new_pass'];
	$new_passwd 	= @$_POST['new_passwd'];
	$new_port		= @$_POST['new_port'];
	$new_transfer 	= @$_POST['new_transfer'];
	$new_transfer	= ((int) $new_transfer)*1024*1024;
	$GLOBALS['DB']->query("INSERT INTO user (email,pass,passwd,port,transfer_enable) VALUES (?,?,?,?,?)",array($new_email,$new_pass,$new_passwd,$new_port,$new_transfer));
}


?>