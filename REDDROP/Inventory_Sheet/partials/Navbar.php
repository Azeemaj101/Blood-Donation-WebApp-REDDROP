<div class="d-flex justify-content-end px-2">
    <?php echo '<div class="dropdown" >
        <button class="btn btn-secondary bg-dark text-light dropdown-toggle rounded-pill login_btn border border-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><img src="../admin/' . $_SESSION['img_url'] . '" class="img-thumbnail zoom pic_logo" alt="..."><strong> ' . strtoupper($_SESSION['name']) . '</strong>
        </button>
        <ul class="dropdown-menu text-center bg-dark text-light w_login" aria-labelledby="dropdownMenuButton1">
          <li><img src="../admin/' . $_SESSION['img_url'] . '" class="img-thumbnail zoom pic_logo1" alt="..."><br><b>' . strtoupper($_SESSION['name']) . '</b></li>
          <hr> 
          <li><button type="button" class="btn btn-secondary mx-1 btn_size1 rounded-pill" data-bs-toggle="modal" data-bs-target="#updateModal"><i class="fas fa-user-cog"></i><strong> SETTING</strong></button><a class="text-danger" href="/reddrop/inventory_sheet/php/logout.php"><button type="button" class="btn btn-danger mx-1 btn_size1 rounded-pill"><i class="fas fa-sign-out-alt"></i><strong> LOGOUT</strong></button></a></li>
        </ul>
      </div>'; ?>
</div>

<div class="l-navbar" id="navbar">
    <nav class="nav">
        <div>
            <div class="nav__brand">
                <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                <a href="/reddrop/inventory_sheet/php/Admin_Panel.php" class="nav__logo a1">Admin Panel&nbsp</a>
            </div>
            <div class="nav__list">
                <a href="/reddrop/inventory_sheet/php/Admin_Panel.php" class="nav__link a1">
                    <ion-icon name="home-outline" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Dashboard</b></span>
                </a>
                <a href="/reddrop/inventory_sheet/php/event_table.php" class="nav__link a1">
                    <ion-icon name="help-buoy" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Events</b></span>
                </a>
                <a href="/reddrop/inventory_sheet/php/problem_Table.php" class="nav__link a1">
                    <ion-icon name="git-pull-request" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>Problems</b></span>
                </a>
                <a href="/reddrop/inventory_sheet/php/C_Users_table.php" class="nav__link a1">
                    <ion-icon name="people" class="nav__icon"></ion-icon>
                    <span class="nav__name"><b>User's</b></span>
                </a>
                <a href="" class="nav__link a1" data-bs-toggle="modal" data-bs-target="#insertModal">
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