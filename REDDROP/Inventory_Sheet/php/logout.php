<?php
session_start();
unset($_SESSION['loggedin']);
unset($_SESSION['sid']);
unset($_SESSION['login_id']);
unset($_SESSION['name']);
unset($_SESSION['username']);
unset($_SESSION['password']);
unset($_SESSION['pin_code']);
unset($_SESSION['email']);
unset($_SESSION['img_url']);
// session_unset();
header("Location:/reddrop/inventory_sheet/index.php");
exit();
