<?php
session_start();
include 'inventory_sheet/partials/_ConnectionDB.php';
if (isset($_SESSION['C_loggedin'])) {
  if ($_SESSION['C_loggedin'] == true) {
    $status = "UPDATE `users` SET `ONLINE` = '1' WHERE `users`.`SID` = $_SESSION[SID]";
    mysqli_query($Connect_DB, $status);
  }
}
$login_Table = "CREATE TABLE `LOGIN`(`LOGIN_ID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `USERNAME` VARCHAR(50) UNIQUE,
                                  `PASSWORD` VARCHAR(255) NOT NULL DEFAULT 'NONE',
                                  `PIN_CODE` VARCHAR(255) NOT NULL DEFAULT 'NONE',
                                  PRIMARY KEY (`LOGIN_ID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";
$login_Query = mysqli_query($Connect_DB, $login_Table);



$User_Table = "CREATE TABLE `ISSUES`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `NAME` VARCHAR(50) NOT NULL,
                                  `CONTACT` VARCHAR(50) NOT NULL,
                                  `CNIC` VARCHAR(50) NOT NULL UNIQUE,
                                  `ISSUE` VARCHAR(150) NOT NULL,
                                  PRIMARY KEY (`SID`))ENGINE=InnoDB DEFAULT CHARSET=latin1";

$U_Table_Query = mysqli_query($Connect_DB, $User_Table);

$gallery_Table = "CREATE TABLE `Gallery`(`SID` INT(6) NOT NULL AUTO_INCREMENT,
                                  `image_url` text NOT NULL DEFAULT 'G_1.jpg',
                                  `LOGIN_ID` INT DEFAULT null, FOREIGN KEY (`LOGIN_ID`) REFERENCES `LOGIN`(`LOGIN_ID`) ON DELETE SET NULL,
                                  PRIMARY KEY (`SID`))";
$gallery_Query = mysqli_query($Connect_DB, $gallery_Table);

$gal1 = "SELECT *FROM `Gallery`";
$r_gal = mysqli_query($Connect_DB, $gal1);
if ($gallery_Query or mysqli_num_rows($r_gal) === 0) {
  // echo mysqli_num_rows($r_gal);
  // echo "Hello";
  $gallery_Query_INSERT = "INSERT INTO `Gallery` (`image_url`) VALUES('G_1.jpg')";
  mysqli_query($Connect_DB, $gallery_Query_INSERT);
  $gallery_Query_INSERT1 = "INSERT INTO `Gallery` (`image_url`) VALUES('G_2.jpg')";
  mysqli_query($Connect_DB, $gallery_Query_INSERT1);
  $gallery_Query_INSERT2 = "INSERT INTO `Gallery` (`image_url`) VALUES('G_3.jpg')";
  mysqli_query($Connect_DB, $gallery_Query_INSERT2);
}

if ($U_Table_Query) {
  $User_FIRST_INSERT = "INSERT INTO ISSUES (`NAME`,`CONTACT`,`CNIC`,`ISSUE`) VALUES('NONE','****','35202-*******-9','NO ENTRY')";
  mysqli_query($Connect_DB, $User_FIRST_INSERT);
}
$check = 0;
$check1 = 0;
if (isset($_POST['r_submit'])) {
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $R_NAME = $_POST['r_name'];
    $R_CONTACT = $_POST['r_contact'];
    $R_CNIC = $_POST['r_cnic'];
    $R_ISSUE = $_POST['r_issue'];
    $User_FIRST_INSERT = "INSERT INTO ISSUES (`NAME`,`CONTACT`,`CNIC`,`ISSUE`) VALUES('$R_NAME','$R_CONTACT','$R_CNIC','$R_ISSUE')";
    $err = mysqli_query($Connect_DB, $User_FIRST_INSERT);
    if ($err) {
      $check = 1;
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
  include "partials/Web_Logo.php";
  include "partials/links.php";
  ?>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="stylesheet" href="/reddrop/css/style.css">


  <title>Blood Donation</title>
</head>

<body>
  <header>
    <?php
    $navCheck = 1;
    include 'partials/Contact_Bar.php';
    include 'partials/C_NavBar.php';
    if ($check) {
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
    include 'partials/carosel.php';
    ?>
  </header>
  <main>
    <!-- Button trigger modal -->
    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modalissue">
      Launch demo modal
    </button> -->

    <!-- Modal -->
    <div class="modal fade opacity_9" id="Modalissue" tabindex="-1" aria-labelledby="ModalissueLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-secondary">
          <div class="modal-header">
            <h5 class="modal-title text-light" id="ModalissueLabel">Register Your Problems</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="/reddrop/index.php" method="post">
              <div class="mb-3">
                <input type="text" placeholder="Your Name*" required maxlength="30" class="form-control" name="r_name" id="exampleInputname" aria-describedby="nameHelp">
              </div>
              <div class="mb-3">
                <input type="text" placeholder="Your Contact*" required maxlength="15" class="form-control" name="r_contact" id="exampleInputcontact">
              </div>
              <div class="mb-3">
                <input type="text" placeholder="XXXXX-XXXXXXX-X" required minlength="15" maxlength="15" class="form-control" name="r_cnic" id="exampleInputcnic" oninvalid="this.setCustomValidity('Please use this format XXXXX-XXXXXXX-X')" oninput="this.setCustomValidity('')">
              </div>
              <div class="form-floating">
                <textarea class="form-control" name="r_issue" placeholder="Your Issues*" id="floatingissues"></textarea>
                <label for="floatingTextarea">Issues</label>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-dark rounded-pill" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="r_submit" class="btn btn-primary rounded-pill">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <div class="wrapper my-2 text-center" style="font-family: 'New Tegomin', serif;">
      <h2 class="text-Dark">Donate Blood <span class="box text-danger"></span></h2>
    </div>
    <div class="d-flex justify-content-center">
      <div class="m-4">
        <div class="card mb-3 bg-ccc" style="max-width: 1040px;">
          <div class="row g-0 p-4">
            <div class="col-md-4 mt-5 rounded">
              <img src="/reddrop/pictures/M_1.jpg" class="rounded blur" alt="..." style="width: 300px;">
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h4 class="card-title">Who We Are?</h4>
                <div class="row mb-3 px-2">
                  <div class="bg-danger col-1 rounded zoom" style="height:3px;"></div>
                  <div class="bg-light col rounded" style="height:3px"></div>
                </div>
                <p class="card-text justify1">Blood Donation Society Pakistan is Non Government, Non Political Volunteer Society and our Motto is to Seek pleasure of Almighty Allah by Saving Human lives via facilitating blood transfusion.

                  Through our mobile app and website, we provide blood donations across Pakistan with few tabs on finger tips. We try our level best to meet 100% blood requirements voluntarily throughout Pakistan. We have a database of volunteers across the country willing to donate blood who can be reached through this app and our website.

                  For this purpose, we also conduct different seminars and motivational sessions in colleges, universities and local communities. We also create awareness among youth of the country.

                  We aim at ensuring access to safe and sufficient supply of blood and creating acceptability & accessibility in local communities for voluntarily donation of blood.
                </p>
                <!-- <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div class="d-flex justify-content-center" id="hero">
      <h2>Top Heroes
        <div class="row mb-3">
          <div class="bg-danger col-4 rounded zoom" style="height:3px;"></div>
          <div class="bg-light col rounded" style="height:3px"></div>
        </div>
      </h2>
    </div>
    <div class="px-5 table-responsive">
      <table class="table table-success table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">SR#</th>
            <th scope="col">Name</th>
            <th scope="col">Mobile Number</th>
            <th scope="col">Blood Group</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Maryam Asghar</td>
            <td>0324-4064060</td>
            <td>B+</td>
          </tr>
          <tr>
            <th scope="row">2</th>
            <td>Shar Moin</td>
            <td>0324-4897650</td>
            <td>O-</td>
          </tr>
          <tr>
            <th scope="row">3</th>
            <td>Basit Ali</td>
            <td>0324-4897650</td>
            <td>O-</td>
          </tr>
          <tr>
            <th scope="row">4</th>
            <td>Moazam Ansari</td>
            <td>0324-4897650</td>
            <td>AB+</td>
          </tr>
          <tr>
            <th scope="row">5</th>
            <td>Maha</td>
            <td>0324-4897650</td>
            <td>O+</td>
          </tr>
          <tr>
            <th scope="row">6</th>
            <td>Taha Sultan</td>
            <td>0324-4897658</td>
            <td>A+</td>
          </tr>
        </tbody>
      </table>
    </div>


    <div class="d-flex justify-content-center" id="event">
      <h2>Events
        <div class="row mb-3">
          <div class="bg-danger col-4 rounded zoom" style="height:3px;"></div>
          <div class="bg-light col rounded" style="height:3px"></div>
        </div>
      </h2>
    </div>
    <div class="px-5 table-responsive">
      <table class="table table-success table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">SR#</th>
            <th scope="col">Event Type</th>
            <th scope="col">Contact</th>
            <th scope="col">Event Date</th>
            <th scope="col">Event Manager</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql1 = "SELECT *FROM `event` left join `login` on `event`.`LOGIN_ID` = `LOGIN`.`LOGIN_ID`";
          $result1 = mysqli_query($Connect_DB, $sql1);
          $num = 0;
          $form = 0;
          if ($result1) {
            while ($row = mysqli_fetch_assoc($result1)) {
              $form += 1;
              if(!$row['USERNAME'])
              {
                $row['USERNAME'] = "Not Appointed";
              }
              echo "<tr>
                            <th scope='row'>" . $form . "</th>
                            <td>" . $row['EVENT_TYPE'] . "</td>
                            <td>" . $row['CONTACT'] . "</td>
                            <td>" . $row['DATE'] . "</td>
                            <td>" . $row['USERNAME'] . "</td>
          </tr>";
            }
          }
          else{
            echo "<tr>
                            <th scope='row'>1</th>
                            <td>No Event</td>
                            <td>No Event</td>
                            <td>No Event</td>
                            <td>No Event</td>
          </tr>";
          }
          ?>
        </tbody>
      </table>
    </div>


    <div class="p-3 mt-5">
      <div class="d-flex justify-content-center" id="gallery">
        <h2>CAMPAIGN GALLERY
          <div class="row mb-3">
            <div class="bg-danger col-4 rounded zoom" style="height:3px;"></div>
            <div class="bg-light col rounded" style="height:3px"></div>
          </div>
        </h2>
      </div>
      <div class="form-text mb-3 text-center">Our prestigious voluntary work on campaigns by the team.</div>
      <div class="d-flex justify-content-center mb-3">
        <div class="flex-wrap text-center" data-aos="fade-up">
          <?php
          $sql = "SELECT * FROM `Gallery` ORDER BY `SID` DESC";
          $res = mysqli_query($Connect_DB,  $sql);

          if (mysqli_num_rows($res) > 0) {
            while ($images = mysqli_fetch_assoc($res)) {
              // $count = $images['SID'];
              echo '<img src="/reddrop/DONNERS/' . $images['image_url'] . '" class="card-img-top pic_size_2 m-2" style="height:200px; width:273px;" alt="...">';
            }
          } ?>
          <!-- <img src="/reddrop/pictures/C_1.jpg" class="img-thumbnail " alt="..."> -->
        </div>
      </div>
    </div>


    <div class="p-3 team1">
      <div class="d-flex justify-content-center" id="Team">
        <h2 class="H_Team">Our Team
          <div class="row mb-3">
            <div class="bg-danger col-4 rounded zoom" style="height:3px;"></div>
            <div class="bg-light col rounded" style="height:3px"></div>
          </div>
        </h2>
      </div>
      <div class="form-text mb-3 text-center F_Team text-light fw-bold">The team who give their time and talents help to fulfill our mission.</div>
      <div class="d-flex justify-content-center mb-3">
        <div class="d-flex justify-content-center flex-wrap text-center" data-aos="zoom-in">

          <div class="flip-card mx-2">
            <div class="flip-card-inner"> 
              <div class="flip-card-frontside">
                <img src="/reddrop/pictures/Cover.png" class="img-thumbnail pic_size_3 m-2" alt="...">
              </div>
              <div class="flip-card-backside rounded pt-5">
                <h2>Muhammad Azeem</h2> 
                <span>Follow Me</span>
                <div class="sm">
                  <a href="https://www.facebook.com/Azeemaj101" target="_blank"><i class="fab fa-facebook-f"></i></a>
                  <a href="https://github.com/Azeemaj101" target="_blank"><i class="fab fa-twitter"></i></a>
                  <a href="https://linkedin.com/Azeemaj101" target="_blank"><i class="fab fa-linkedin"></i></a>
                  <a href="https://github.com/Azeemaj101" target="_blank"><i class="fab fa-github"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="flip-card mx-2">
            <div class="flip-card-inner">
              <div class="flip-card-frontside">
                <img src="/reddrop/pictures/Cover2.jpeg" class="img-thumbnail pic_size_3 m-2" alt="...">
              </div>
              <div class="flip-card-backside rounded pt-5">
                <h2>Muzammil Ahmad</h2>
                <span>Follow Me</span>
                <div class="sm">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-youtube"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="flip-card mx-2">
            <div class="flip-card-inner">
              <div class="flip-card-frontside">
                <img src="/reddrop/pictures/Cover3.jpeg" class="img-thumbnail pic_size_3 m-2" alt="...">
              </div>
              <div class="flip-card-backside rounded pt-5">
                <h2>Umer Farooq</h2>
                <span>Follow Me</span>
                <div class="sm">
                  <a href="#"><i class="fab fa-facebook-f"></i></a>
                  <a href="#"><i class="fab fa-twitter"></i></a>
                  <a href="#"><i class="fab fa-youtube"></i></a>
                  <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php
  include "partials/Footer.php";
  ?>
  <!-- Optional JavaScript; choose one of the two! -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
  <script src="/reddrop/js/typed1.js"></script>
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
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
    AOS.init({
      duration: 3000,
      once: true,
    });
  </script>
</body>

</html>