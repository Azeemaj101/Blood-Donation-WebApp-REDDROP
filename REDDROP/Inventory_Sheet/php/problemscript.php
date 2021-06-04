<?php
include '../partials/_ConnectionDB.php';
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
if (isset($_GET['delete'])) {
    $sno = $_GET['delete'];
    echo $sno;
    $sql2 = "DELETE FROM `a_issues` WHERE `a_issues`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB, $sql2);
    if ($result2) {
        header("location:/reddrop/inventory_sheet/php/problem_Table.php");
    }
}
if (isset($_GET['a_delete'])) {
    $sno = $_GET['a_delete'];
    echo $sno;
    $sql2 = "DELETE FROM `issues` WHERE `issues`.`SID` = $sno";
    $result2 = mysqli_query($Connect_DB, $sql2);
    if ($result2) {
        header("location:/reddrop/inventory_sheet/php/problem_Table.php");
    }
}
if (isset($_GET['id'])) {
    $sno = $_GET['id'];
    $name = $_GET['name'];
    $contact = $_GET['contact'];
    $cnic = $_GET['cnic'];
    $issue = $_GET['issue'];
    $User_Table = "CREATE TABLE `A_ISSUES`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(50) NOT NULL,
                                  `CONTACT` VARCHAR(50) NOT NULL,
                                  `CNIC` VARCHAR(50) NOT NULL,
                                  `ISSUE` VARCHAR(150) NOT NULL,
                                  `LOGIN_ID` INT DEFAULT '$_SESSION[login_id]', FOREIGN KEY (`LOGIN_ID`) REFERENCES `LOGIN`(`LOGIN_ID`) ON DELETE SET NULL,
                                  PRIMARY KEY (`SID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";

    mysqli_query($Connect_DB, $User_Table);
    $User_FIRST_INSERT = "INSERT INTO A_ISSUES (`NAME`,`CONTACT`,`CNIC`,`ISSUE`,`LOGIN_ID`) VALUES('$name','$contact','$cnic','$issue','$_SESSION[login_id]')";
    $err = mysqli_query($Connect_DB, $User_FIRST_INSERT);
    if ($err) {
        $sql2 = "DELETE FROM `issues` WHERE `issues`.`SID` = $sno";
        $result2 = mysqli_query($Connect_DB, $sql2);
        if ($result2) {
            header("location:/reddrop/inventory_sheet/php/problem_Table.php");
        } else {
            header("location:/reddrop/inventory_sheet/php/problem_Table.php");
        }
    } else {
        header("location:/reddrop/inventory_sheet/php/problem_Table.php");
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['snoEdit'])) {
        $SNO = $_POST['snoEdit'];
        $NAME = $_POST['name1'];
        $CONTACT = $_POST['contact1'];
        $CNIC = $_POST['cnic1'];
        $ISSUE = $_POST['issue1'];
        echo $NAME." ".$CONTACT." ".$CNIC." ".$ISSUE;
        $sql = "UPDATE `a_issues` SET `NAME` = '$NAME', `CONTACT` = '$CONTACT', `CNIC` = '$CNIC', `ISSUE` = '$ISSUE' WHERE `a_issues`.`SID` = $SNO";
        $result = mysqli_query($Connect_DB, $sql);
        if ($result) {
            header("location:/reddrop/inventory_sheet/php/problem_Table.php");
        } else {
            header("location:/reddrop/inventory_sheet/php/problem_Table.php");
        }
    }
}
