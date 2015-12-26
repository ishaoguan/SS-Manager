<!DOCTYPE html>
<?php
include("./admin_index/admin_auth.php");
if (admin_cookie_auth(False)) {
    header("location: ./admin_index/admin_index.php");
} else {
    header("location: ./status.html");
}
?>