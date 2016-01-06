<?php
  session_start();
  $user=@$_SESSION['myemail'];
  if($user!="admin") {
    header("location: ./../index.php");
    die();
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Admin Home</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="admin_index.css">
<script src="http://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>

<body>


<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
        <div class="navbar-header">
          	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            	<span class="sr-only">Toggle navigation</span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
          	</button>
          	<span class="navbar-brand" onclick="location.reload();">SS-Manager</span>
        </div>
		<div id="navbar" class="collapse navbar-collapse">
        	<ul class="nav navbar-nav">
          		<li class="active"><a onclick="location.reload();">Home</a></li>
            	<li><a href="user_management.php">User Management</a></li>
        	</ul>
          <ul class="nav navbar-nav navbar-right">
              <li><a href="./sign_out.php">Log out</a></li>
          </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="mycontainer">

  <div class="page-header">
    <h2>
      Control&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="label label-success" id="status_tag">Status: Running</span>&nbsp;&nbsp;
      <button type="button" class="btn btn-primary" onclick="ss_start();">Start</button>&nbsp;&nbsp;
      <button type="button" class="btn btn-danger" onclick="ss_stop();">Stop</button>
    </h2>
  </div>

  <div class="page-header">
    <h2>
      Log&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="button" class="btn btn-default" onclick="log_refresh();">Refresh</button>&nbsp;
      <button type="button" class="btn btn-default" onclick="show_all_logs();">All Log</button>&nbsp;&nbsp;
    </h2> 
  </div>
  <div class="well" id="log_textarea"></div>
</div>

<script type="text/javascript">
    var t1 = window.setInterval(ajax_current_status,5000);
    var t2 = window.setInterval(ajax_refresh_log,5000);
    
    function ss_start(){
    window.location.href="./ss_controller.php?action=start";
    }
    function ss_stop(){
    window.location.href="./ss_controller.php?action=stop";
    }
    function log_refresh(){
    ajax_refresh_log();
    }
    function show_all_logs(){
    window.location.href="./ss_controller.php?action=all_log";
    }
    function sign_out(){
    window.location.href="./sign_out.php";
    }
    function ajax_current_status(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("status_tag").innerHTML = "Status: "+xmlhttp.responseText;
        if (document.getElementById('status_tag').innerHTML=="Status: Running"){
          document.getElementById('status_tag').className="label label-success";
        } else {
          document.getElementById('status_tag').className="label label-danger";
        }
            }
        }
        xmlhttp.open("GET", "ss_controller.php?action=if_running", true);
        xmlhttp.send();
    }

    function ajax_refresh_log(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                  document.getElementById("log_textarea").innerHTML = xmlhttp.responseText;
      }
        }
        xmlhttp.open("GET", "ss_controller.php?action=refresh_log", true);
        xmlhttp.send();
    }

    ajax_current_status();
    ajax_refresh_log();

</script>

</body>

</html>