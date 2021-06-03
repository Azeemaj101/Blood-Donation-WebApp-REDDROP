<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
include '../partials/_ConnectionDB.php';

// SID F_NAME L_NAME CONTACT EMAIL PASSWORD GENDER DOB BLOOD_GROUP PROVINCE CITY ADDRESS image_url

$name = "";
$check = 0;
$check1 = 0;
$check2 = 0;
$check3 = 0;
$check4 = 0;
$check5 = 0;
if (isset($_POST['U_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['Name2'];
        $user = $_POST['Username2'];
        $pass = $_POST['Password2'];
        $pin = $_POST['pin_code2'];
        $email = $_POST['Email2'];
        $img_url1 = $_FILES['my_image'];
        // echo "<pre>";
        // print_r($_FILES['my_image']);
        // echo "</pre>";
        $img_name1 = $_FILES['my_image']['name'];
        $img_size1 = $_FILES['my_image']['size'];
        $tmp_name1 = $_FILES['my_image']['tmp_name'];
        $error = $_FILES['my_image']['error'];

        if ($error === 0 || $_FILES['my_image']['size'] == 0) {
            if ($img_size1 > 350000) { //200000KB => 200MB
                // $em = "Sorry, your file is too large.";
                $check = 1;
                // header("Location: /reddrop/php/registration.php?error=$em");
            } else {
                $img_ex = pathinfo($img_name1, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);

                $allowed_exs = array("jpg", "jpeg", "png");

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                    $img_upload_path = '../Managers/' . $new_img_name;
                    move_uploaded_file($tmp_name1, $img_upload_path);

                    // Insert into Database
                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$user','$pass','$pin')";
                    mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$user'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if ($LOGIN_U_P) {
                        $User_FIRST_INSERT = "INSERT INTO MANAGERS (`NAME`,`EMAIL`,`image_url`,`LOGIN_ID`) VALUES('$name','$email','$new_img_name','$LSID')";
                        $err = mysqli_query($Connect_DB, $User_FIRST_INSERT);
                        if ($err) {
                            $check1 = 1;
                        } else {
                            $check3 = 1;
                        }
                    }
                } elseif ($_FILES['my_image']['size'] == 0) {
                    $LOGIN_INSERT = "INSERT INTO LOGIN (`USERNAME`,`PASSWORD`,`PIN_CODE`) VALUES('$user','$pass','$pin')";
                    mysqli_query($Connect_DB, $LOGIN_INSERT);
                    $fatch_LOGIN = "SELECT *FROM `LOGIN` WHERE `USERNAME` = '$user'";
                    $LOGIN_U_P = mysqli_query($Connect_DB, $fatch_LOGIN);
                    $row = mysqli_fetch_assoc($LOGIN_U_P);
                    $LSID = $row['LOGIN_ID'];
                    if ($LOGIN_U_P) {
                        $User_FIRST_INSERT = "INSERT INTO MANAGERS (`NAME`,`EMAIL`,`LOGIN_ID`) VALUES('$name','$email','$LSID')";
                        $err = mysqli_query($Connect_DB, $User_FIRST_INSERT);
                        if ($err) {
                            $check1 = 1;
                        } else {
                            $check3 = 1;
                        }
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
    Dear ' . strtoupper($_SESSION['name']) . ' this Account Updated<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check2) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($_SESSION['name']) . ' You cant upload files of this type!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check3) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($_SESSION['name']) . ' This Username already Registered!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check4) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Dear ' . strtoupper($_SESSION['name']) . ' There have some Server issue please try again later!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
        if ($check5) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($_SESSION['name']) . ' This Username already Registered!
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
                <a href="/reddrop/inventory_sheet/php/manager_pdf.php"><button type="button" class="btn btn-warning btn-lg hov">
                        <ion-icon name="download"></ion-icon>&nbspDownload-PDF
                    </button></a>
            </div>
            <div class="d-flex justify-content-start text-success">
                <strong class="border border-success rounded-pill px-2 hov"> ONLINE:
                    <?php
                    $sql = "SELECT *FROM `managers` where `ONLINE` = 1";
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
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-Manager-Account</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="container" action="/reddrop/inventory_sheet/php/managers_table.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" minlength="4" placeholder="Manager Name*" maxlength="30" class="form-control" id="Name2" name="Name2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" minlength="4" maxlength="30" placeholder="Manager Username*" class="form-control" id="Username2" name="Username2" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" placeholder="Password*" id="Password2" name="Password2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Pin Code</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" placeholder="PIN*" id="pin_code2" name="pin_code2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" placeholder="Manager Email*" class="form-control" id="Email2" name="Email2">
                            </div>
                            <div class="mb-3 row">
                                <div class="col">
                                    <label for="formFile" class="form-label"><strong>Image Resolution (370x410)</strong></label>
                                    <input class="form-control" type="file" name="my_image">
                                </div>
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" name="U_Submit" class="btn btn-primary">ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
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
                        <form class="container" action="/reddrop/inventory_sheet/php/managerscript.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Name</label>
                                <input type="text" minlength="4" placeholder="Manager Name*" maxlength="30" class="form-control" id="Name3" name="Name3" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Username</label>
                                <input type="text" minlength="4" maxlength="30" placeholder="Manager Username*" class="form-control" id="Username3" name="Username3" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Password</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" placeholder="Password*" id="Password3" name="Password3">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Pin Code</label>
                                <input type="password" minlength="4" maxlength="30" class="form-control" placeholder="PIN*" id="pin_code3" name="pin_code3">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Email</label>
                                <input type="email" maxlength="40" placeholder="Manager Email*" class="form-control" id="Email3" name="Email3">
                            </div>
                            <div class="row">
                                <button type="submit" name="r_submit" class="btn btn-danger p-3">UPDATE</button>
                            </div>
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
                        <th scope="col"><small>Name</small></th>
                        <th scope="col"><small>Username</small></th>
                        <th scope="col"><small>Password</small></th>
                        <th scope="col"><small>PIN</small></th>
                        <th scope="col"><small>Email</small></th>
                        <th scope="col"><small>Picture</small></th>
                        <th scope="col"><small>Status</small></th>
                        <th scope="col"><small>Action</small></th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <!-- // SID F_NAME L_NAME CONTACT EMAIL PASSWORD GENDER DOB BLOOD_GROUP PROVINCE CITY ADDRESS image_url -->
                        <?php
                        $U_VIEW = "SELECT *FROM `MANAGERS`,`LOGIN` WHERE `LOGIN`.`LOGIN_ID` = `MANAGERS`.`LOGIN_ID`";
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
                                $picture = "../MANAGERS/$row[image_url]";
                                echo "<tr>
            <th scope='row'><small>" . $form . "</small></th>
            <td><small>" . $row['NAME'] . "</small></td>
            <td><small>" . $row['USERNAME'] . "</small></td>
            <td><small>" . $row['PASSWORD'] . "</small></td>
            <td><small>" . $row['PIN_CODE'] . "</small></td>
            <td><small>" . $row['EMAIL'] . "</small></td>
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
                    name = tr.getElementsByTagName("td")[0].innerText;
                    username = tr.getElementsByTagName("td")[1].innerText;
                    password = tr.getElementsByTagName("td")[2].innerText;
                    pin = tr.getElementsByTagName("td")[3].innerText;
                    email = tr.getElementsByTagName("td")[4].innerText;
                    Name3.value = name;
                    Username3.value = username;
                    Password3.value = password;
                    pin_code3.value = pin;
                    Email3.value = email;
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
                        window.location = `/reddrop/inventory_sheet/php/managerscript.php?delete=${sno}`;
                    }

                })
            })
        </script>
    </section>
</body>

</html>