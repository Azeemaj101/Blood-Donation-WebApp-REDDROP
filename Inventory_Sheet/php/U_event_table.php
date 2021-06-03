<?php
session_start();
if (!isset($_SESSION['U_loggedin']) || $_SESSION['U_loggedin'] != true) {
    header("Location:/reddrop/inventory_sheet/index.php");
    exit;
}
$_SESSION['PDF'] = 'Empty...';
include '../partials/_ConnectionDB.php';
$hero_Table = "CREATE TABLE `EVENT`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `EVENT_TYPE` VARCHAR(25) NOT NULL DEFAULT 'NAN',
                                  `CONTACT` VARCHAR(50) NOT NULL DEFAULT 'NAN',
                                  `DATE` DATE NOT NULL,
                                  `AMOUNT` INT NOT NULL DEFAULT 0,
                                  `LOGIN_ID` INT DEFAULT '$_SESSION[LOGIN_ID_M]', FOREIGN KEY (`LOGIN_ID`) REFERENCES `LOGIN`(`LOGIN_ID`) ON DELETE SET NULL,
                                  PRIMARY KEY (`SID`))";



$F_Table_Query = mysqli_query($Connect_DB, $hero_Table);
if ($F_Table_Query) {
    $Food_FIRST_INSERT = "INSERT INTO `EVENT` (`EVENT_TYPE`,`CONTACT`,`DATE`,`AMOUNT`) VALUES('NONE','NONE','NONE',0)";
    mysqli_query($Connect_DB, $Food_FIRST_INSERT);
}
$check = false;
if (isset($_POST['F_Submit'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $e_type = $_POST['e_type2'];
        $number = $_POST['mobile_number'];
        $e_date = $_POST['e_date'];
        $amount = $_POST['amount'];
        $Food1_FIRST_INSERT = "INSERT INTO `EVENT` (`EVENT_TYPE`,`CONTACT`,`DATE`,`AMOUNT`,`LOGIN_ID`) VALUES('$e_type','$number','$e_date','$amount','$_SESSION[LOGIN_ID_M]')";
        $RUN = mysqli_query($Connect_DB, $Food1_FIRST_INSERT);
        if (!$RUN) {
            $check = true;
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
    <title>Event-Table</title>
</head>

<body style="font-family: 'Ubuntu', sans-serif;" id="body-pd">
    <header>
        <?php
        include '../partials/U_Navbar.php';
        if (isset($_GET['error'])) {
            if ($_GET['error'] == 1) {
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Please Try again later.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
            } else {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Table Updated.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
            }
        }
        if ($check == true) {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    Server Problem! 
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
            <button type="button" class="btn btn-warning hov btn-lg mx-2 fw-bold" data-bs-toggle="modal" data-bs-target="#insertModal" id="change_pass">
                <ion-icon name="add-circle"></ion-icon>Create Event
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
                        <form action="/reddrop/inventory_sheet/php/U_eventscript.php" method="POST">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Type</label>
                                <input type="text" required placeholder="Name*" minlength="5" maxlength="40" class="form-control" id="e_type1" name="e_type1">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Contact</label>
                                <input type="text" required placeholder="Contact Number*" minlength="11" maxlength="15" class="form-control" name="mobile_number1" id="mobile_number1">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Date</label>
                                <input type="date" required placeholder="Event Date*" minlength="11" maxlength="15" class="form-control" name="e_date1" id="e_date1">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <input type="number" required placeholder="Amount*" minlength="2" maxlength="10" class="form-control" name="amount1" id="amount1" aria-describedby="emailHelp">
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
                        <h5 class="modal-title" id="insertModalLabel"><strong>ADD-EVENT</strong></h5>
                        <button type="button" class="btn-close bg-danger rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="/reddrop/inventory_sheet/php/U_event_Table.php" method="POST">
                            <input type="hidden" name="snoEdit1" id="snoEdit1">
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Type</label>
                                <input type="text" required placeholder="Event Type*" minlength="5" maxlength="40" class="form-control" name="e_type2">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Contact</label>
                                <input type="text" required placeholder="Contact Number*" minlength="11" maxlength="15" class="form-control" name="mobile_number">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Event Date</label>
                                <input type="date" required placeholder="Event Date*" value="<?php echo date("Y-m-d") ?>" minlength="11" maxlength="15" class="form-control" name="e_date">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <input type="number" required placeholder="Amount*" minlength="2" maxlength="10" class="form-control" name="amount" aria-describedby="emailHelp">
                            </div>
                            <br>
                            <HR>
                            <div class="text-center">
                                <button type="submit" NAME="F_Submit" class="btn btn-primary">ADD</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="mx-1 my-2 py-3 text-center">
            <table class="table table-dark table-striped table-responsive" id="myTable">
                <thead>
                    <tr>
                        <th scope="col">SR#</th>
                        <th scope="col">Event Type</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Event Manager</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <div class="table">
                        <?php
                        $sql1 = "SELECT *FROM `event` left join `login` on `event`.`LOGIN_ID` = `LOGIN`.`LOGIN_ID`";
                        $result1 = mysqli_query($Connect_DB, $sql1);
                        $num = 0;
                        $form = 0;
                        if ($result1) {
                            while ($row = mysqli_fetch_assoc($result1)) {
                                $form += 1;
                                if (!$row['USERNAME']) {
                                    $row['USERNAME'] = "Not Appointed";
                                }
                                echo "<tr>
                            <th scope='row'>" . $form . "</th>
                            <td>" . $row['EVENT_TYPE'] . "</td>
                            <td>" . $row['CONTACT'] . "</td>
                            <td>" . $row['DATE'] . "</td>
                            <td>" . $row['AMOUNT'] . "</td>
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
            <a href="/reddrop/inventory_Sheet/php/User_Panel.php"><button type="button" class="btn btn-outline-light text-dark mb-3"><strong>
                        <ion-icon name="arrow-back"></ion-icon>
                    </strong></button></a>
        </div>
        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
        <script>
            // e_type1 mobile_number1 e_date1 amount1
            edits = document.getElementsByClassName('edit');
            Array.from(edits).forEach((element) => {
                element.addEventListener("click", (e) => {
                    tr = e.target.parentNode.parentNode;
                    e_type = tr.getElementsByTagName("td")[0].innerText;
                    contact = tr.getElementsByTagName("td")[1].innerText;
                    date = tr.getElementsByTagName("td")[2].innerText;
                    amount = tr.getElementsByTagName("td")[3].innerText;
                    e_type1.value = e_type;
                    mobile_number1.value = contact;
                    e_date1.value = date;
                    amount1.value = amount;
                    snoEdit.value = e.target.id;
                    $('#editModal').modal('toggle');
                })
            })
            deletes = document.getElementsByClassName('delete');
            Array.from(deletes).forEach((element) => {
                element.addEventListener("click", (e) => {
                    console.log(e.target.id.substr(1, ));
                    sno = e.target.id.substr(1, );
                    if (confirm("You want to delete this record?")) {
                        console.log("yes");
                        window.location = `/reddrop/inventory_sheet/php/U_eventscript.php?delete=${sno}`;
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