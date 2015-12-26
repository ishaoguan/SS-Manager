<!DOCTYPE html>
<?php
	include("admin_auth.php");
	admin_cookie_auth(True);
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Shadow Manager</title>
  	<link rel="stylesheet" href="admin_index.css" media="screen" type="text/css" />
</head>

<body>
<!--*******************CURRENT CONFIG BLOCK**********************-->
	<div id="current_config">
		<h1>Current config</h1>
		<form action="./ss_update_config.php" method="POST">
		<textarea spellcheck='false' rows="20" name="config_code" id="config_textarea">
		
		</textarea>
		<input type="submit" id="config_update_button" value="Update config file" />
		</form>
	</div>
<!--*******************CURRENT STATUS BLOCK**********************-->
	<div id="current_status">
		<div id="status_prefix">
			<h1>Current status :</h1>
		</div>
		<div id="status_tag">
		<h1>
	
		</h1>
		</div>
	</div>

	<script type="text/javascript">
		if (document.getElementById('status_tag').innerHTML=="<h1>Running</h1>"){
			document.getElementById('status_tag').style.color="#3399cc";
		} else {
			document.getElementById('status_tag').style.color="#ee66aa";
		}
	</script>
<!--*******************SWICHERS BLOCK**********************-->
	<div id="swichers">
		<button id="start_button" onclick="ss_start();">Start</button>
		<button id="stop_button" onclick="ss_stop();">Stop</button>
	</div>
<!--*******************LOG BLOCK**********************-->
	<div id="log_block">
	<h1 id="log_prefix">Log</h1>
	<div id="log_buttons">
		<button id="log_refresh_button" onclick="log_refresh();">Refresh</button>
		<button id="all_log_button" onclick="show_all_logs();">Show all logs</button>
		<button id="sign_out_button" onclick="sign_out();">Sign out</button>
	</div>
	<textarea disabled spellcheck='false' rows="12" id="log_textarea">

	</textarea>
	</div>
<!--*******************BUTTONS EVENTS**********************-->
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
                	document.getElementById("status_tag").innerHTML = "<h1>"+xmlhttp.responseText+"</h1>";
			if (document.getElementById('status_tag').innerHTML=="<h1>Running</h1>"){
			document.getElementById('status_tag').style.color="#3399cc";
			} else {
			document.getElementById('status_tag').style.color="#ee66aa";
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
