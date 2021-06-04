<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
$_SESSION['PDF'] = 'Empty...';
include '../partials/_ConnectionDB.php';
$ISSUE_Table = "CREATE TABLE `ISSUES`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(50) NOT NULL,
                                  `CONTACT` VARCHAR(50) NOT NULL,
                                  `CNIC` VARCHAR(50) NOT NULL UNIQUE,
                                  `ISSUE` VARCHAR(150) NOT NULL,
                                  PRIMARY KEY (`SID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";

$I_Table_Query = mysqli_query($Connect_DB, $ISSUE_Table);
if ($I_Table_Query) {
    $ISSUE_FIRST_INSERT = "INSERT INTO ISSUES (`NAME`,`CONTACT`,`CNIC`,`ISSUE`) VALUES('NONE','****','35202-*******-9','NO ENTRY')";
    mysqli_query($Connect_DB, $ISSUE_FIRST_INSERT);
}
$check = false;
if (isset($_POST['F_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name1 = $_POST['name2'];
        $number = $_POST['mobile_number'];
        $blood = $_POST['blood_group'];
        $Food1_FIRST_INSERT = "INSERT INTO `hero` (`NAME`,`MOBILE`,`BLOOD_GROUP`) VALUES('$name1','$number','$blood')";
        $RUN = mysqli_query($Connect_DB, $Food1_FIRST_INSERT);
        if (!$RUN) {
            $check = true;
        }
    }
}
$check3 = 0;
$check1 = 0;
if (isset($_POST['r_submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $R_NAME = $_POST['name2'];
        $R_CONTACT = $_POST['contact2'];
        $R_CNIC = $_POST['cnic2'];
        $R_ISSUE = $_POST['issue2'];
        $User_FIRST_INSERT = "INSERT INTO ISSUES (`NAME`,`CONTACT`,`CNIC`,`ISSUE`) VALUES('$R_NAME','$R_CONTACT','$R_CNIC','$R_ISSUE')";
        $err = mysqli_query($Connect_DB, $User_FIRST_INSERT);
        if ($err) {
            $check3 = 1;
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
    ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="/reddrop/inventory_sheet/css/Panel.css">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital@1&display=swap" rel="stylesheet">
    <script src="/reddrop/inventory_sheet/js/jquery.js"></script>
    <script src="/reddrop/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
    <link href="/reddrop/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "scrollX": true
            });
        });
        $(document).ready(function() {
            $('#myTable1').DataTable({
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

        @media screen and (max-width: 1040px) {

            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
                display: nowrap;
            }
        }
    </style>
    <title>Donation-Table</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <header>
        <?php
        include '../partials/Navbar.php';
        if ($check == true) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Server Problem! 
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
        }
        if ($check3) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Successfully Submitted.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        }
        if ($check1) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            You already Registered your Issue. If you have another Issue please try again later.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
        }
        ?>
    </header>
    <section>
        <!-- Button trigger modal
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Launch demo modal
        </button> -->

        <!-- Modal 1 for insert with button -->
        <div class="d-flex flex-row-reverse bd-highlight mt-5 px-5">
            <button type="button" class="btn btn-warning hov btn-lg mx-2" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">
                <ion-icon name="add-circle"></ion-icon>ADD
            </button>
            <!-- <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-warning hov btn-lg">
                <ion-icon name="copy"></ion-icon>&nbspGenerate-Report
            </button> -->
        </div>

        <div class="modal fade " id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel"><strong>Update-Record</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/reddrop/inventory_sheet/php/problemscript.php" method="POST">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <input type="text" required placeholder="Name*" minlength="5" maxlength="40" class="form-control" name="name1" id="name1">
                            </div>
                            <div class="mb-3">
                                <input type="text" required placeholder="Contact Number*" minlength="11" maxlength="15" class="form-control" name="contact1" id="contact1">
                            </div>
                            <div class="mb-3">
                                <input type="text" placeholder="XXXXX-XXXXXXX-X" required minlength="15" maxlength="15" class="form-control" name="cnic1" id="cnic1" oninvalid="this.setCustomValidity('Please use this format XXXXX-XXXXXXX-X')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" name="issue1" placeholder="Your Issues*" id="issue1"></textarea>
                                <label for="floatingTextarea" class="text-secondary">Issues</label>
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">UPDATE</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade " id="insertModal" tabindex="-1" aria-labelledby="insertModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content text-light bg-dark">
                    <div class="modal-header">
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-PROBLEM</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/reddrop/inventory_sheet/php/problem_Table.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <input type="text" required placeholder="Name*" minlength="5" maxlength="40" class="form-control" name="name2">
                            </div>
                            <div class="mb-3">
                                <input type="text" required placeholder="Contact Number*" minlength="11" maxlength="15" class="form-control" name="contact2">
                            </div>
                            <div class="mb-3">
                                <input type="text" placeholder="XXXXX-XXXXXXX-X" required minlength="15" maxlength="15" class="form-control" name="cnic2" id="exampleInputcnic" oninvalid="this.setCustomValidity('Please use this format XXXXX-XXXXXXX-X')" oninput="this.setCustomValidity('')">
                            </div>
                            <div class="form-floating">
                                <textarea class="form-control" name="issue2" placeholder="Your Issues*" id="floatingissues"></textarea>
                                <label for="floatingTextarea" class="text-secondary">Issues</label>
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" NAME="r_submit" class="btn btn-primary">ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="mx-1 my-2 py-3 text-center table-responsive">
            <strong class="px-3 rounded-pill border border-danger text-danger py-2 fs-4 text-uppercase">unapproved</strong>
            <table class="table table-dark table-striped table-hover" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">SR#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact</th>
                        <th scope="col">CNIC</th>
                        <th scope="col">Promblems</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $sql1 = "SELECT *FROM `issues`";
                        $result1 = mysqli_query($Connect_DB, $sql1);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                echo "<tr>
                            <th scope='row'>" . $form . "</th>
                            <td>" . $row['NAME'] . "</td>
                            <td>" . $row['CONTACT'] . "</td>
                            <td>" . $row['CNIC'] . "</td>
                            <td>" . $row['ISSUE'] . "</td>
                            <td><button type='button' id=" . $row['SID'] . " class='btn btn-success mt-2 approve btn-sm' style='font-size: 10px;'>Approve</button>
                            <button type='button' id=d" . $row['SID'] . " class='btn btn-danger mt-2 a_delete btn-sm' style='font-size: 10px;'>Delete</button></td>
          </tr>";
                            }
                        }
                        ?>
                </tbody>
            </table>
        </div>



        <div class="mx-1 my-2 py-3 text-center table-responsive">
            <strong class="px-3 rounded-pill border border-success text-success py-2 fs-4">APPROVED</strong>
            <table class="table table-dark table-striped table-hover" id="myTable1">
                <thead>
                    <tr>
                        <th scope="col">SR#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Contact</th>
                        <th scope="col">CNIC</th>
                        <th scope="col">Promblems</th>
                        <th scope="col">Approve By</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $sql1 = "SELECT *FROM `a_issues`,`LOGIN` WHERE `a_issues`.`LOGIN_ID` = `LOGIN`.`LOGIN_ID`";
                        $result1 = mysqli_query($Connect_DB, $sql1);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                echo "<tr>
                            <th scope='row'>" . $form . "</th>
                            <td>" . $row['NAME'] . "</td>
                            <td>" . $row['CONTACT'] . "</td>
                            <td>" . $row['CNIC'] . "</td>
                            <td>" . $row['ISSUE'] . "</td>
                            <td>" . $row['USERNAME'] . "</td>
                            <td><button type='button' id=" . $row['SID'] . " class='btn btn-primary mt-2 edit btn-sm' style='font-size: 10px;'>Edit</button>&nbsp<button type='button' id=d" . $row['SID'] . " class='delete btn btn-primary mt-2 btn-sm' style='font-size: 10px;'>Delete</button></td>
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
        <script>
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    name = tr.getElementsByTagName("td")[0].innerText;
                    contact = tr.getElementsByTagName("td")[1].innerText;
                    cnic = tr.getElementsByTagName("td")[2].innerText;
                    issue = tr.getElementsByTagName("td")[3].innerText;
                    name1.value = name;
                    contact1.value = contact;
                    cnic1.value = cnic;
                    issue1.value = issue;
                    snoEdit.value = e.target.id;
                    $('#editModal').modal('toggle');
                })
            })
            approve = document.getElementsByClassName('approve');
            Array.from(approve).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    name = tr.getElementsByTagName("td")[0].innerText;
                    contact = tr.getElementsByTagName("td")[1].innerText;
                    cnic = tr.getElementsByTagName("td")[2].innerText;
                    issue = tr.getElementsByTagName("td")[3].innerText;
                    console.log(issue);
                    window.location = `/reddrop/inventory_sheet/php/problemscript.php?id=${e.target.id}&name=${name}&contact=${contact}&cnic=${cnic}&issue=${issue}`;
                    //  = e.target.id;
                    // $('#editModal').modal('toggle');
                })
            })
            a_deletes = document.getElementsByClassName('a_delete');
            Array.from(a_deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        console.log("yes");
                        window.location = `/reddrop/inventory_sheet/php/problemscript.php?a_delete=${sno}`;
                    }

                })
            })
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        console.log("yes");
                        window.location = `/reddrop/inventory_sheet/php/problemscript.php?delete=${sno}`;
                    }

                })
            })
        </script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    </section>
</body>

</html>