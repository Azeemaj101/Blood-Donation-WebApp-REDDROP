<?php
session_start();
include '../partials/_ConnectionDB.php';
$status ="UPDATE `managers` SET `ONLINE` = '0' WHERE `managers`.`SID` = $_SESSION[U_SID]";
mysqli_query($Connect_DB, $status);
unset($_SESSION['U_loggedin']);
unset($_SESSION['U_loggedin']);
unset($_SESSION['U_username']);
unset($_SESSION['U_name']);
unset($_SESSION['U_email']);
unset($_SESSION['U_SID']);
unset($_SESSION['LOGIN_ID_M']);
unset($_SESSION['U_img_url']);
unset($_SESSION['U_PIN']);
// session_unset();
header("Location:/reddrop/inventory_sheet/php/User_login.php" );
exit();
?>