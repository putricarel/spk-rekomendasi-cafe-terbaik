<?php
session_start();
if (!isset($_SESSION['status'])) {
  header("Location: ../index.php?pesan=logindahulu");
  exit;
}

require '../functions.php';

$id_alternatif = $_GET['id_alternatif'];
$data_cafe = tampilcafe("SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif' ")[0];

if (isset($_POST['edit'])) {
  if (edit_cafe($_POST) > 0) {
    echo "<script>
    alert('Data Berhasil Di Edit');
    document.location.href='data_cafe.php';
    </script>";
  }
}

// Opsi kriteria
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
?>

<!doctype html>
  <html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <style>
      body {
        background-color: #f0f0f0;
      }
      .container {
        min-height: calc(100vh - 211px - -60px);
      }
      .alert-info {
        background-color: #D2B48C;
        color: #5B4032;
      }
      .col-md-12 {
        padding: 8px;
        background-color: #8B4513 !important;
      }
      .copyright h6 {
        color: white !important; 
        font-size: 16px;
        text-align: center;
      }
      a font {
        color: whitesmoke;
      }
      .navbar-nav a:hover {
        color: darkblue;
      }
    </style>
    <title>EDIT DATA CAFE</title>
  </head>

  <body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #8B4513;">
      <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav" style="margin: 10px;">
          <a class="nav-link" href="index.php"><b>Home</b></a>
          <a class="nav-link" href="data_kriteria.php"><b>Data Kriteria</b></a>
          <a class="nav-link" href="cafe.php"><b>Data Cafe Purwakarta</b></a>
          <a class="nav-link" href="data_cafe.php"><b>Perhitungan</b></a>
          <a class="nav-link" href="laporan.php"><b>Laporan</b></a>
        </div>
        <div class="navbar-nav ms-auto" style="margin: 10px;">
          <a class="log nav-link" href="../logout.php"><b>Logout</b><img src="../img/logout.png" width="30"></a>
        </div>
      </div>
    </nav>

    <br>
    <div class="container bg-light shadow p-3 mb-5">
      <div class="alert alert-info">
        <center><b>EDIT DATA CAFE</b></center>
      </div>

      <div class="col-md-7">
        <form method="post" class="form-group">
          <table class="table">
            <tr>
              <td width="200"><label>Id Kriteria</label></td>
              <td> : </td>
              <td width="500"><input type="text" name="id_alternatif" value="<?= $data_cafe['id_alternatif']; ?>" readonly class="form-control" autocomplete="off"></td>
            </tr>

            <tr>
              <td><label>Nama Kriteria</label></td>
              <td> : </td>
              <td width="500"> <input type="text" name="nama_alternatif" value="<?= $data_cafe['nama_alternatif']; ?>" class="form-control" autocomplete="off"></td>
            </tr>

            <tr>
              <td><label>Jarak (C1)</label></td>
              <td> : </td>
              <td width="500">
                <select name="c1" class="form-control" required>
                  <?php foreach ($c1_options as $value => $label): ?>
                    <option value="<?= $value; ?>" <?= $data_cafe['c1'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>

            <tr>
              <td><label>Harga Makanan (C2)</label></td>
              <td> : </td>
              <td width="500">
                <select name="c2" class="form-control" required>
                  <?php foreach ($c2_options as $value => $label): ?>
                    <option value="<?= $value; ?>" <?= $data_cafe['c2'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>

            <tr>
              <td><label>Harga Minuman (C3)</label></td>
              <td> : </td>
              <td width="500">
                <select name="c3" class="form-control" required>
                  <?php foreach ($c3_options as $value => $label): ?>
                    <option value="<?= $value; ?>" <?= $data_cafe['c3'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>

            <tr>
              <td><label>Fasilitas (C4)</label></td>
              <td> : </td>
              <td width="500">
                <select name="c4" class="form-control" required>
                  <?php foreach ($c4_options as $value => $label): ?>
                    <option value="<?= $value; ?>" <?= $data_cafe['c4'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>

            <tr>
              <td><label>Kualitas (C5)</label></td>
              <td> : </td>
              <td width="500">
                <select name="c5" class="form-control" required>
                  <?php foreach ($c5_options as $value => $label): ?>
                    <option value="<?= $value; ?>" <?= $data_cafe['c5'] == $value ? 'selected' : ''; ?>><?= $label; ?></option>
                  <?php endforeach; ?>
                </select>
              </td>
            </tr>

            <tr>
              <td></td>
              <td></td>
              <td>
                <button type="submit" name="edit" class="btn btn-warning">Edit</button> &nbsp;&nbsp;&nbsp;
                <a href="data_cafe.php" class="btn btn-danger">Batal</a>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>

    <div class="col-md-12 bg-primary">
      <div class="copyright">
        <h6>Copyright&copy; Kelompok 5</h6>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  </body>

  </html>