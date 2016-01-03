<?php
session_start();
$user=@$_SESSION['myemail'];
if($user==NULL) {
  header("location: ./../index.php");
  die();
}
if($user=="admin") {
  header("location: ./../admin_index/admin_index.php");
  die();
}
require './../config.php';

$row = $DB->row("SELECT * FROM user WHERE email=?",array($user));
$email=$row['email'];
$sspass=$row['passwd'];
$ssflow=$row['u']+$row['d'];
$port=$row['port'];
$totalflow=$row['transfer_enable'];
$errowinfo=NULL;
$successinfo=NULL;
$ssflow=sprintf("%.2f", $ssflow/(1024*1024));
$totalflow=sprintf("%.0f", $totalflow/(1024*1024));
$enable=$row['enable'];

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>用户中心-404 NOT FOUND</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="style.css">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">
      <div class="header">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li><a href="help.html" target="_blank">使用帮助</a></li>
            <li>
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo $email; ?><span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="sign_out.php">退出</a></li>
            </ul>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">用户中心</h3>
      </div>

      <div class="row marketing">
        <div class="alert alert-success" role="alert">
          <h4><strong>二维码</strong><small>&nbsp;&nbsp;APP可以扫描下面的二维码快速完成配置</small></h4> 
        </div>
          <p>qrcode.php</p>
        
        <div class="alert alert-info" role="alert">
          <strong>服务器</strong> &nbsp;&nbsp;&nbsp;<span class="tab">45.55.12.93</span>
        </div>
        <div class="alert alert-info" role="alert">
          <strong>加密方式</strong> <span class="tab">AES-256-CFB</span>
        </div>
        <div class="alert alert-info" role="alert">
          <strong>SS端口</strong> &nbsp;&nbsp;&nbsp;<span class="tab"><?php echo $port; ?></span>
        </div>
        <div class="alert alert-info" role="alert">
          <strong>SS密码</strong> &nbsp;&nbsp;&nbsp;<span class="tab"><?php echo $sspass; ?></span>
        </div>
        <div class="alert alert-info" role="alert">
          <strong>流量</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="tab"><?php echo $ssflow.'/'.$totalflow.'MB' ?></span>
        </div>


        
      </div>


      <footer class="footer">
        <p style="font-size:.9em">&copy; SS-Manager 2015 <span style="float:right;font-size:.8em">by <a href="http://nutlabweb.com" target="_blank">NK</a></span></p>
      </footer>

    </div> <!-- /container -->


</body>
</html>