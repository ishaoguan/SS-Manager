<?php
session_start();
$user=@$_SESSION['myemail'];
if($user==NULL) {
  header("location: ./../index.php");
  die();
}
require './../config.php';
require './../src/security.php';

if (@$_GET['action']=='get_vcode') {
    require './../src/vcode.php';
    $vcode = new Vcode(300, 40, 4);
    $_SESSION['code'] = $vcode->getcode();
    $vcode->outimg();
    die();
}
if ( (!empty($_POST["giftcode"])) and (!empty($_POST["vcode"])) ) {
    $giftcode=security_filter($_POST['giftcode']);
    $vcode=security_filter($_POST['vcode']);
    if (strtolower($vcode)!=strtolower($_SESSION['code'])){
        echo '<script>alert("CAPTCHA is wrong!");window.location.href="";</script>';
        die();
    }
    $count=count($DB->query("SELECT * FROM gift WHERE code=? ", array($giftcode)));   
    if($count>0){
        $DB->query("DELETE FROM gift WHERE code=? ", array($giftcode));
        $DB->query("UPDATE user SET transfer_enable = transfer_enable + 1000*1024*1024 WHERE email=? ", array($user));
        echo '<script>window.location.href="./index.php";</script>';
        die();
    } else {
        echo '<script>alert("Gift code is wrong!");window.location.href="";</script>';
        die();
    }

}

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Gift code</title>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="giftcode.css">
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
</head>

<body>

    <div class="container">
    <form class="form-signin" method="post">
        <h2 class="form-signin-heading">Input your gift code</h2>
        <label for="inputEmail" class="sr-only">Code</label>
        <input type="text" id="giftcode" name="giftcode" class="form-control" placeholder="Gift Code" required autofocus>
        <input type="text" id="vcode" name="vcode" class="form-control" placeholder="Input the CAPTCHA below" required autofocus>
        <img src="?action=get_vcode" onclick="this.src='?action=get_vcode&random='+Math.random()" />
        <!-- <div class="g-recaptcha" data-sitekey="6LfR7xQTAAAAAMAT9zExYdQyNIDMzHiyh6BTdWDv"></div> -->
        <button class="btn btn-lg btn-primary btn-block" id="submit" type="submit">Submit</button>
    </form>
    </div> <!-- /container -->


  
</body>

</html>