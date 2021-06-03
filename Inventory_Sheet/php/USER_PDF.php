<?php
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/php/User_login.php");
    exit;
}
    include '../partials/_ConnectionDB.php';
    require "../vendor/autoload.php";
    
    $Que = "SELECT *FROM `USERS`,`login` where `login`.`LOGIN_ID` = `USERS`.`LOGIN_ID`";
    $RUN = mysqli_query($Connect_DB, $Que);

    if (mysqli_num_rows($RUN)) {
        if(mysqli_num_rows($RUN)>0){
            $html='<hr>File Created By:' . strtoupper($_SESSION['U_username']).'<br><hr><style>table, th, td {border: 1px solid black;}table {width: 100%;}th {height: 70px;}td {text-align: center;}</style><table cellspacing="0px" cellpadding= "20px" height = "50px" width = "40px" border="4px">';
                $html.='<tr><th>#SR</th><th>name</th><th>Username</th><th>Password</th><th>PIN</th><th>BLOOD_GROUP</th><th>AGE</th><th>CONTACT</th><th>GENDER</th><th>PROVINCE</th><th>CITY</th></tr>';
                $i = 0;
                date_default_timezone_set("Asia/Karachi");
                while($row=mysqli_fetch_assoc($RUN)){
                    $i += 1;
                    $diff = (int)date('Y-m-d') - (int)$row['DOB'];
                    $html.='<tr><td>'.$i.'</td><td>'.$row['F_NAME']." ".$row['L_NAME'].'</td><td>'.$row['USERNAME'].'</td><td>'.$row['PASSWORD'].'</td><td>'.$row['PIN_CODE'].'</td><td>'.$row['BLOOD_GROUP'].'</td><td>'.$diff.'</td><td>'.$row['CONTACT'].'</td><td>'.$row['GENDER'].'</td><td>'.$row['PROVINCE'].'</td><td>'.$row['CITY'].'</td></tr>';
                }
            $html.='</table><hr><br>Print Date Time:' . date('Y-m-d H:i');
        }else{
            $html="Data not found";
        }
    }
    else{
        $html="Data not found";
    }
    // echo $html;
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($html);
    $file = 'User'.time().'.pdf';
    $mpdf->output($file,'D');
    header("location:/reddrop/inventory_sheet/php/User_Table.php");
?>
