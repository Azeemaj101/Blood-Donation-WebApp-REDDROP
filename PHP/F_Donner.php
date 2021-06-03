<?php
session_start();
if (!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true) {
  header("Location:/reddrop/index.php");
  exit;
}
include '../inventory_sheet/partials/_ConnectionDB.php';
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

  <script src="/reddrop/inventory_sheet/js/jquery.js"></script>
  <script src="/reddrop/inventory_sheet/media/js/jquery.dataTables.min.js"></script>
  <link href="/reddrop/inventory_sheet/media/css/jquery.dataTables.min.css" rel="stylesheet">
  <script>
    $(document).ready(function() {
      $('#myTable1').DataTable({
        "scrollX": true
      });
    });
  </script>
  <style>
    @media screen and (max-width: 500px) {

      div.dataTables_wrapper {
        width: 90px;
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

  <title>Find Donner</title>
</head>

<body>
  <header>
    <?php
    $navCheck = 2;
    $slidecheck = 1;
    include '../partials/Contact_Bar.php';
    include '../partials/C_NavBar.php';
    //     if ($check) {
    //         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    //       Successfully Submitted.
    // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    //     }
    //     if ($check1) {
    //         echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    //       You already Registered your Issue. If you have another Issue please try again later.
    // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    // </div>';
    //     }
    include '../partials/R_S.php';
    ?>
  </header>
  <main class="px-5  text-center">
    <div class="wrapper my-2 text-center" style="font-family: 'New Tegomin', serif;">
      <h2 class="text-Dark">Donate Blood <span class="box text-danger"></span></h2>
    </div>
    <?php
    if (isset($_POST['S_submit'])) {
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $blood_group = $_POST['blood_group'];
        $fatch_USER = "SELECT *FROM `USERS` WHERE `BLOOD_GROUP`='$blood_group'";
        $USER_U_P = mysqli_query($Connect_DB, $fatch_USER);
        $USER_TUPLE = mysqli_num_rows($USER_U_P);
        if ($USER_U_P and $USER_TUPLE > 0) {
          echo '<div class="text-center py-5">
        <table class="table table-success table-striped " id="myTable1">
            <thead>
              <tr>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Contact</th>
                <th scope="col">Gender</th>
                <th scope="col">Blood Group</th>
                <th scope="col">Province</th>
                <th scope="col">City</th>
              </tr>
            </thead><tbody>';
          while ($row = mysqli_fetch_assoc($USER_U_P)) {
            $F_name = $row['F_NAME'];
            $L_name = $row['L_NAME'];
            $contact = $row['CONTACT'];
            // $email = $row['EMAIL'];
            // $D_email = strtolower($email);
            $gender = $row['GENDER'];
            $blood_group = $row['BLOOD_GROUP'];
            $province = $row['PROVINCE'];
            $city = $row['CITY'];
            echo '<tr>
                <td>' . strtoupper($F_name) . '</td>
                <td>' . strtoupper($L_name) . '</td>
                <td>' . $contact . '</td>
                <td>' . $gender . '</td>
                <td>' . $blood_group . '</td>
                <td>' . strtoupper($province) . '</td>
                <td>' . strtoupper($city) . '</td>
              </tr>';
          }
          echo '</tbody>
          </table>
          </div>';
        } else {
          echo "<p ><b class='m-3 border rounded-pill border-danger px-5'>No Data Found</b><p>";
        }
      }
    }
    ?>
  </main>
  <?php
  include "../partials/Back_button.php";
  include "../partials/Footer.php";
  ?>
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