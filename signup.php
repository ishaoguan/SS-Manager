<?php
require 'config.php';
require './src/class.phpmailer.php';
require './src/class.smtp.php';
require './src/security.php';

$action =	@$_POST['action'];
if($action=='sign_up') {
	sign_up();
} 
if($action=='get_token') {
	send_token();
} 
function sign_up(){
	$email	=	validate_email(@$_POST['email']);
	$pass  	=	security_filter(@$_POST['password']);
	$token	=	security_filter(@$_POST['token']);
	if (email_overlap($email)) {
		echo "email overlap";
		die();
	}
	$count=count($GLOBALS['DB']->query("SELECT * FROM user WHERE email=? and token=?", array($email,$token)));
    if($count>0){
        	echo "token auth success";
        	$result=$GLOBALS['DB']->query("UPDATE user SET activated='1', enable='1', pass=?, passwd='0000000' WHERE email=? and token=?", array($pass,$email,$token));
    } else {
	        echo "token auth fail";
	}
}
function send_token(){
	$email	=	validate_email(@$_POST['email']);
	if (email_overlap($email)) {
		echo "email overlap";
		die();
	}
    $mail = new PHPMailer(); 	//实例化 
	$mail->IsSMTP(); 			// 启用SMTP 
	$mail->Host 	= $GLOBALS['smtp_server']; 		//SMTP服务器 以163邮箱为例子 
	$mail->Port 	= $GLOBALS['smtp_server_port']; //邮件发送端口 
	$mail->SMTPAuth = true;  	//启用SMTP认证 
	$mail->CharSet  = "UTF-8"; 	//字符集 
	$mail->Encoding = "base64"; //编码方式 
	$mail->Username = $GLOBALS['smtp_user_mail'];  	//你的邮箱 
	$mail->Password = $GLOBALS['smtp_user_pass'];  	//你的密码 
	$mail->Subject 	= "NutLab SS Token"; 			//邮件标题 
	$mail->From 	= $GLOBALS['smtp_user_mail'];  	//发件人地址（也就是你的邮箱） 
	$mail->FromName = "NutLab";  		//发件人姓名 
	$address 		= $email;			//收件人email 
	$mail->AddAddress($address, "Dear");//添加收件人（地址，昵称） 
	$mail->IsHTML(true); 				//支持html格式内容  
	$token=generate_token();
	$mail->Body 	= "感谢您在我站注册了新帐号。<br/><br/>你的验证码为".$token; //邮件主体内容 
	if(!$mail->Send()) { 
  		//echo "token sending fail:" . $mail->ErrorInfo;
  		echo "token sending fail"; 
	} else { 
  		echo "token sending success"; 
	} 
	$count=count($GLOBALS['DB']->query("SELECT * FROM user WHERE email=? ", array($email)));
    	if($count>0){
        	$result=$GLOBALS['DB']->query("UPDATE user SET token=? WHERE email=?", array($token,$email));
    	} else {
	       	$result=$GLOBALS['DB']->query("INSERT INTO user (email,pass,passwd,u,d,transfer_enable,port,enable,activated,token) VALUES (?,'','','0','0','0',?,'0','0',?)", array($email,generate_port(),$token));
	    }
}
function email_overlap($str){
	$count=count($GLOBALS['DB']->query("SELECT * FROM user WHERE email=? and activated='1' ", array($str)));
    	if($count>0){
        	return 1;
    	} else {
	        return 0;
	    }
}
function generate_token(){
	return substr(MD5(rand(1000,2000)),0,5);
}
function generate_port(){
	do {
		$port=rand($GLOBALS['port_begin'],$GLOBALS['port_end']);
		$used=$GLOBALS['DB']->query("SELECT port FROM user");
		if (count($used) >= ($GLOBALS['port_end'] - $GLOBALS['port_begin'])){
			echo "Users are full";
			die();
		}
	} while (in_array($port, $used));
	return $port;
}
function validate_email($str){
	if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
		return $str;
	} else {
		echo "invalid email";
		die();
	}
}

?>