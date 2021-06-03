<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';

// SID F_NAME L_NAME CONTACT EMAIL PASSWORD GENDER DOB BLOOD_GROUP PROVINCE CITY ADDRESS image_url
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
$name = "";
$check = 0;
$check1 = 0;
$check2 = 0;
$check3 = 0;
$check4 = 0;
$check5 = 0;
if (isset($_POST['U_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $f_name = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $name = $f_name . " " . $l_name;
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
                    $img_upload_path = '../../users/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Insert into Database

                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$username','$password','$pin')";
                    $err2 = mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $err = 0;
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$username'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if ($err2) {
                        $User_INSERT = "INSERT INTO USERS (`F_NAME`,`L_NAME`,`CONTACT`,`GENDER`,`DOB`,`BLOOD_GROUP`,`PROVINCE`,`CITY`,`ADDRESS`,`image_url`,`LOGIN_ID`) VALUES('$f_name','$l_name','$contact','$gender','$DOB1','$blood_group','$province','$city','$address','$new_img_name','$LSID')";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $check1 = 1;
                    } else {
                        $check5 = 1;
                    }
                } elseif ($_FILES['my_image']['size'] == 0) {
                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$username','$password','$pin')";
                    $err2 = mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $err = 0;
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$username'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if ($err2) {
                        $User_INSERT = "INSERT INTO USERS (`F_NAME`,`L_NAME`,`CONTACT`,`GENDER`,`DOB`,`BLOOD_GROUP`,`PROVINCE`,`CITY`,`ADDRESS`,`LOGIN_ID`) VALUES('$f_name','$l_name','$contact','$gender','$DOB1','$blood_group','$province','$city','$address','$LSID')";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $check1 = 1;
                    } else {
                        $check5 = 1;
                    }
                } else {
                    // $em = "You can't upload files of this type";
                    $check2 = 1;
                    // header("Location: index.php?error=$em");
                }
            }
        } else {
            // $em = "unknown error occurred!";
            // header("Location: /reddrop/php/registration.php?error=$em");
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
    include '../partials/web_logo.php';
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="/reddrop/inventory_sheet/css/Panel.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap" rel="stylesheet">
    <script src="/reddrop/inventory_sheet/js/jquery.js"></script>
    <script src="/reddrop/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
    <link href="/reddrop/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollX": true
            });
        });
    </script>
    <style>
        @media screen and (max-width: 500px) {

            div.dataTables_wrapper {
                width: 50px;
                margin: 0 auto;
                display: nowrap;
            }
        }

        @media screen and (max-width: 700px) {

            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
                display: nowrap;
            }
        }
    </style>
    <title>User-Table</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <header>
        <?php
        include '../partials/Navbar.php';
        if (isset($_GET['error'])) {
            $sno = $_GET['error'];
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            This Username already Taken.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Sorry, your file is too large.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check1) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($name) . ' your Account Updated<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check2) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($name) . ' You cant upload files of this type!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check3) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($name) . ' This Username already Registered!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check4) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Dear ' . strtoupper($name) . ' There have some Server issue please try again later!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        if ($check5) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($name) . ' This Email already Registered!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        ?>
    </header>
    <section>
        <!-- Modal 1 for insert -->
        <div class="bd-highlight mt-5 px-5">

            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-warning hov btn-lg mx-2" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">
                    <ion-icon name="add-circle"></ion-icon>ADD
                </button>
                <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning btn-lg hov">
                    <ion-icon name="copy"></ion-icon>&nbspGenerate-Report
                </button>
            </div>



            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Generate-Report&nbsp<ion-icon name="calendar"></ion-icon>
                            </h5>
                            <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/reddrop/inventory_sheet/php/C_User_PDF.php" method="POST">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Age start to</label>
                                    <input type="number" placeholder="Start to*" class="form-control" min="0" oninput="validity.valid||(value='');" id="aage" name="aage" aria-describedby="emailHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPassword1" class="form-label">Age end from</label>
                                    <input type="number" min="0" oninput="validity.valid||(value='');" placeholder="End From*" class="form-control" id="eage" name="eage">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Generate</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="d-flex justify-content-start text-success">
                <strong class="border border-success rounded-pill px-2 hov"> ONLINE:
                    <?php
                    $sql = "SELECT *FROM `USERS` where `ONLINE` = 1";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?></strong>
            </div>
        </div>

        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-User-Account</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" action="/reddrop/inventory_sheet/php/C_Users_table.php" method="POST" enctype="multipart/form-data">
                            <fieldset>
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
                                        <input type="text" placeholder="Your Username*" name="username" required class="form-control">
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
                                        <input type="password" min-length="4" placeholder="Pin Code*" required name="pin" id="pin" class="form-control" aria-describedby="nameHelp">
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
                                    <button type="submit" name="U_Submit" class="btn btn-primary p-3">REGISTER</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal 2 for Update or Delete -->
        <div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"><strong>UPDATE-USER-DATA</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" action="/reddrop/inventory_sheet/php/C_Userscript.php" method="POST" enctype="multipart/form-data">
                            <fieldset>
                                <input type="hidden" name="snoEdit" id="snoEdit">
                                <div class="mb-3 row">
                                    <div class="col">
                                        <input type="text" placeholder="Your First Name*" class="form-control mt-4" name="u_f_name" id="u_f_name" required aria-describedby="emailHelp">
                                    </div>
                                    <div class="col">
                                        <label for="birthday">Date of Birth:</label>
                                        <input type="date" class="form-control" name="u_DOB" id="u_DOB">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <input type="text" placeholder="Your Last Name*" required name="u_l_name" id="u_l_name" class="form-control" aria-describedby="nameHelp">
                                    </div>
                                    <div class="col">
                                        <input class="form-control" list="Blood-group" required placeholder="Select Blood Group*" name="u_blood_group" id="u_blood_group">
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
                                        <input type="text" placeholder="Your Contact*" required name="u_contact" id="u_contact" class="form-control" aria-describedby="nameHelp">
                                    </div>
                                    <div class="col">
                                        <input class="form-control bg-light" list="province" required placeholder="Select province*" name="u_province" id="u_province">
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
                                        <input type="text" placeholder="Your Username*" name="u_username" id="u_username" class="form-control">
                                    </div>
                                    <div class="col">
                                        <input type="text" placeholder="Your City*" required name="u_city" id="u_city" class="form-control" aria-describedby="nameHelp">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <input type="password" min-length="4" placeholder="Password*" required name="u_password" id="u_password" class="form-control" aria-describedby="nameHelp">
                                    </div>
                                    <div class="col">
                                        <input type="password" min-length="4" placeholder="Pin Code*" required name="u_pin" id="u_pin" class="form-control" aria-describedby="nameHelp">
                                    </div>

                                </div>
                                <div class="mb-3 row">
                                    <div class="col">
                                        <input type="text" placeholder="Address*" required class="form-control" name="u_address" id="u_address" aria-describedby="nameHelp">
                                    </div>
                                    <div class="col-6">
                                        <input class="form-control bg-light" list="Gender" placeholder="Select Gender*" name="u_gender" id="u_gender">
                                        <datalist id="Gender">
                                            <option value="Male">
                                            <option value="Female">
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="submit" name="r_submit" class="btn btn-primary p-3">UPDATE</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Table -->

        <div class="mx-1 my-3 py-3 text-center">
            <table class="table table-dark table-striped table-responsive" id="myTable">
                <thead>
                    <tr>
                        <th scope="col"><small>SR#</small></th>
                        <th scope="col"><small>First Name</small></th>
                        <th scope="col"><small>Last Name</small></th>
                        <th scope="col"><small>Contact</small></th>
                        <th scope="col"><small>Username</small></th>
                        <th scope="col"><small>Password</small></th>
                        <th scope="col"><small>PIN</small></th>
                        <th scope="col"><small>Gender</small></th>
                        <th scope="col"><small>Age</small></th>
                        <th scope="col"><small>Blood Group</small></th>
                        <th scope="col"><small>Province</small></th>
                        <th scope="col"><small>City</small></th>
                        <th scope="col"><small>Address</small></th>
                        <th scope="col"><small>Picture</small></th>
                        <th scope="col"><small>Status</small></th>
                        <th scope="col"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <!-- // SID F_NAME L_NAME CONTACT EMAIL PASSWORD GENDER DOB BLOOD_GROUP PROVINCE CITY ADDRESS image_url -->
                        <?php
                        $U_VIEW = "SELECT *FROM `USERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `USERS`.`LOGIN_ID`";
                        $result1 = mysqli_query($Connect_DB, $U_VIEW);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                $Status = "";
                                if ($row['ONLINE']) {
                                    $Status = "<b class = 'text-success'>ONLINE</b>";
                                } else {
                                    $Status = "<b class = 'text-danger'>OFFLINE</b>";
                                }
                                $picture = "../../USERS/$row[image_url]";
                                // $date1=date_create($row['DOB']);
                                // $date2=date_create("2013-03-15");
                                // $diff=date_diff($date1,$date2);
                                $diff = (int)date('Y-m-d') - (int)$row['DOB'];
                                echo "<tr>
            <th scope='row'><small>" . $form . "</small></th>
            <td><small>" . $row['F_NAME'] . "</small></td>
            <td><small>" . $row['L_NAME'] . "</small></td>
            <td><small>" . $row['CONTACT'] . "</small></td>
            <td><small>" . $row['USERNAME'] . "</small></td>
            <td><small>" . $row['PASSWORD'] . "</small></td>
            <td><small>" . $row['PIN_CODE'] . "</small></td>
            <td><small>" . $row['GENDER'] . "</small></td>
            <td><small>" . $diff . "</small></td>
            <td><small>" . $row['BLOOD_GROUP'] . "</small></td>
            <td><small>" . $row['PROVINCE'] . "</small></td>
            <td><small>" . $row['CITY'] . "</small></td>
            <td><small>" . $row['ADDRESS'] . "</small></td>
            <td><small><img src=" . $picture . " class='img-thumbnail zoom pic_logo' alt='...'></small></td>
            <td><small>" . $Status . "</small></td>
            <td><button type='button' id=" . $row['SID'] . " class='btn btn-primary btn-sm edit' style='font-size: 10px;'>Edit</button>&nbsp<button type='button' id=d" . $row['LOGIN_ID'] . " class='delete btn btn-primary btn-sm ' style='font-size: 10px;'>Delete</button></td>
          </tr>";
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>
        <div class="text-center">
            <a href="/reddrop/inventory_Sheet/php/Admin_Panel.php"><button type="button" class="btn btn-outline-light text-dark mb-3"><strong>
                        <ion-icon name="arrow-back"></ion-icon>
                    </strong></button></a>
        </div>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
        <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    f_name = tr.getElementsByTagName("td")[0].innerText;
                    l_name = tr.getElementsByTagName("td")[1].innerText;
                    contact = tr.getElementsByTagName("td")[2].innerText;
                    username = tr.getElementsByTagName("td")[3].innerText;
                    password = tr.getElementsByTagName("td")[4].innerText;
                    pin = tr.getElementsByTagName("td")[5].innerText;
                    gender = tr.getElementsByTagName("td")[6].innerText;
                    blood_group = tr.getElementsByTagName("td")[8].innerText;
                    province = tr.getElementsByTagName("td")[9].innerText;
                    city = tr.getElementsByTagName("td")[10].innerText;
                    address = tr.getElementsByTagName("td")[11].innerText;
                    u_f_name.value = f_name;
                    u_l_name.value = l_name;
                    u_blood_group.value = blood_group;
                    u_contact.value = contact;
                    u_province.value = province;
                    u_username.value = username;
                    u_city.value = city;
                    u_password.value = password;
                    u_pin.value = pin;
                    u_address.value = address;
                    u_gender.value = gender;
                    snoEdit.value = e.target.id;
                    $('#editModal').modal('toggle');
                })
            })
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    // console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        console.log(e.target);
                        window.location = `/reddrop/inventory_sheet/php/C_Userscript.php?delete=${sno}`;
                    }

                })
            })
        </script>
    </section>
</body>

</html>