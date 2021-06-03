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
        header("location:/reddrop/inventory_sheet/php/C_Users_Table.php");
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $SNO = $_POST['snoEdit'];
        $f_name = $_POST['u_f_name'];
        $l_name = $_POST['u_l_name'];
        $DOB1 = $_POST['u_DOB'];
        $blood_group = $_POST['u_blood_group'];
        $contact = $_POST['u_contact'];
        $province = $_POST['u_province'];
        $username = $_POST['u_username'];
        $city = $_POST['u_city'];
        $password = $_POST['u_password'];
        $pin = $_POST['u_pin'];
        $address = $_POST['u_address'];
        $gender = $_POST['u_gender'];

        $U_VIEW = "SELECT *FROM `USERS` WHERE `SID` = $SNO";
        $result1 = mysqli_query($Connect_DB, $U_VIEW);
        $row = mysqli_fetch_assoc($result1);
        
        
        $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = '$row[LOGIN_ID]'";
        $err1 = mysqli_query($Connect_DB, $login_update);
        $err = 0;
        if ($err1) {
            $User_INSERT = "UPDATE `users` SET `F_NAME` = '$f_name', `L_NAME` = '$l_name', `CONTACT` = '$contact', `GENDER` = '$gender', `DOB` = '$DOB1', `BLOOD_GROUP` = '$blood_group', `PROVINCE` = '$province', `CITY` = '$city', `ADDRESS` = '$address' WHERE `users`.`SID` = $SNO";
            $err = mysqli_query($Connect_DB, $User_INSERT);
        }
        if ($err) {
            header("location:/reddrop/inventory_sheet/php/C_Users_Table.php");
        } else {
            header("location:/reddrop/inventory_sheet/php/C_Users_Table.php?error=${err}");
        }
    }
}
