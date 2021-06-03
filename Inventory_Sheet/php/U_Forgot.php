<?php
include '../partials/_ConnectionDB.php';
session_start();
if (!isset($_SESSION['U_forgot']) || $_SESSION['U_forgot'] != true) {
    header("Location:/reddrop/inventory_sheet/php/User_login.php");
    exit;
}
$username = "";
$password = "";
$SID = $_SESSION['f_SID'];
$Login_id = $_SESSION['F_LOGIN_ID'];
$fatch_Admin = "SELECT *FROM `MANAGERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `MANAGERS`.`LOGIN_ID` AND `SID` = $SID";
$ADMIN_U_P = mysqli_query($Connect_DB, $fatch_Admin);
$ADMIN_TUPLE = mysqli_num_rows($ADMIN_U_P);
$C_Username = " ";
if ($ADMIN_U_P and $ADMIN_TUPLE > 0) {
    //THIS CODE FOR ONLY ONE ADMIN
    $row = mysqli_fetch_assoc($ADMIN_U_P);
    $username = $row['USERNAME'];
    $password = $row['PASSWORD'];
}
if (isset($_POST['submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $n_Password = $_POST['n_password'];
        $c_Password = $_POST['c_password'];
        if ($n_Password == $c_Password) {
            //add admin panel
            $upd = "UPDATE `LOGIN` SET `PASSWORD` = '$n_Password' WHERE `LOGIN`.`LOGIN_ID` = $Login_id";
            $F_upd = mysqli_query($Connect_DB, $upd);
            if ($F_upd) {
                // session_unset();
                unset($_SESSION['U_forgot']);
                unset($_SESSION['f_username']);
                unset($_SESSION['f_name']);
                unset($_SESSION['f_pin']);
                unset($_SESSION['f_SID']);
                unset($_SESSION['F_LOGIN_ID']);
                header("location:/reddrop/INVENTORY_SHEET/php/User_login.php?error=0");
            } else {

                // session_unset();
                unset($_SESSION['U_forgot']);
                unset($_SESSION['f_username']);
                unset($_SESSION['f_name']);
                unset($_SESSION['f_pin']);
                unset($_SESSION['f_SID']);
                unset($_SESSION['F_LOGIN_ID']);
                header("location:/reddrop/INVENTORY_SHEET/php/User_login.php?error=1");
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Wrong Password -- Both Passwords are not same.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
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
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="/reddrop/INVENTORY_SHEET/css/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;1,300&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>
    <!-- Optional JavaScript; choose one of the two! -->
    <div class="pin my-3 justify-content-center align-items-center ">
        <div class="py-5 px-5 m-5 border border-primary container1 l_box text-light text-center">
            <div class="text-center mb-3">
                <img src="/reddrop/INVENTORY_SHEET/pictures/Admin_L.png" id="box" class="img-fluid" alt="LOGO" width="200" height="50">
            </div>
            <h2 class="heading mx-2 px-2 pb-2">Forgot Password For <?php echo $_SESSION['f_name'] ?>-Panel</h2>
            <form action="/reddrop/INVENTORY_SHEET/php/U_Forgot.php" method="POST">
                <div class="mb-1">
                    <input type="password" required minlength="4" maxlength="40" placeholder="New Password" class="form-control" size="35" id="n_password" maxlength="25" name="n_password" aria-describedby="emailHelp ">
                </div>
                <div class="mb-3">

                    <input type="password" required minlength="4" maxlength="40" maxlength="20" placeholder="Confirm Password" class="form-control" id="c_password" name="c_password">
                </div>
                <div class="text-center l_line text-danger "><a href="/reddrop/INVENTORY_SHEET/php/User_panel.php">GO BACK</a></div>
                <hr>
                <div class="text-center mt-3">
                    <button type="submit" onkeypress="return
enterKeyPressed(event)" name="submit" id="A_submit" class="btn btn-outline-primary">Change Password</button>
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
    </script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
    -->
</body>

</html>