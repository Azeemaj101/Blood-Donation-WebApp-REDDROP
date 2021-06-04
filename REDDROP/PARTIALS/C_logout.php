<?php
session_start();
include '../inventory_sheet/partials/_ConnectionDB.php';
$status = "UPDATE `users` SET `ONLINE` = '0' WHERE `users`.`SID` = $_SESSION[SID]";
mysqli_query($Connect_DB, $status);

unset($_SESSION['C_loggedin']);
unset($_SESSION['SID']);
unset($_SESSION['f_name']);
unset($_SESSION['l_name']);
unset($_SESSION['contact']);
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['pin']);
unset($_SESSION['gender']);
unset($_SESSION['DOB']);
unset($_SESSION['blood_group']);
unset($_SESSION['province']);
unset($_SESSION['city']);
unset($_SESSION['address']);
unset($_SESSION['image_url']);
unset($_SESSION['fk_id']);
// session_destroy($_SESSION['C_loggedin']);
header("Location:/reddrop/index.php");
exit();
