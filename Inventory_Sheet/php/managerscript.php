<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `LOGIN` WHERE `LOGIN`.`LOGIN_ID` = $sno";
    $result2 = mysqli_query($Connect_DB, $sql2);
    if ($result2) {
        header("location:/reddrop/inventory_sheet/php/managers_Table.php");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $SNO = $_POST['snoEdit'];
        $name = $_POST['Name3'];
        $username = $_POST['Username3'];
        $password = $_POST['Password3'];
        $pin = $_POST['pin_code3'];
        $email = $_POST['Email3'];

        $U_VIEW = "SELECT *FROM `MANAGERS` WHERE `SID` = $SNO";
        $result1 = mysqli_query($Connect_DB, $U_VIEW);
        $row = mysqli_fetch_assoc($result1);
        
        
        $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = '$row[LOGIN_ID]'";
        $err1 = mysqli_query($Connect_DB, $login_update);
        $err = 0;
        if ($err1) {
            $User_INSERT = "UPDATE `MANAGERS` SET `NAME` = '$name', `EMAIL` = '$email' WHERE `MANAGERS`.`SID` = $SNO";
            $err = mysqli_query($Connect_DB, $User_INSERT);
        }
        if ($err) {
            header("location:/reddrop/inventory_sheet/php/managers_Table.php");
        } else {
            header("location:/reddrop/inventory_sheet/php/managers_Table.php?error=${err}");
        }
    }
}
