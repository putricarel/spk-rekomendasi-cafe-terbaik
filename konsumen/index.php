<?php

session_start();
//JIKA TIDAK DITEMUKAN $_SESSION['status'] (USER/ADMIN TIDAK MELIWATI TAHAP LOGIN) MAKA LEMBAR ADMIN/USER KEHALAMAN LOGIN 
if (!isset($_SESSION['status'])) {
  header("Location: ../index.php?pesan=logindahulu");
  exit;
}


?>
<!doctype html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
      body {
        background-image: url(../img/galeri/poto.jpg);
        background-size: cover;
      }

      .container {
        background-color: #F5DEB3;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }

      .col-md-12.bg-primary {
        padding: 8px;
        background-color: #8B4513 !important;
      }

      .copyright {
        text-align: center;
        color: #fff;
      }

      .alert-brown {
        background-color: #8B4513;
        color: #FFFFFF;
        font-weight: bold;
        border: none;
      }

      .navbar-nav a:hover {
        color: darkblue;
      }

      @media (max-width: 1000px) {
        .judul {
          font-size: 3vh;
        }
      }
    </style>

    <title>Home</title>
  </head>

  <body bgcolor="f0f0f0">
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <form method="post" action="perhitungan.php">
      <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #8B4513;">
        <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav" style="margin: 10px;">
            <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php">
              <font size="4"><b>Home</b></font>
            </a>
            <a class="nav-link <?= $current_page == 'data_cafe.php' ? 'active' : '' ?>" href="data_cafe.php">
              <font size="4"><b>Perhitungan</b></font>
            </a>
            
          </div>

          <div class="navbar-nav ms-auto" style="margin: 10px;">
            <a class="log nav-link m-auto" href="../logout.php">
              <font size="4"><b>Logout</b></font>
              <img src="../img/logout.png" width="30">
            </a>
          </div>
        </div>
      </nav>
    </form>
    <br>
    <div class="container bg-brown shadow p-3 mb-5">
      <div class="alert alert-brown text-light">
        <center><b>SELAMAT DATANG KONSUMEN</b></center>
      </div>
      <center>
        <font size="5" class="judul"><b>Sistem Pendukung Keputusan Rekomendasi Cafe Terbaik Di Purwakarta Menggunakan Metode Moora”</b></font>
      </center>

      <br><br>

      <center>

      <!-- <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../img/galeri/c4.jpg" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c2.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c3.jpg" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item ">
            <img src="../img/galeri/c1.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c5.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c6.jpg" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c7.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item ">
            <img src="../img/galeri/c9.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c10.jpg" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c11.jpg" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/c12.png" class="d-block w-100" style="max-width: 50%;" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div> -->

      <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="../img/galeri/heyho.jpg" width="300" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/kkc.jpg" width="300" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/pancong.jpg" width="300" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item ">
            <img src="../img/galeri/salbeans.jpg" width="300" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="../img/galeri/sunday.jpg" width="300" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>

    </center>

    <br>
  </div>

  <div class="col-md-12 bg-primary">
    <div class="copyright">
      <h6>Copyright&copy; Kelompok 5</h6>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>