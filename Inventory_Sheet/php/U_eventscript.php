<?php
include '../partials/_ConnectionDB.php';
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/php/UserPanel.php");
    exit;
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `event` WHERE `event`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB, $sql2);
    if ($result2) {
        header("location:/reddrop/inventory_sheet/php/U_event_Table.php?error=0");
    }
    else {
        header("location:/reddrop/inventory_sheet/php/U_event_Table.php?error=0");
    }
}
    // e_type1 mobile_number1 e_date1 amount1

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $SNO = $_POST['snoEdit'];
        $e_type = $_POST['e_type1'];
        $contact = $_POST['mobile_number1'];
        $date = $_POST['e_date1'];
        $amount = $_POST['amount1'];
        // echo $name." ".$number." ".$blood;
        $sql = "UPDATE `event` SET `EVENT_TYPE` = '$e_type', `CONTACT` = '$contact', `DATE` = '$date', `AMOUNT` = '$amount' WHERE `event`.`SID` = $SNO";
        $result = mysqli_query($Connect_DB, $sql);
        if ($result) {
            header("location:/reddrop/inventory_sheet/php/U_event_Table.php?error=0");
        } else {
            header("location:/reddrop/inventory_sheet/php/U_event_Table.php?error=1");
        }
    }
}
