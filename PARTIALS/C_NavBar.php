<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <!-- <div class="m-2">   -->
    <a class="navbar-brand" href="/reddrop/index.php"><img src="/reddrop/pictures/Logo1.jpeg" alt="" width="220" height="44"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- </div> -->
    <div class="collapse navbar-collapse text-center" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 cnav">
        <li class="nav-item dropdown">
          <a class="nav-link active be" href="/reddrop/index.php"><span>Home</span></a>
        </li>

        <?php
        if (!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true) {
          echo '<li class="nav-item dropdown">
          <a class="nav-link active be" href="/reddrop/php/registration.php"><span>Registration</span></a>
        </li>';
        } else {
          echo '<li class="nav-item dropdown">
          <a class="nav-link active be" href="/reddrop/php/F_Donner.php"><span>Find Donors</span></a>
        </li>';
        } ?>
        <li class="nav-item dropdown">
          <a class="nav-link active dropdown-toggle be" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span>Others</span>
          </a>
          <ul class="dropdown-menu text-center p-2" aria-labelledby="navbarDropdown">
            <?php
            if (!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true) {
              echo '<li><a class="dropdown-item" href="/reddrop/php/C_Login.php">Login</a></li>
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</a></li>';
            } else {

              echo '<li><a class="dropdown-item" href="/reddrop/inventory_sheet/index.php">ADMIN PANEL</a></li>
              <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</a></li>';
            }
            ?>
          </ul>
        </li>
      </ul>
      <?php
      if (!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true) {
        echo '<a href="/reddrop/Inventory_Sheet/index.php" target="_blank"><button class="btn btn-outline-success mx-3" type="button">Admin</button></a>';
      }
      if (isset($_SESSION['C_loggedin'])) {
        if ($_SESSION['C_loggedin'] == true) {
          echo ' <div class="dropdown" >
        <button class="btn btn-secondary bg-light text-dark dropdown-toggle rounded-pill login_btn border border-secondery" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">';
          if ($navCheck === 1) {
            echo '<img src="users/' . $_SESSION['image_url'] . '" class="img-thumbnail zoom pic_logo" alt="...">';
          }
          if ($navCheck === 2) {
            echo '<img src="../users/' . $_SESSION['image_url'] . '" class="img-thumbnail zoom pic_logo" alt="...">';
          }
          echo  '<strong>' . strtoupper($_SESSION['f_name']) . ' ' . strtoupper($_SESSION['l_name']) . '</strong>
        </button>
        <ul class="dropdown-menu text-center bg-light w_login" aria-labelledby="dropdownMenuButton1">
          <li>';
          if ($navCheck === 1) {
            echo '<img src="users/' . $_SESSION['image_url'] . '" class="img-thumbnail zoom pic_logo1" alt="...">';
          }
          if ($navCheck === 2) {
            echo '<img src="../users/' . $_SESSION['image_url'] . '" class="img-thumbnail zoom pic_logo1" alt="...">';
          }
          echo  '<br><b>' . strtoupper($_SESSION['f_name']) . ' ' . strtoupper($_SESSION['l_name']) . '</b></li>
          <hr>
          <li><a class="text-danger" href="/reddrop/php/C_Setting.php"><button type="button" class="btn btn-secondary mx-1 btn_size1 rounded-pill"><i class="fas fa-user-cog"></i><strong> SETTING</strong></button></a><a class="text-danger" href="/reddrop/partials/C_logout.php"><button type="button" class="btn btn-danger mx-1 btn_size1 rounded-pill"><i class="fas fa-sign-out-alt"></i><strong> LOGOUT</strong></button></a></li>
        </ul>
      </div>';
        }
      }
      ?>
    </div>
  </div>
</nav>