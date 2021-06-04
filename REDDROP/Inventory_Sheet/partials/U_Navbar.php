<div class="d-flex justify-content-end px-2">
    <?php echo '<div class="dropdown" >
        <button class="btn btn-secondary bg-dark text-light dropdown-toggle rounded-pill login_btn border border-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><img src="../managers/' . $_SESSION['U_img_url'] . '" class="img-thumbnail zoom pic_logo" alt="..."><strong> ' . strtoupper($_SESSION['U_name']) . '</strong>
        </button>
        <ul class="dropdown-menu text-center bg-dark text-light w_login" aria-labelledby="dropdownMenuButton1">
          <li><img src="../managers/' . $_SESSION['U_img_url'] . '" class="img-thumbnail zoom pic_logo1" alt="..."><br><b>' . strtoupper($_SESSION['U_name']) . '</b></li>
          <hr>
          <li><button type="button" class="btn btn-secondary mx-1 btn_size1 rounded-pill" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fas fa-user-cog"></i><strong> SETTING</strong></button><a class="text-danger" href="/reddrop/inventory_sheet/php/U_logout.php"><button type="button" class="btn btn-danger mx-1 btn_size1 rounded-pill"><i class="fas fa-sign-out-alt"></i><strong> LOGOUT</strong></button></a></li>
        </ul>
      </div>'; ?>
</div>

<div class="l-navbar" id="navbar">
    <nav class="nav">
        <div>
            <div class="nav__brand">
                <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                <a href="/reddrop/INVENTORY_SHEET/php/User_Panel.php" class="nav__logo a1">User Panel&nbsp</a>
            </div>
            <div class="nav__list">
                <a href="/reddrop/INVENTORY_SHEET/php/User_Panel.php" class="nav__link a1">
                    <ion-icon name="home-outline" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Dashboard</b></span>
                </a>
                <a href="/reddrop/inventory_sheet/php/U_event_Table.php" class="nav__link a1">
                    <ion-icon name="help-buoy" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Events</b></span>
                </a>
                <a href="/reddrop/inventory_sheet/php/M_problem_Table.php" class="nav__link a1">
                    <ion-icon name="git-pull-request" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Problems</b></span>
                </a>
                <a href="#" class="nav__link disabled a1">
                    <ion-icon name="people" class="nav__icon disabled"></ion-icon>
                    <span class="nav__name disabled text-danger"><b>User's</b></span>
                </a>
                <a href="" class="nav__link a1" data-bs-toggle="modal" data-bs-target="#U_insertModal">
                    <ion-icon name="add-circle" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>ADD</b></span>
                </a>
            </div>
        </div>

        <a href="#" class="nav__link a1">
            <ion-icon name="arrow-up" class="nav__icon"></ion-icon>
            <span class="nav__name"><b>GO-TOP</b></span>
        </a>
    </nav>
</div>
<!-- ===== IONICONS ===== -->
<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>

<!-- ===== MAIN JS ===== -->
<script src="/reddrop/inventory_sheet/js/main.js"></script>