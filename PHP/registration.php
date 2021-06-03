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
$f_name = '';
$check = 0;
$check1 = 0;
$check2 = 0;
$check3 = 0;
$check4 = 0;
if (isset($_POST['r_submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $DOB1 = $_POST['DOB'];
        $blood_group = $_POST['blood_group'];
        $contact = $_POST['contact'];
        $province = $_POST['province'];
        $username = $_POST['username'];
        $city = $_POST['city'];
        $password = $_POST['password'];
        $pin = $_POST['pin'];
        $address = $_POST['address'];
        $gender = $_POST['gender'];
        $img_name = $_FILES['my_image'];
        // echo "<pre>";
        // print_r($_FILES['my_image']);
        // echo "</pre>";
        $img_name = $_FILES['my_image']['name'];
        $img_size = $_FILES['my_image']['size'];
        $tmp_name = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ($error === 0 || $_FILES['my_image']['size'] == 0) {
            if ($img_size > 350000) { //200000KB => 200MB
                // $em = "Sorry, your file is too large.";
                $check = 1;
                // header("Location: /reddrop/php/registration.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../users/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$username','$password','$pin')";
                    $err2 = mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $err = 0;
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$username'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if($err2)
                    {
                    $User_INSERT = "INSERT INTO USERS (`F_NAME`,`L_NAME`,`CONTACT`,`GENDER`,`DOB`,`BLOOD_GROUP`,`PROVINCE`,`CITY`,`ADDRESS`,`image_url`,`LOGIN_ID`) VALUES('$f_name','$l_name','$contact','$gender','$DOB1','$blood_group','$province','$city','$address','$new_img_name','$LSID')";
                    $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $check1 = 1;
                    } else {
                        $check3 = 1;
                    }
                } elseif ($_FILES['my_image']['size'] == 0) {
                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$username','$password','$pin')";
                    $err2 = mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $err = 0;
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$username'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if($err2)
                    {
                    $User_INSERT = "INSERT INTO USERS (`F_NAME`,`L_NAME`,`CONTACT`,`GENDER`,`DOB`,`BLOOD_GROUP`,`PROVINCE`,`CITY`,`ADDRESS`,`LOGIN_ID`) VALUES('$f_name','$l_name','$contact','$gender','$DOB1','$blood_group','$province','$city','$address','$LSID')";
                    $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $check1 = 1;
                    } else {
                        $check3 = 1;
                    }
                } else {
                    $check2 = 1;
                }
            }
        } else {
            $check4 = 1;
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
        if ($check) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Sorry, your file is too large.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check1) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' your Registration Confirm <a href="/reddrop/php/C_Login.php"><button type="button" class="btn btn-success btn-small btn_size"> Click for Login</button></a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check2) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' You cant upload files of this type
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check3) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' You already registered! <a href="/reddrop/php/C_Login.php"><button type="button" class="btn btn-success btn-small btn_size"> Click for Login</button></a>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check4) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' There have some Server issue please try again later!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        include '../partials/R_S.php';
        ?>
    </header>
    <main>
        <div class="wrapper my-2 text-center" style="font-family: 'New Tegomin', serif;">
            <h2 class="text-Dark">Donate Blood <span class="box text-danger"></span></h2>
        </div>
        <div class="d-flex justify-content-center p-5">
            <div class="p-3 rounded zoom_line" style="background-color: #ccc; width:650px">
                <form class="container" action="/reddrop/php/registration.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <legend><b>Registration Form</b></legend>
                        <div class="row mb-3">
                            <div class="bg-danger col-1 rounded zoom" style="height:3px;"></div>
                            <div class="bg-light col rounded" style="height:3px"></div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Your First Name*" class="form-control mt-4" id="exampleInputname1" name="f_name" required aria-describedby="emailHelp">
                            </div>
                            <div class="col">
                                <label for="birthday">Date of Birth:</label>
                                <input type="date" value="2000-01-01" class="form-control" name="DOB" required id="exampleInputdate1">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Your Last Name*" required name="l_name" class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control" list="Blood-group" required placeholder="Select Blood Group*" name="blood_group">
                                <datalist id="Blood-group">
                                    <option value="A+">
                                    <option value="A-">
                                    <option value="B+">
                                    <option value="B-">
                                    <option value="AB+">
                                    <option value="AB-">
                                    <option value="O+">
                                    <option value="O-">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Your Contact*" required name="contact" class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control bg-light" list="province" required placeholder="Select province*" name="province">
                                <datalist id="province">
                                    <option value="Punjab">
                                    <option value="Sindh">
                                    <option value="KPK">
                                    <option value="Gilgit-Baltistan">
                                    <option value="Balochistan">
                                    <option value="Azad Jummu & Kashmir">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" required placeholder="Your Username*" name="username" class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input type="text" placeholder="Your City*" required name="city" class="form-control" aria-describedby="nameHelp">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="password" min-length="4" placeholder="Password*" required name="password" class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input type="password" min-length="4" placeholder="Pin Code*" required name="pin" class="form-control" aria-describedby="nameHelp">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Address*" required class="form-control" name="address" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control bg-light" list="Gender" placeholder="Select Gender*" name="gender">
                                <datalist id="Gender">
                                    <option value="Male">
                                    <option value="Female">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="formFile" class="form-label"><strong>Image</strong> Resolution (370x410)</label>
                                <input class="form-control" type="file" name="my_image" id="formFile">
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" name="r_submit" class="btn btn-danger p-3">REGISTER</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>


    </main>

    <?php
    include "../partials/Back_button.php";
    include "../partials/Footer.php";
    ?>
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="/reddrop/js/typed1.js"></script>
    <script>
        var typed = new Typed('.box', {
            strings: ['It does not affect your health', 'It does not affect your wealth', 'Twice a year every year', 'At least once a year'],
            // typeSpeed:60,
            // backSpace:60,
            // repeat: true,
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