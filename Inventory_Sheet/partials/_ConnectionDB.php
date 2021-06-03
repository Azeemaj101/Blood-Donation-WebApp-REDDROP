<?php
$HostName = "localhost";
$UserName = "root";
$Password = "";
$MY_DB = "a_reddrop";
//$HostName = "us-cdbr-east-03.cleardb.com";
//$UserName = "b71e1f922aa372";
//$Password = "f07c8c58";
//$MY_DB = "heroku_0aae29c4e05e3a4";
$Connect_DB = mysqli_connect($HostName, $UserName, $Password);
$sql1 = "CREATE DATABASE `$MY_DB`";
mysqli_query($Connect_DB, $sql1);
$Connect_DB = mysqli_connect($HostName, $UserName, $Password, $MY_DB);
if (!$Connect_DB) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
    DataBase Not-Connected -- You should check in C-Panel.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
}
?>