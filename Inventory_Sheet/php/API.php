<?php
include '../partials/_ConnectionDB.php';
$i = 0;
$respone = array();
$sql = "select * from `login`,`USERS` where `login`.`LOGIN_ID` = `USERS`.`LOGIN_ID`";

$result = mysqli_query($Connect_DB, $sql);
if ($result) {
    header("Content-Type: JSON");
    while ($row = mysqli_fetch_assoc($result)) {
        $response[$i]['NAME'] = $row['F_NAME'] . " " . $row['L_NAME'];
        $response[$i]['GENDER'] = $row['GENDER'];
        $response[$i]['AGE'] = (int)date('Y-m-d') - (int)$row['DOB'];;
        $response[$i]['CONTACT'] = $row['CONTACT'];
        $response[$i]['PROVINCE'] = $row['PROVINCE'];
        $response[$i]['CITY'] = $row['CITY'];
        $i++;
    }
    echo json_encode($response, JSON_PRETTY_PRINT);
}
?>