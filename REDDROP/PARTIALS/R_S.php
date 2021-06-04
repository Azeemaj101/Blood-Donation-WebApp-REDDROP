<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="/reddrop/pictures/S_R_1.jpg" class="d-block w-100 pic_size_1" alt="...">
      <div class="carousel-caption d-none d-md-block">
        <?php
        if (isset($slidecheck)) {
          if ($slidecheck == 1) {
            echo '<div class="d-flex justify-content-center px-5">
            <div class=" F_Search px-5 rounded-pill ">
                <form class="d-flex opacity_7 justify-content-center" action="/reddrop/php/F_Donner.php" method="POST">
                    <input class="form-control me-2 rounded-pill bg-dark text-light S_size" type="search" name="blood_group" placeholder="Please Enter Blood Group For Search*" required minlength="2" maxlength="3" aria-label="Search" oninvalid="this.setCustomValidity("Please Enter *-, *+")" oninput="this.setCustomValidity("")">
                    <button class="btn btn-info rounded-pill" name = "S_submit" type="submit">Search</button>
                </form>
            </div>
    </div>';
          }
        }
        ?>
      </div>
      <!-- <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="..." class="d-block w-100" alt="...">
    </div> -->
    </div>
  </div>