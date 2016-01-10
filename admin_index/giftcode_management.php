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
<title>Gift Code</title>
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.0/css/bootstrap.min.css">
<link rel="stylesheet" href="giftcode_management.css">
<script src="https://cdn.bootcss.com/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
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
                <li><a href="admin_index.php">Home</a></li>
                <li><a href="user_management.php">User Management</a></li>
                <li class="active"><a onclick="location.reload();">Gift Code</a></li>
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

        <button type="button" class="btn btn-default fn_btn" onclick="enter_new_mode();">New</button>
        <button type="button" class="btn btn-default fn_btn" onclick="enter_del_mode();">Delete</button>
        
        <input class="form-control new_btn" id="new_num" type="text" placeholder="How many?" onkeydown = "if (event.keyCode == 13) document.getElementById('new_submit').click()">
        <button type="button" class="btn btn-default new_btn" id="new_submit" onclick="submit_new();exit_new_mode();">Submit</button>

        <input class="form-control del_btn" id="del_id" type="text" placeholder="Id" onkeydown = "if (event.keyCode == 13) document.getElementById('del_submit').click()">
        <button type="button" class="btn btn-default del_btn" id="del_submit" onclick="submit_del();exit_del_mode();">Submit</button>
        
        </h1>
    </div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Gift code</th>
              </tr>
            </thead>
            <tbody id="table">
            </tbody>
          </table>
</div>
<script type="text/javascript">
$(".del_btn").hide();
$(".new_btn").hide();
ajax_get_table();

function ajax_get_table(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            render_json(xmlhttp.responseText);
        }
    }
    xmlhttp.open("POST", "giftcode_manipulate.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("action=show_table");
}
function submit_new(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "giftcode_manipulate.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var amount   = document.getElementById("new_num").value;
    xmlhttp.send("action=new&amount=" + amount);
}
function submit_del(){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "giftcode_manipulate.php", false);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var id   = document.getElementById("del_id").value;
    xmlhttp.send("action=del&id=" + id);
}
function render_json(response) {
    var arr = JSON.parse(response);
    var i;
    var out = "";

    for(i = 0; i < arr.length; i++) {
        out += "<tr><td>" +
        arr[i].id +
        "</td><td>" +
        arr[i].code +
        "</td></tr>";
    }
    document.getElementById("table").innerHTML = out;
}
function enter_new_mode(){
    $(".fn_btn").hide();
    $(".new_btn").show();
}
function exit_new_mode(){
    $(".fn_btn").show();
    $(".new_btn").hide();
    ajax_get_table();
}
function enter_del_mode(){
    $(".fn_btn").hide();
    $(".del_btn").show();
}
function exit_del_mode(){
    $(".fn_btn").show();
    $(".del_btn").hide();
    ajax_get_table();
}
</script>
</body>
</html>