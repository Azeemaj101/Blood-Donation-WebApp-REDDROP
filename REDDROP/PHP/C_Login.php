<?php
include '../inventory_sheet/partials/_ConnectionDB.php';
session_start();
if (isset($_SESSION['C_loggedin'])) {
    if ($_SESSION['C_loggedin'] == true) {
        header("Location:/reddrop/index.php");
        exit;
    }
}
//Incase table is not created so create by this query 
$login_Table = "CREATE TABLE `LOGIN`(`LOGIN_ID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `USERNAME` VARCHAR(50) UNIQUE,
                                  `PASSWORD` VARCHAR(255) NOT NULL DEFAULT 'NONE',
                                  `PIN_CODE` VARCHAR(255) NOT NULL DEFAULT 'NONE',
                                  PRIMARY KEY (`LOGIN_ID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";

$login_Query = mysqli_query($Connect_DB, $login_Table);
$User_Table = "CREATE TABLE `USERS`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `F_NAME` VARCHAR(50) NOT NULL,
                                  `L_NAME` VARCHAR(50) NOT NULL,
                                  `CONTACT` VARCHAR(50) NOT NULL,
                                  `GENDER` VARCHAR(50) NOT NULL DEFAULT 'No Entry',
                                  `DOB` DATE NOT NULL,
                                  `BLOOD_GROUP` VARCHAR(50) NOT NULL,
                                  `PROVINCE` VARCHAR(50) NOT NULL,
                                  `CITY` VARCHAR(50) NOT NULL,
                                  `ADDRESS` VARCHAR(50) NOT NULL,
                                  `image_url` text NOT NULL DEFAULT '1.png',
                                  `ONLINE` VARCHAR(50) NOT NULL DEFAULT '0',
                                  `LOGIN_ID` INT, FOREIGN KEY (`LOGIN_ID`) REFERENCES `LOGIN`(`LOGIN_ID`) ON DELETE CASCADE,
                                  PRIMARY KEY (`SID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";

$U_Table_Query = mysqli_query($Connect_DB, $User_Table);
if ($U_Table_Query) {
    $DOB = date("Y/m/d");
    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('NONE','NONE','NONE')";
    mysqli_query($Connect_DB, $LOGIN_INSERT);
    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = 'NONE'";
    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
    $row = mysqli_fetch_assoc($LOGIN_U_P);
    $LSID = $row['LOGIN_ID'];
    $User_FIRST_INSERT = "INSERT INTO USERS (`F_NAME`,`L_NAME`,`CONTACT`,`GENDER`,`DOB`,`BLOOD_GROUP`,`PROVINCE`,`CITY`,`ADDRESS`,`image_url`,`LOGIN_ID`) VALUES('NONE','NONE','***********','no entery','$DOB','none','none','none','none','1.png','$LSID')";
    mysqli_query($Connect_DB, $User_FIRST_INSERT);
}

$email = " ";
$password = " ";
$fatch_USER = "SELECT *FROM `USERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `USERS`.`LOGIN_ID`";
$USER_U_P = mysqli_query($Connect_DB, $fatch_USER);
$USER_TUPLE = mysqli_num_rows($USER_U_P);
$C_email = " ";
$check1 = 0;
if (isset($_POST['login'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $C_username = $_POST['username'];
        $C_Password = $_POST['password'];
        $L_username = strtolower($C_username);
        if ($USER_U_P and $USER_TUPLE > 0) {
            while ($row = mysqli_fetch_assoc($USER_U_P)) {
                $SID = $row['SID'];
                $F_name = $row['F_NAME'];
                $L_name = $row['L_NAME'];
                $contact = $row['CONTACT'];
                $username = $row['USERNAME'];
                $D_username = strtolower($username);
                $password = $row['PASSWORD'];
                $pin = $row['PIN_CODE'];
                $gender = $row['GENDER'];
                $DOB = $row['DOB'];
                $blood_group = $row['BLOOD_GROUP'];
                $province = $row['PROVINCE'];
                $city = $row['CITY'];
                $address = $row['ADDRESS'];
                $image_url = $row['image_url'];
                $login_id = $row['LOGIN_ID'];
                // echo "Pass " . $D_username;
                if ($C_Password == $password && $L_username == $D_username) {
                    //add admin panel
                    session_start();
                    $status = "UPDATE `users` SET `ONLINE` = '1' WHERE `users`.`SID` = $SID";
                    mysqli_query($Connect_DB, $status);
                    $_SESSION['C_loggedin'] = true;
                    $_SESSION['SID'] = $SID;
                    $_SESSION['f_name'] = $F_name;
                    $_SESSION['l_name'] = $L_name; 
                    $_SESSION['contact'] = $contact;
                    $_SESSION['username'] = $D_username;
                    $_SESSION['password'] = $password;
                    $_SESSION['pin'] = $pin;
                    $_SESSION['gender'] = $gender;
                    $_SESSION['DOB'] = $DOB;
                    $_SESSION['blood_group'] = $blood_group;
                    $_SESSION['province'] = $province;
                    $_SESSION['city'] = $city;
                    $_SESSION['address'] = $address;
                    $_SESSION['image_url'] = $image_url;
                    $_SESSION['fk_id'] = $login_id;
                    header("location:/reddrop/index.php");
                } else {
                    $check1 = 1;
                }
            }
        }
    }
}

$fatch_USER1 = "SELECT *FROM `USERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `USERS`.`LOGIN_ID`";
$USER_U_P1 = mysqli_query($Connect_DB, $fatch_USER);
$USER_TUPLE1 = mysqli_num_rows($USER_U_P1);
$check2 = 0;
if (isset($_POST['F_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $F_Username = $_POST['username'];
        $F_Pin = $_POST['pin'];
        if ($USER_U_P1 and $USER_TUPLE1 > 0) {
            while ($row = mysqli_fetch_assoc($USER_U_P1)) {
                $SID = $row['SID'];
                $name = $row['F_NAME'] . ' ' . $row['L_NAME'];
                $username = $row['USERNAME'];
                // $D_Username = strtolower($username);
                $pin = $row['PIN_CODE'];
                $login_id = $row['LOGIN_ID'];
                $E_Name = strtolower($F_Username);
                $D_Name = strtolower($username);
                if ($E_Name == $D_Name && $pin == $F_Pin) {
                    //add admin panel
                    session_start();
                    $_SESSION['C_forgot'] = true;
                    $_SESSION['cf_username'] = $username;
                    $_SESSION['cf_name'] = $name;
                    $_SESSION['cf_pin'] = $pin;
                    $_SESSION['cf_SID'] = $SID;
                    $_SESSION['cf_F_LOGIN_ID'] = $login_id;
                    header("location:/reddrop/php/C_Forgot.php");
                } else {
                    $check1 = 1;
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    include "../partials/Web_Logo.php";
    include "../partials/links.php";
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="/reddrop/css/style.css">
    <title>RedDrop Registration</title>
</head>

<body>
    <header>
        <?php
        include '../partials/Contact_Bar.php';
        include '../partials/C_NavBar.php';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 1) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please Try again later.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
            } else {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Account Updated Successfully
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
            }
        }
        if ($check1) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Wrong Password
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check2 == 1) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Wrong PIN -- Please contact to admin if you forgot your PIN.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        include '../partials/R_S.php';
        ?>
    </header>
    <main>
        <!-- Button trigger modal -->
        <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> -->

        <!-- Modal -->
        <div class="modal fade opacity_9" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-secondary">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="exampleModalLabel">Forgot Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/reddrop/php/C_Login.php" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label fw-bold">Username</label>
                                <input type="text" required placeholder="Your Username*" class="form-control" name="username" id="exampleInputEmail1" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label fw-bold">PIN</label>
                                <input type="password" required placeholder="Your PIN*" class="form-control" name="pin" id="exampleInputPassword1">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="F_Submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="wrapper my-2 text-center" style="font-family: 'New Tegomin', serif;">
            <h2 class="text-Dark">Donate Blood <span class="box text-danger"></span></h2>
        </div>
        <div class="d-flex justify-content-center p-5">
            <div class="p-4 rounded zoom_line" style="background-color: #ccc; width:500px;">
                <form action="/reddrop/php/C_Login.php" method="post">
                    <fieldset>
                        <legend><b>Login Form</b></legend>
                        <div class="row mb-3">
                            <div class="bg-danger col-1 rounded zoom" style="height:3px;"></div>
                            <div class="bg-light col rounded" style="height:3px"></div>
                        </div>
                        <div class="row mb-3">
                            <input type="text" placeholder="Your Username*" name="username" class="form-control" id="username" aria-describedby="emailHelp">
                        </div>
                        <div class="row mb-3">
                            <input type="password" placeholder="Password*" name="password" class="form-control" id="password">
                        </div>
                        <div class="row">
                            <button type="submit" name="login" class="btn btn-danger p-3">LOGIN</button>
                        </div>
                    </fieldset>
                    <div class="forgot mt-2">
                        <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal"> Forgot Your Password? </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center">
            <a href="/reddrop/index.php"><button type="button" class="btn btn-outline-warning text-dark mb-3 pt-2"><strong>
                        <ion-icon name="arrow-round-back"></ion-icon>
                    </strong></button></a>
        </div>
    </main>
    <?php
    include "../partials/Footer.php";
    ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="/reddrop/js/typed1.js"></script>
    <script>
        var typed = new Typed('.box', {
            strings: ['It does not affect your health', 'It does not affect your wealth', 'Twice a year every year', 'At least once a year'],
            typeSpeed: 40,
            backspaceSpeed: 20,
            backspaceDelay: 80,
            repeatDelay: 10,
            repeat: true,
            autoStart: true,
            startDelay: 10,
            loop: true,
        });
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
</body>

</html>