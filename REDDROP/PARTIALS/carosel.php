<div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="10000">
      <img src="/reddrop/pictures/C_1.jpg" class="d-block w-100 pic_size zoom" alt="...">
      <div class="carousel-caption d-none d-md-block">
       <?php
        // <a href="/reddrop/php/d_find.php"><button class="btn btn-danger mx-1 rounded-pill" type="button">Find Donner</button></a>
        if(!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true)
        {echo '<a href="/reddrop/php/registration.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Registration</button></a>
        <a href="/reddrop/php/C_Login.php"><button class="btn btn-dark mx-1 rounded-pill" type="button">Login</button></a><button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        else
        {
          echo '<a href="/reddrop/php/F_Donner.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Find Donner</button></a>';
          echo '<button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        ?>


      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img src="/reddrop/pictures/C_2.jpg" class="d-block w-100 pic_size zoom" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <?php
        if(!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true)
        {echo '<a href="/reddrop/php/registration.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Registration</button></a>
        <a href="/reddrop/php/C_Login.php"><button class="btn btn-dark mx-1 rounded-pill" type="button">Login</button></a><button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        else
        {
          echo '<a href="/reddrop/php/F_Donner.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Find Donner</button></a>';
          echo '<button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        ?>
      </div>
    </div>
    <div class="carousel-item">
      <img src="/reddrop/pictures/C_3.jpg" class="d-block w-100 pic_size zoom" alt="...">
      <div class="carousel-caption d-none d-md-block">
      <?php
        if(!isset($_SESSION['C_loggedin']) || $_SESSION['C_loggedin'] != true)
        {echo '<a href="/reddrop/php/registration.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Registration</button></a>
        <a href="/reddrop/php/C_Login.php"><button class="btn btn-dark mx-1 rounded-pill" type="button">Login</button></a><button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        else
        {
          echo '<a href="/reddrop/php/F_Donner.php"><button class="btn btn-success mx-1 rounded-pill" type="button">Find Donner</button></a>';
          echo '<button class="btn btn-danger rounded-pill mx-1" type="button" data-bs-toggle="modal" data-bs-target="#Modalissue">Any Problem?</button>';
        }
        ?>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>