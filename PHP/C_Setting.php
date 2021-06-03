<?php
session_start();
if (!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true) {
    header("Location:/reddrop/index.php");
    exit;
}
include '../inventory_sheet/partials/_ConnectionDB.php';
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

                    // Insert into Database
                    $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = $_SESSION[fk_id]";
                    $err1 = mysqli_query($Connect_DB, $login_update);
                    $err = 0;
                    if ($err1) {
                        $User_INSERT = "UPDATE `users` SET `F_NAME` = '$f_name', `L_NAME` = '$l_name', `CONTACT` = '$contact', `GENDER` = '$gender', `DOB` = '$DOB1', `BLOOD_GROUP` = '$blood_group', `PROVINCE` = '$province', `CITY` = '$city', `ADDRESS` = '$address', `image_url` = '$new_img_name' WHERE `users`.`SID` = $_SESSION[SID]";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {

                        $FE = file_exists("../Users/" . $_SESSION['image_url']);
                        // echo var_dump($FE);
                        // echo "/reddrop/Users/".$_SESSION['image_url'];
                        if ($FE && $_SESSION['image_url'] <> "1.png") {
                            unlink("../Users/" . $_SESSION['image_url']);
                        }
                        $_SESSION['f_name'] = $f_name;
                        $_SESSION['l_name'] = $l_name;
                        $_SESSION['contact'] = $contact;
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['pin'] = $pin;
                        $_SESSION['gender'] = $gender;
                        $_SESSION['DOB'] = $DOB1;
                        $_SESSION['blood_group'] = $blood_group;
                        $_SESSION['province'] = $province;
                        $_SESSION['city'] = $city;
                        $_SESSION['address'] = $address;
                        $_SESSION['image_url'] = $new_img_name;
                        $check1 = 1;
                    } else {
                        $check3 = 1;
                    }
                } elseif ($_FILES['my_image']['size'] == 0) {
                    $login_update = "UPDATE `LOGIN` SET `USERNAME` = '$username', `PASSWORD` = '$password', `PIN_CODE` = '$pin' WHERE `LOGIN`.`LOGIN_ID` = $_SESSION[fk_id]";
                    $err1 = mysqli_query($Connect_DB, $login_update);
                    $err = 0;
                    if ($err1) {
                        $User_INSERT = "UPDATE `users` SET `F_NAME` = '$f_name', `L_NAME` = '$l_name', `CONTACT` = '$contact', `GENDER` = '$gender', `DOB` = '$DOB1', `BLOOD_GROUP` = '$blood_group', `PROVINCE` = '$province', `CITY` = '$city', `ADDRESS` = '$address' WHERE `users`.`SID` = $_SESSION[SID]";
                        $err = mysqli_query($Connect_DB, $User_INSERT);
                    }
                    if ($err) {
                        $_SESSION['f_name'] = $f_name;
                        $_SESSION['l_name'] = $l_name;
                        $_SESSION['contact'] = $contact;
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        $_SESSION['pin'] = $pin;
                        $_SESSION['gender'] = $gender;
                        $_SESSION['DOB'] = $DOB1;
                        $_SESSION['blood_group'] = $blood_group;
                        $_SESSION['province'] = $province;
                        $_SESSION['city'] = $city;
                        $_SESSION['address'] = $address;
                        $check1 = 1;
                    } else {
                        $check3 = 1;
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
    // include "../partials/Web_Logo.php";
    include "../partials/links.php";
    ?>
    <link rel="icon" type="image/jpeg" href='/reddrop/pictures/setting.png' class="size">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <link rel="stylesheet" href="/reddrop/css/style.css">

    <title>Settings</title>
</head>

<body>
    <header>
        <?php
        $navCheck = 2;
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
    Dear ' . strtoupper($f_name) . ' your Account Updated<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check2) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' You cant upload files of this type!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check3) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Dear ' . strtoupper($f_name) . ' This Email already Registered!
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
                <form class="container" action="/reddrop/php/C_Setting.php" method="POST" enctype="multipart/form-data">
                    <fieldset>
                        <legend><b>General Account Settings</b></legend>
                        <div class="row mb-3">
                            <div class="bg-danger col-1 rounded zoom" style="height:3px;"></div>
                            <div class="bg-light col rounded" style="height:3px"></div>
                        </div>
                        <div class="mb-3 row text-center">
                            <div class="col">
                                <?php
                                echo '<img src="../users/' . $_SESSION['image_url'] . '" class="img-thumbnail zoom pic_logo2" alt="...">
                                <br><b>' . strtoupper($_SESSION['f_name']) . ' ' . strtoupper($_SESSION['l_name']) . '</b>'; ?>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Your First Name*" class="form-control mt-4" id="exampleInputname1" value=<?php echo $_SESSION['f_name']; ?> name="f_name" required aria-describedby="emailHelp">
                            </div>
                            <div class="col">
                                <label for="birthday">Date of Birth:</label>
                                <input type="date" class="form-control" name="DOB" required value=<?php echo $_SESSION['DOB']; ?>>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Your Last Name*" required name="l_name" value=<?php echo $_SESSION['l_name']; ?> class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control" list="Blood-group" required placeholder="Select Blood Group*" value=<?php echo $_SESSION['blood_group']; ?> name="blood_group">
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
                                <input type="text" placeholder="Your Contact*" required name="contact" value=<?php echo $_SESSION['contact']; ?> class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control bg-light" list="province" required placeholder="Select province*" value=<?php echo $_SESSION['province']; ?> name="province">
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
                                <input type="email" placeholder="Your Username*" name="username" class="form-control" value=<?php echo $_SESSION['username']; ?> aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input type="text" placeholder="Your City*" value=<?php echo $_SESSION['city']; ?> required name="city" class="form-control" aria-describedby="nameHelp">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="password" min-length="4" placeholder="Password*" required name="password" value=<?php echo $_SESSION['password']; ?> class="form-control" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input type="password" min-length="4" placeholder="Pin Code*" required name="pin" value=<?php echo $_SESSION['pin']; ?> class="form-control" aria-describedby="nameHelp">
                            </div>

                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <input type="text" placeholder="Address*" required class="form-control" value=<?php echo $_SESSION['address']; ?> name="address" aria-describedby="nameHelp">
                            </div>
                            <div class="col">
                                <input class="form-control bg-light" list="Gender" placeholder="Select Gender*" value=<?php echo $_SESSION['gender']; ?> name="gender">
                                <datalist id="Gender">
                                    <option value="Male">
                                    <option value="Female">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="formFile" class="form-label"><strong>Change Picture</strong>(optional)</label>
                                <input class="form-control" value=<?php echo $_SESSION['image_url']; ?> type="file" name="my_image" id="formFile">
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" name="r_submit" class="btn btn-danger p-3">UPDATE</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php
        include "../partials/Back_button.php";
        include "../partials/Footer.php";
        ?>
    </footer>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <script src="/reddrop/js/typed1.js"></script>
    <!-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script> -->
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
        // AOS.init({
        //   duration: 3000,
        //   once: true,
        // });
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
    -->
</body>

</html>