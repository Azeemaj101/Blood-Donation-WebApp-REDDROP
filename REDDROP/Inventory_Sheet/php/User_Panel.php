<?php
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/php/User_login.php");
    exit;
}
include '../partials/_ConnectionDB.php';
$status = "UPDATE `managers` SET `ONLINE` = '1' WHERE `managers`.`SID` = $_SESSION[U_SID]";
mysqli_query($Connect_DB, $status);
$name = $_SESSION['U_name'];
$check = 0;
$check1 = 0;
$check2 = 0;
$check3 = 0;
$check4 = 0;
$check5 = 0;
$check6 = 0;
if (isset($_POST['C_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $pin = $_POST['pin_code'];
        $email = $_POST['email'];
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
                    $img_upload_path = '../managers/' . $new_img_name;
                    move_uploaded_file($tmp_name, $img_upload_path);

                    // Insert into Database
                    $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = $_SESSION[LOGIN_ID_M]";
                    $err1 = mysqli_query($Connect_DB, $login_update);
                    $err = 0;
                    if ($err1) {
                        $User_INSERT = "UPDATE `MANAGERS` SET `NAME` = '$name', `EMAIL` = '$email',`image_url` = '$new_img_name' WHERE `MANAGERS`.`SID` = $_SESSION[U_SID]";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {

                        $FE = file_exists("../managers/" . $_SESSION['U_img_url']);
                        // echo var_dump($FE);
                        // echo "/reddrop/Users/".$_SESSION['image_url'];
                        if ($FE and $_SESSION['U_img_url'] <> "1.png") {
                            // echo "hi";
                            unlink("../managers/" . $_SESSION['U_img_url']);
                        }
                        $_SESSION['U_name'] = $name;
                        $_SESSION['U_username'] = $username;
                        $_SESSION['U_password'] = $password;
                        $_SESSION['U_PIN'] = $pin;
                        $_SESSION['U_email'] = $email;
                        $_SESSION['U_img_url'] = $new_img_name;
                        $check1 = 1;
                    } else {
                        $check3 = 1;
                    }
                } elseif ($_FILES['my_image']['size'] == 0) {
                    $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = $_SESSION[LOGIN_ID_M]";
                    $err1 = mysqli_query($Connect_DB, $login_update);
                    $err = 0;
                    if ($err1) {
                        $User_INSERT = "UPDATE `MANAGERS` SET `NAME` = '$name', `EMAIL` = '$email' WHERE `MANAGERS`.`SID` = $_SESSION[U_SID]";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $_SESSION['U_name'] = $name;
                        $_SESSION['U_username'] = $username;
                        $_SESSION['U_password'] = $password;
                        $_SESSION['U_PIN'] = $pin;
                        $_SESSION['U_email'] = $email;
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
                        $check6 = 1;
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
                        $check6 = 1;
                    } else {
                        $check5 = 1;
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/reddrop/inventory_sheet/css/Panel.css">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <?php
    include '../partials/web_logo.php';
    ?>
    <!-- Table queries -->
    <!-- <script src="/inventory_sheet/js/jquery.js"></script>
    <script src="/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
    <link href="/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $("#myTable").dataTable();
        });
    </script> -->
    <title><?php echo strtoupper($_SESSION['U_name']); ?>-Manager-Panel</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <!-- Optional JavaScript; choose one of the two! -->
    <header>
        <?php
        include '../partials/U_Navbar.php';
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
        if ($check6) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($name) . ' New user Account Registered<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
    Dear ' . strtoupper($name) . ' This Username already Registered!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        ?>
    </header>
    <section>
        <!-- Modal 1 for insert -->
        <!-- <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">+Insert</button> -->
        </div>
        <div class="modal fade " id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateModalLabel"><strong><?php echo strtoupper($_SESSION['U_name']) ?> - General Account Settings</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/reddrop/inventory_sheet/php/User_Panel.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <?php echo  '<p class="card-text text-center"><img src="/reddrop/inventory_sheet/managers/' . $_SESSION['U_img_url'] ?>" class="card-img p-size-admin1 zoom" alt="..."><br><strong><?php echo strtoupper($_SESSION['U_name']) ?></strong></p>
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" minlength="4" placeholder="Your Name*" value=<?php echo $_SESSION['U_name']; ?> maxlength="30" class="form-control" id="name" name="name" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" minlength="4" value=<?php echo $_SESSION['U_username'] ?> maxlength="30" placeholder="Your Username*" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" value=" " placeholder="Password*" maxlength="30" class="form-control" required id="password" name="password" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">PIN-CODE</label>
                                <input type="password" minlength="4" maxlength="30" placeholder="Pin Code*" class="form-control" required id="pin_code" name="pin_code">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" placeholder="Email*" maxlength="40" value=<?php echo $_SESSION['U_email'] ?> class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="formFile" class="form-label"><strong>Change Picture</strong>(optional)</label>
                                    <input class="form-control" type="file" name="my_image">
                                </div>
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" name="C_Submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade " id="U_insertModal" tabindex="-1" aria-labelledby="U_insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="U_insertModalLabel"><strong>ADD-User-Account</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" action="/reddrop/inventory_sheet/php/User_Panel.php" method="POST" enctype="multipart/form-data">
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
                                    <button type="submit" name="r_submit" class="btn btn-primary p-3">REGISTER</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- //////////////////////////////////////////////////// -->
        <div class="d-flex justify-content-center align-items-center pt-4 pb-5 flex-wrap" data-aos="fade-right">
            <!-- //////////////////////////////////////////////////// -->
            <div class="card bg-dark text-white mx-2 my-3 hove" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <?php echo  '<p class="card-text text-center"><img src="/reddrop/inventory_sheet/managers/' . $_SESSION['U_img_url'] ?>" class="card-img p-size-admin zoom" alt="..."><br><strong><?php echo strtoupper($_SESSION['U_name']) ?></strong></p>
                    <div class="text-center">
                        <button type="button" class="btn btn-outline-info btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal">Update Account</button>
                    </div>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove disabled" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin-Logo1.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex justify-content-end">
                    <img src="/reddrop/inventory_sheet/pictures/management.png" class="card-img-top A_size" alt="...">
                </div>
                <div class="card-img-overlay d-flex justify-content-start F_Size counter">
                    <!-- <p class="card-text text-center "><strong style="width: 16rem;"> -->
                    <!-- Total Managers: -->
                    <?php
                    $sql = "SELECT *FROM `managers`";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?>
                    <!-- </strong></p> -->
                </div>
                <div class="card-img-overlay card-text d-flex align-items-end justify-content-center text-center"><button type="button" class="btn btn-outline-danger btn-sm mt-5 disabled" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">ADD-Manager</button>
                    <button type="button" class="btn btn-outline-danger btn-sm mx-2 disabled">View</button>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex justify-content-end">
                    <img src="/reddrop/inventory_sheet/pictures/profile-user.png" class="card-img-top A_size zoom" id="box1" alt="...">
                </div>
                <div class="card-img-overlay d-flex justify-content-start F_Size counter">
                    <!-- <p class="card-text text-center "><strong style="width: 16rem;"> -->
                    <!-- Total Managers: -->
                    <?php
                    $sql = "SELECT *FROM `users`";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?>
                    <!-- </strong></p> -->
                </div>
                <div class="card-img-overlay card-text d-flex align-items-end justify-content-center text-center"><button type="button" class="btn btn-outline-info btn-sm mt-5" data-bs-toggle="modal" data-bs-target="#U_insertModal" id="change_pass">ADD-User</button>
                    <a href="/reddrop/inventory_sheet/php/User_Table.php"><button type="button" class="btn btn-outline-info btn-sm mx-2">View</button></a>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin-Logo1.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex justify-content-end">
                    <img src="/reddrop/inventory_sheet/pictures/role-model.png" class="card-img-top A_size" alt="...">
                </div>
                <div class="card-img-overlay d-flex justify-content-start F_Size counter">
                    <!-- <p class="card-text text-center "><strong style="width: 16rem;"> -->
                    <!-- Total Managers: -->
                    <?php
                    $sql = "SELECT *FROM `event`";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?>
                    <!-- </strong></p> -->
                </div>
                <div class="card-img-overlay card-text d-flex align-items-end justify-content-center text-center">
                    <a href="/reddrop/inventory_sheet/php/U_event_table.php"><button type="button" class="btn btn-outline-info btn-sm mx-2">View Events</button></a>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex justify-content-end">
                    <img src="/reddrop/inventory_sheet/pictures/problem.png" class="card-img-top A_size" alt="...">
                </div>
                <div class="card-img-overlay d-flex justify-content-start F_Size counter">
                    <!-- <p class="card-text text-center "><strong style="width: 16rem;"> -->
                    <!-- Total Managers: -->
                    <?php
                    $sql = "SELECT *FROM `issues`";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?>
                    <!-- </strong></p> -->
                </div>
                <div class="card-img-overlay card-text d-flex align-items-end justify-content-center text-center">
                    <a href="/reddrop/inventory_sheet/php/M_problem_Table.php"><button type="button" class="btn btn-outline-info btn-sm mx-2">View Problems</button></a>
                </div>
            </div>
            <div class="card bg-dark text-white mx-2 my-2 hove" style="width: 18rem;">
                <img src="/reddrop/inventory_sheet/pictures/Admin_Logo.jpg" class="card-img" alt="...">
                <div class="card-img-overlay d-flex justify-content-end">
                    <img src="/reddrop/inventory_sheet/pictures/insert-picture-icon.png" class="card-img-top A_size" alt="...">
                </div>
                <div class="card-img-overlay d-flex justify-content-start F_Size counter">
                    <!-- <p class="card-text text-center "><strong style="width: 16rem;"> -->
                    <!-- Total Managers: -->
                    <?php
                    $sql = "SELECT *FROM `gallery`";
                    $RESULT = mysqli_query($Connect_DB, $sql);
                    if ($RESULT) {
                        $NUM = mysqli_num_rows($RESULT);
                        echo $NUM;
                    } else {
                        echo "0";
                    }
                    ?>
                    <!-- </strong></p> -->
                </div>
                <div class="card-img-overlay card-text d-flex align-items-end justify-content-center text-center">
                    <button type="button" class="btn btn-outline-danger disabled btn-sm mx-2">View Gallery</button>
                </div>
            </div>
        </div>
        <!-- //////////////////////////////////////////////////// -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
        <!-- zoom -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <!-- counter.js -->
        <script src="/reddrop/inventory_sheet/js/jquery.counterup.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
        <script>
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 10,
                    time: 1500
                });
            })

            // zoom animation
            AOS.init({
                duration: 3000,
                once: true,
            });
            let g = document.getElementById("box1");
            g.addEventListener("mouseover", function(e) {
                this.style.transitionDuration = "0.5s"
                this.style.webkitTransform = "rotate(360deg) rotateZ(0deg)";
            })
            g.addEventListener("mouseout", function(e) {
                this.style.transitionDuration = "0.5s"
                this.style.webkitTransform = "rotate(-360deg) rotateZ(-0deg)";

            });
        </script>
    </section>
    <?php
    include '../partials/Footer.php';
    ?>
</body>

</html>