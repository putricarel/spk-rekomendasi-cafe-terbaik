<?php
session_start();
if (!isset($_SESSION['status'])) {
  header("Location: ../index.php?pesan=logindahulu");
  exit;
}

require '../functions.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Menambahkan opsi untuk kriteria
$c1_options = [
  3 => 'Kurang dari 3 km',
  2 => '3-5 km',
  1 => 'Lebih dari 5 km',
];

$c2_options = [
  3 => 'Kurang dari 15k',
  2 => '15k - 30k',
  1 => 'Lebih besar dari 30k',
];

$c3_options = [
  3 => 'Kurang dari 15k',
  2 => '15k - 30k',
  1 => 'Lebih besar dari 30k',
];

$c4_options = [
  3 => 'Sangat Lengkap',
  2 => 'Lengkap',
  1 => 'Tidak lengkap',
];

$c5_options = [
  3 => '4,6 - 5,0',
  2 => '4,3 - 4,6',
  1 => '4,0 - 4,3',
];

$data_cafe = tampilcafe("SELECT * FROM alternatif");
$data_cafe1 = mysqli_query($con, "SELECT * FROM alternatif");

if (isset($_POST['cari'])) {
  $input = $_POST['input'];
  $data_cafe = tampilcafe("SELECT * FROM alternatif WHERE nama_alternatif LIKE '%$input%' OR id_alternatif LIKE '%$input%' ");
}
?>

<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body {
        background-color: #D2B48C;
        background-image: url(../img/galeri/poto.jpg);
        background-size: cover;
      }
      .container {
       min-height: calc(100vh - 211px - -60px);
       background-color: #D2B48C;
       padding: 15px; 
       border-radius: 10px; 
       margin-top: 30px;
     }
     .col-md-12 {
      padding: 8px;
      background-color: #8B4513 !important;
    }
    .copyright {
      text-align: center;
      color: #FFFF;
    }
    .navbar {
      background-color: #8B4513; 
    }
    .alert-info {
      background-color: #D2B48C; 
      color: #5B4032;
    }
    .table-striped {
      background-color: #F5DEB3;
    }
    .table th, .table td {
      color: #5B4032; 
    }
    .table th {
      background-color: #A0522D; 
      color: white;
    }
    .bg-primary {
      background-color: #8B4513 !important;
    }
    .btn-brown {
      background-color: #8B4513; 
      color: #FFFFFF; 
      border: none;
    }
    .btn-light-brown {
      background-color: #F5DEB3; 
      border: none;
    }
    .btn-dark-brown {
      background-color: #5C4033; 
      border: none;
    }
  </style>
  <title>LAPORAN</title>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav" style="margin: 10px;">
        <a class="nav-link <?= $current_page == 'index.php' ? 'active' : '' ?>" href="index.php"><b>Home</b></a>
        <a class="nav-link <?= $current_page == 'data_kriteria.php' ? 'active' : '' ?>" href="data_kriteria.php"><b>Data Kriteria</b></a>
        <a class="nav-link <?= $current_page == 'cafe.php' ? 'active' : '' ?>" href="cafe.php"><b>Data Cafe Purwakarta</b></a>
        <a class="nav-link <?= $current_page == 'data_cafe.php' ? 'active' : '' ?>" href="data_cafe.php"><b>Perhitungan</b></a>
        <a class="nav-link <?= $current_page == 'laporan.php' ? 'active' : '' ?>" href="laporan.php"><b>Laporan</b></a>
      </div>
      <div class="navbar-nav ms-auto" style="margin: 10px;">
        <a class="log nav-link" href="../logout.php"><b>Logout</b><img src="../img/logout.png" width="30"></a>
      </div>
    </div>
  </nav>

  <div class="container bg-light shadow p-3 mb-5">
    <div class="alert alert-info">
      <center><b>DATA CAFE PURWAKARTA</b></center>
    </div>

    <div class="form-inline">
      <form method="POST" action="" class="form-group">
        <input type="text" name="input" autofocus autocomplete="off" class="form-control" placeholder="Cari...">
        <button type="submit" name="cari" class="btn btn-brown">Cari</button>
      </form>
    </div>
    <br>
    <a href="tambah_data_cafe.php" class="btn btn-light-brown text-dark" style="margin-left: 10px;"><b>Tambah Data</b></a>

    <form method="POST" action="perhitungan.php" class="d-inline">
      <button type="submit" name="perhitungan" class="btn btn-dark-brown text-light" style="margin-left: 10px;" id="hitungButton" disabled>
        <b>Hitung</b>
      </button>
      <br><br>

      <table class="table table-striped shadow p-3 mb-5">
        <?php $tot = mysqli_num_rows($data_cafe1); 
        echo "Total Data : <b>" . $tot . "</b>";
        ?>
        <tr class="bg-info">
          <th>Pilih <br> (semua) <br>
            <input type="checkbox" onChange="checkAll(this)" name="chk[]">
          </th>
          <th>Id Alternatif</th>
          <th>Nama Alternatif</th>
          <th>Jarak (C1)</th>
          <th>Harga Makanan (C2)</th>
          <th>Harga Minuman (C3)</th>
          <th>Fasilitas (C4)</th>
          <th>Kualitas (C5)</th>
          <th>Aksi</th>
        </tr>

        <?php foreach ($data_cafe as $cafe) { ?>
          <tr>
            <td><input type="checkbox" name="id_alternatif[]" class="checkbox_item" value="<?= $cafe['id_alternatif']; ?>" onchange="toggleHitungButton()"></td>
            <td><?= $cafe['id_alternatif']; ?></td>
            <td><?= $cafe['nama_alternatif']; ?></td>
            <td><?= $cafe['c1']; ?></td>
            <td><?= $cafe['c2']; ?></td>
            <td><?= $cafe['c3']; ?></td>
            <td><?= $cafe['c4']; ?></td>
            <td><?= $cafe['c5']; ?></td>
            <td>
              <a href="edit_data_cafe.php?id_alternatif=<?= $cafe['id_alternatif']; ?>" class="btn btn-warning">Edit</a> 
              <a href="hapus_data_cafe.php?id_alternatif=<?= $cafe['id_alternatif']; ?>" class="btn btn-danger">Delete</a>
            </td>
          </tr>
        <?php } ?>
      </table>
    </div>
  </form>

  <script>  
    function checkAll(source) {
      var checkboxes = document.querySelectorAll('.checkbox_item');
      checkboxes.forEach(function(checkbox) {
        checkbox.checked = source.checked;
      });
      toggleHitungButton();
    }

    function toggleHitungButton() {
      var checkboxes = document.querySelectorAll('.checkbox_item');
      var hitungButton = document.getElementById('hitungButton');
      hitungButton.disabled = !Array.from(checkboxes).some(checkbox => checkbox.checked);
    }
  </script>

  <div class="col-md-12 bg-primary">
    <div class="copyright">
      <h6>Copyright&copy; Kelompok 5</h6>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
</body>
</html>