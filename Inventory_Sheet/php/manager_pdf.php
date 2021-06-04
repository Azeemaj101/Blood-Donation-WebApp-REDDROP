<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/php/User_login.php");
    exit;
}
    include '../partials/_ConnectionDB.php';
    require "../vendor/autoload.php";
    
    $Que = "SELECT *FROM `managers`,`login` where `login`.`LOGIN_ID` = `managers`.`LOGIN_ID`";
    $RUN = mysqli_query($Connect_DB, $Que);

    if (mysqli_num_rows($RUN)) {
        if(mysqli_num_rows($RUN)>0){
            $html='<hr>File Created By:' . strtoupper($_SESSION['username']).'<br><hr><style>table, th, td {border: 1px solid black;}table {width: 100%;}th {height: 70px;}td {text-align: center;}</style><table cellspacing="0px" cellpadding= "20px" height = "50px" width = "40px" border="4px">';
                $html.='<tr><th>#SR</th><th>name</th><th>Username</th><th>Password</th><th>PIN</th><th>Email</th></tr>';
                $i = 0;
                date_default_timezone_set("Asia/Karachi");
                while($row=mysqli_fetch_assoc($RUN)){
                    $i += 1;
                    $html.='<tr><td>'.$i.'</td><td>'.$row['NAME'].'</td><td>'.$row['USERNAME'].'</td><td>'.$row['PASSWORD'].'</td><td>'.$row['PIN_CODE'].'</td><td>'.$row['EMAIL'].'</td></tr>';
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
    header("location:/reddrop/inventory_sheet/php/managers_table.php");
?>
