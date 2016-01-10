<?php
session_start();
$user=@$_SESSION['myemail'];
if($user!="admin") {
	header("location: ./../index.php");
	die();
}
require './../config.php';
require './../src/security.php';

$action=$_POST['action'];
if ($action=='new') new_giftcode();
if ($action=='del') del_giftcode();
if ($action=='show_table') show_table();

function show_table(){
	$data = $GLOBALS['DB']->query("SELECT * FROM gift");
	echo json_encode($data);
}
function new_giftcode(){
	$amount=(int) $_POST['amount'];
	if ($amount<1) $amount=1;
	if ($amount>50) $amount=50;
	for ($i=1; $i<=$amount; $i++) {
		$code=rand(1,50000);
		$code=MD5($code);
		$s=rand(1,10);
		$code=substr($code, $s,10);
		$GLOBALS['DB']->query("INSERT INTO gift (code) VALUES (?)",array($code));
	}
}
function del_giftcode(){
	$id=(int) $_POST['id'];
	$GLOBALS['DB']->query("DELETE FROM gift WHERE id=? ",array($id));
}



?>