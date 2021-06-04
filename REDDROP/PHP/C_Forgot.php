<?php
include '../inventory_sheet/partials/_ConnectionDB.php';
session_start();
if (!isset($_SESSION['C_forgot']) || $_SESSION['C_forgot'] != true) {
    header("Location:/reddrop/php/C_Login.php");
    exit;
}
$username = "";
$password = "";
$SID = $_SESSION['cf_SID'];
$Login_id = $_SESSION['cf_F_LOGIN_ID'];
$fatch_Admin = "SELECT *FROM `USERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `USERS`.`LOGIN_ID` AND `SID` = $SID";
$ADMIN_U_P = mysqli_query($Connect_DB, $fatch_Admin);
$ADMIN_TUPLE = mysqli_num_rows($ADMIN_U_P);
$C_Username = " ";
if ($ADMIN_U_P and $ADMIN_TUPLE > 0) {
    //THIS CODE FOR ONLY ONE ADMIN
    $row = mysqli_fetch_assoc($ADMIN_U_P);
    $username = $row['USERNAME'];
    $password = $row['PASSWORD'];
}
$check1 = 0;
if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $n_Password = $_POST['password'];
        $c_Password = $_POST['c_password'];
        if ($n_Password == $c_Password) {
            //add admin panel
            $upd = "UPDATE `LOGIN` SET `PASSWORD` = '$n_Password' WHERE `LOGIN`.`LOGIN_ID` = $Login_id";
            $F_upd = mysqli_query($Connect_DB, $upd);
            if ($F_upd) {
                unset($_SESSION['C_forgot']);
                unset($_SESSION['cf_username']);
                unset($_SESSION['cf_name']);
                unset($_SESSION['cf_pin']);
                unset($_SESSION['cf_SID']);
                unset($_SESSION['cf_F_LOGIN_ID']);

                header("location:/reddrop/php/C_Login.php?error=0");
            } else {

                unset($_SESSION['C_forgot']);
                unset($_SESSION['cf_username']);
                unset($_SESSION['cf_name']);
                unset($_SESSION['cf_pin']);
                unset($_SESSION['cf_SID']);
                unset($_SESSION['cf_F_LOGIN_ID']);
                header("location:/reddrop/php/C_Login.php?error=1");
            }
        } else {
            $check1 = 1;
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
    include '../partials/web_logo.php';
    include "../partials/links.php";
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="/reddrop/INVENTORY_SHEET/css/login.css"> -->
    <link rel="stylesheet" href="/reddrop/css/style.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <title>Forgot</title>
</head>

<body>
    <?php
    include '../partials/Contact_Bar.php';
    include '../partials/C_NavBar.php';
    if ($check1) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Wrong Password -- Both Passwords are not same.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    // if ($check2 == 1) {
    //     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    // Wrong PIN -- Please contact to admin if you forgot your PIN.
    // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    // }
    include '../partials/R_S.php';
    ?>
    <div class="wrapper my-2 text-center" style="font-family: 'New Tegomin', serif;">
        <h2 class="text-Dark">Donate Blood <span class="box text-danger"></span></h2>
    </div>
    <div class="d-flex justify-content-center p-5">
        <div class="p-4 rounded zoom_line" style="background-color: #ccc; width:500px;">
            <form action="/reddrop/php/C_Forgot.php" method="post">
                <fieldset>
                    <legend><b>Forgot Form</b></legend>
                    <div class="row mb-3">
                        <div class="bg-danger col-1 rounded zoom" style="height:3px;"></div>
                        <div class="bg-light col rounded" style="height:3px"></div>
                    </div>
                    <div class="row mb-3">
                        <input type="password" placeholder="Password*" name="password" class="form-control" id="password">
                    </div>
                    <div class="row mb-3">
                        <input type="password" placeholder="Confirm Password*" name="c_password" class="form-control" id="password">
                    </div>
                    <div class="row">
                        <button type="submit" name="submit" class="btn btn-danger p-3">Update</button>
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
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- <div class="pin justify-content-center align-items-center ">
        <div class="card py-5 px-5 border border-primary container1 bg-dark text-light text-center">
            <div class="text-center mb-3">
                <img src="/reddrop/INVENTORY_SHEET/pictures/Admin_L.png" id="box" class="img-fluid" alt="LOGO" width="200" height="50">
            </div>
            <h2 class="heading mx-2 px-2 pb-2">Forgot Password For <?php echo $_SESSION['cf_name'] ?>-Panel</h2>
            <form action="/reddrop/INVENTORY_SHEET/php/U_Forgot.php" method="POST">
                <div class="mb-1">
                    <input type="password" placeholder="New Password" class="form-control" size="35" id="n_password" maxlength="25" name="n_password" aria-describedby="emailHelp ">
                </div>
                <div class="mb-3">

                    <input type="password" maxlength="20" placeholder="Confirm Password" class="form-control" id="c_password" name="c_password">
                </div>
                <div class="text-center text-danger "><u>Hint:Must ADD(.,^@./)</u></div>
                <hr>
                <div class="text-center mt-3">
                    <button type="submit" onkeypress="return
enterKeyPressed(event)" name="submit" id="A_submit" class="btn btn-success btn-block">Change Password</button>
                    <a href="/reddrop/INVENTORY_SHEET/php/User_panel.php"><button type="button" class="btn btn-info btn-block btn-sm">GO BACK</button></a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function enterKeyPressed(event) {
            if (event.keyCode == 13) {
                console.log("Enter key is pressed");
                return true;
            } else {
                return false;
            }
        }
        let g = document.getElementById("box");
        console.log(g);
        g.addEventListener("mouseover", function(e) {
            this.style.transitionDuration = "1s"
            this.style.webkitTransform = "rotate(360deg) rotateZ(0deg)";
        })
        g.addEventListener("mouseout", function(e) {
            this.style.transitionDuration = "1s"
            this.style.webkitTransform = "rotate(-360deg) rotateZ(-0deg)";

        });
    </script> -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>