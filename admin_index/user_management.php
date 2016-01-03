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
<title>User Management</title>
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="user_management.css">
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
            <span class="navbar-brand" href="#">SS-Manager</span>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="admin_index.php">Home</a></li>
                <li class="active"><a href="#">User Management</a></li>
            </ul>
          <ul class="nav navbar-nav navbar-right">
              <li><a href="./sign_out.php">Log out</a></li>
          </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="mycontainer">
    <div class="page-header">
        <h1>
        Tables&nbsp;&nbsp;

        <button type="button" class="btn btn-default fn_btn" onclick="enter_new_mode();">New row</button>
        <button type="button" class="btn btn-default fn_btn" onclick="enter_ch_mode();change='delete';document.getElementById('ch_value').value='[DELETE]';">Delete a row</button>
        <button type="button" class="btn btn-default fn_btn" onclick="enter_ch_mode();change='u';document.getElementById('ch_value').value='0';">Upload->0</button>
        <button type="button" class="btn btn-default fn_btn" onclick="enter_ch_mode();change='d';document.getElementById('ch_value').value='0';">Download->0</button>
        <div id="dropdown1" class="dropdown fn_btn">
          <button class="btn btn-default dropdown-toggle fn_btn" type="button" data-toggle="dropdown">
            Make a change
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu">
            <li><a onclick="enter_ch_mode();change='email';">Email</a></li>
            <li><a onclick="enter_ch_mode();change='pass';">Password</a></li>
            <li><a onclick="enter_ch_mode();change='passwd';">SSPass</a></li>
            <li><a onclick="enter_ch_mode();change='port';">Port</a></li>
            <li><a onclick="enter_ch_mode();change='u';">Upload</a></li>
            <li><a onclick="enter_ch_mode();change='d';">Download</a></li>
            <li><a onclick="enter_ch_mode();change='transfer';">Transfer limit</a></li>
            <li><a onclick="enter_ch_mode();change='enable';">Enable</a></li>
          </ul>
        </div>
            
        <input class="form-control ch_btn" id="ch_id" type="text" placeholder="Id">
        <input class="form-control ch_btn" id="ch_value" type="text" placeholder="Value">
        <button type="button" class="btn btn-default ch_btn" id="ch_submit" onclick="submit_change();exit_ch_mode();">Submit</button>

        <button type="button" class="btn btn-default new_btn" onclick="submit_new();exit_new_mode();">Submit</button>

        </h1>
  </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Email</th>
                <th>Password</th>
                <th>SSPass</th>
                <th>Port</th>
                <th>Upload</th>
                <th>Download</th>
                <th>Transfer limit</th>
                <th>Enable</th>
              </tr>
            </thead>
            <tbody id="table">
            </tbody>
          </table>
</div>

<script type="text/javascript">

hide_ch_btn();
hide_new_btn();
ajax_get_table();

var change='';

function ajax_get_table(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      render_json(xmlhttp.responseText);
    }
  }
  xmlhttp.open("POST", "user_manipulate.php", true);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xmlhttp.send("action=show_table");
}

function submit_new(){
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "user_manipulate.php", false);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var new_email   = document.getElementById("new_email").value;
  var new_pass    = document.getElementById("new_pass").value;
  var new_passwd  = document.getElementById("new_passwd").value;
  var new_transfer= document.getElementById("new_transfer").value;
  var new_port    = document.getElementById("new_port").value;
  xmlhttp.send("action=new_row&new_email=" + new_email + "&new_pass=" + new_pass+ "&new_passwd=" + new_passwd+ "&new_port=" + new_port+ "&new_transfer=" + new_transfer);
}

function submit_change(){
  var id    = document.getElementById("ch_id").value;
  var value = document.getElementById("ch_value").value;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("POST", "user_manipulate.php", false);
  xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  if (change=='delete') {
    xmlhttp.send("action=delete_row&id=" + id);
  }
  if (change=='email') {
    xmlhttp.send("action=change_email&id=" + id + "&value=" + value);
  }
  if (change=='pass') {
    xmlhttp.send("action=change_pass&id=" + id + "&value=" + value);
  }
  if (change=='passwd') {
    xmlhttp.send("action=change_passwd&id=" + id + "&value=" + value);
  }
  if (change=='port') {
    xmlhttp.send("action=change_port&id=" + id + "&value=" + value);
  }
  if (change=='u') {
    xmlhttp.send("action=change_u&id=" + id + "&value=" + value);
  }
  if (change=='d') {
    xmlhttp.send("action=change_d&id=" + id + "&value=" + value);
  }
  if (change=='transfer') {
    xmlhttp.send("action=change_transfer&id=" + id + "&value=" + value);
  }
  if (change=='enable') {
    xmlhttp.send("action=change_enable&id=" + id + "&value=" + value);
  }
}

function render_json(response) {
    var arr = JSON.parse(response);
    var i;
    var out = "";

    for(i = 0; i < arr.length; i++) {
        out += "<tr><td>" +
        arr[i].id +
        "</td><td>" +
        arr[i].email +
        "</td><td>" +
        arr[i].pass +
        "</td><td>"+
        arr[i].passwd +
        "</td><td>"+
        arr[i].port +
        "</td><td>"+
        (Number(arr[i].u)/1024/1024).toFixed(2) + "MB" +
        "</td><td>"+
        (Number(arr[i].d)/1024/1024).toFixed(2) + "MB" +
        "</td><td>"+
        (Number(arr[i].transfer_enable)/1024/1024).toFixed(2) + "MB" +
        "</td><td>"+
        arr[i].enable +
        "</td></tr>";
    }
    document.getElementById("table").innerHTML = out;
}

function render_new_mode(){
  var html='<tr>\
                <td></td>\
                <td><input id="new_email"   class="form-control"></td>\
                <td><input id="new_pass"    class="form-control"></td>\
                <td><input id="new_passwd"  class="form-control"></td>\
                <td><input id="new_port"  class="form-control"></td>\
                <td>0MB</td>\
                <td>0MB</td>\
                <td><input id="new_transfer" class="form-control"></td>\
                <td>1</td>\
            </tr>';
  document.getElementById("table").innerHTML = html;
}

function hide_fn_btn(){
  $(".fn_btn").hide();
}
function show_fn_btn(){
  $(".fn_btn").show();
}
function hide_ch_btn(){
  $(".ch_btn").hide();
}
function show_ch_btn(){
  $(".ch_btn").show();
}
function hide_new_btn(){
  $(".new_btn").hide();
}
function show_new_btn(){
  $(".new_btn").show();
}
function enter_ch_mode(){
  show_ch_btn();
  hide_new_btn();
  hide_fn_btn();
}
function exit_ch_mode(){
  hide_ch_btn();
  hide_new_btn();
  show_fn_btn();
  ajax_get_table();
}
function enter_new_mode(){
  hide_ch_btn();
  show_new_btn();
  hide_fn_btn();
  render_new_mode();
}
function exit_new_mode(){
  hide_ch_btn();
  hide_new_btn();
  show_fn_btn();
  ajax_get_table();
}
</script>

</body>


</html>