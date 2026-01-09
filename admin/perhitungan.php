<?php
session_start();
if (!isset($_SESSION['status'])) {
  header("Location: ../xml_get_current_byte_index(parser).php?pesan=logindahulu");
  exit;
}
require '../functions.php';


if (!isset($_POST['id_alternatif'])) {
  echo "<script>
  alert('Pilih Data Cafe Dahulu ! ')
  document.location.href='data_cafe.php'
  </script>";
} else {

  //JIKA MENERIMA DATA ID ALTERNATIF MAKA JALANKAN HALAMAN perhitungan.php

  //BUKA TABLE KRITERIA DAN TAMPILKAN FIELD jarak
  $datakriteriajarak = mysqli_query($con, "SELECT * FROM kriteria WHERE kriteria = 'jarak'");
  $jarak = mysqli_fetch_assoc($datakriteriajarak);

  //BUKA TABLE KRITERIA DAN TAMPILKAN FIELD makanan
  $datakriteriamakanan = mysqli_query($con, "SELECT * FROM kriteria WHERE kriteria = 'Harga Makan'");
  $makanan = mysqli_fetch_assoc($datakriteriamakanan);

  //BUKA TABLE KRITERIA DAN TAMPILKAN FIELD minuman
  $datakriteriaminuman = mysqli_query($con, "SELECT * FROM kriteria WHERE kriteria = 'Harga Minuman'");
  $minuman = mysqli_fetch_assoc($datakriteriaminuman);

  //BUKA TABLE KRITERIA DAN TAMPILKAN FIELD fasilitas
  $datakriteriafasilitas = mysqli_query($con, "SELECT * FROM kriteria WHERE kriteria = 'Fasilitas'");
  $fasilitas = mysqli_fetch_assoc($datakriteriafasilitas);

  //BUKA TABLE KRITERIA DAN TAMPILKAN FIELD fasilitas
  $datakriteriakualitas = mysqli_query($con, "SELECT * FROM kriteria WHERE kriteria = 'Kualitas'");
  $kualitas = mysqli_fetch_assoc($datakriteriakualitas);

  if (!isset($_POST['id_alternatif'])) {
    echo "<script>
    alert('Pilih Data Cafe Dahulu ! ')
    document.location.href='data_cafe.php'
    </script>";
  } else {
    if (isset($_POST['simpan'])) {
        // Mengambil tanggal saat ini
        $tanggal = date('Y-m-d H:i:s'); // Format tanggal yang lengkap

        // Mengambil id_laporan terakhir dari database
        $result = mysqli_query($con, "SELECT id_laporan FROM laporan WHERE DATE(tanggal) = CURDATE() ORDER BY id_laporan DESC LIMIT 1");
        $last_id = mysqli_fetch_assoc($result);

        // Generate id_laporan
        if ($last_id) {
            // Ambil angka dari id_laporan terakhir dan tambahkan 1
            $last_number = intval(substr($last_id['id_laporan'], -2)); // Ambil dua digit terakhir
            $new_number = str_pad($last_number + 1, 2, '0', STR_PAD_LEFT); // Tambahkan 1 dan format menjadi dua digit
          } else {
            $new_number = '01'; // Jika tidak ada data, mulai dari 01
          }

        $id_laporan = date('ymd') . $new_number; // Format: YYMMDDXX (YYMMDD diikuti angka yang ter-generate)

        // Menyiapkan dan mengeksekusi insert untuk setiap alternatif
        $id_alternatifs = $_POST['id_alternatif'];
        $nama_alternatifs = $_POST['nama_alternatif'];
        $max_min_values = $_POST['max_min'];
        $rankings = $_POST['ranking'];

        foreach ($id_alternatifs as $index => $id_alternatif) {
          $nama_alternatif = mysqli_real_escape_string($con, $nama_alternatifs[$index]);
          $max_min = mysqli_real_escape_string($con, $max_min_values[$index]);
          $ranking = mysqli_real_escape_string($con, $rankings[$index]);

          $insert_query = "INSERT INTO laporan (id_laporan, tanggal, id_alternatif, nama_alternatif, max_min, ranking)
          VALUES ('$id_laporan', '$tanggal', '$id_alternatif', '$nama_alternatif', '$max_min', '$ranking')";

            // Mengeksekusi query dan memeriksa kesalahan
          if (!mysqli_query($con, $insert_query)) {
            echo "Error: " . mysqli_error($con);
          }
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

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <style>
          body {
            background-color: #f0f0f0;
          }


          .container {
            min-height: calc(100vh - 211px - -60px);
          }

          .col-md-12.bg-primary {
            padding: 8px;
            background-color: #8B4513 !important;
          }

          .copyright {
            text-align: center;
            color: #fff;
          }

          a font {
            color: whitesmoke;
          }

          .navbar-nav a:hover {
            font-weight: bold;
            color: darkblue;
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

          tr:hover {
            -webkit-transform: scale(1.03);
            transform: scale(1.03);
            font-weight: bold;
          }
        </style>

        <title>PERHITUNGAN</title>
      </head>

      <body>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #8B4513;">
          <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
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
        </nav>   </form>
        <br>
        <div class="container bg-light shadow p-3 mb-5">

          <div class="alert alert-info">
            <center><b>DATA CAFE PURWAKARTA TERPILIH</b></center>
          </div>

          <div class="table-responsive p-4">
            <table class="table table-striped shadow">
              <tr class="bg-info">
                <th width="150">Id Alternatif</th>
                <th>Nama Alternatif</th>
                <th>Jarak (C1)</th>
                <th>fasilitas Makanan (C2)</th>
                <th>fasilitas Minuman (C3)</th>
                <th>Fasilitas (C4)</th>
                <th>Kualitas (C5)</th>
              </tr>

              <?php
              $id_alternatifs = $_POST['id_alternatif'];

              foreach ($id_alternatifs as $id_alternatif) {
                $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif' ");
                while ($cafe = mysqli_fetch_assoc($data)) {
                  ?>


                  <tr>
                    <td><?= $cafe['id_alternatif']; ?></td>
                    <td><?= $cafe['nama_alternatif']; ?></td>
                    <td><?= $cafe['c1']; ?></td>
                    <td><?= $cafe['c2']; ?></td>
                    <td><?= $cafe['c3']; ?></td>
                    <td><?= $cafe['c4']; ?></td>
                    <td><?= $cafe['c5']; ?></td>
                  </tr>


                  <?php
                }
              }

              ?>

            </form>
          </table>
        </div>


        <br><br>
        <h1 style="border-bottom:3px #6f4f1e solid"></h1>
        <br><br>

        <div class="alert alert-info">
          <center><b>NORMALISASI</b></center>
        </div>

        <div class="table-responsive p-4">
          <table class="table table-striped shadow">
            <tr class="bg-info">
              <th width="150">Id Alternatif</th>
              <th>Nama Alternatif</th>
              <th>Jarak (C1)</th>
              <th>Harga Makanan (C2)</th>
              <th>Harga Minuman (C3)</th>
              <th>Fasilitas (C4)</th>
              <th>Kualitas (C5)</th>
            </tr>

            <?php

            $pembagi1 = 0;
            $pembagi2 = 0;
            $pembagi3 = 0;
            $pembagi4 = 0;
            $pembagi5 = 0;

            $id_alternatifs = $_POST['id_alternatif'];
            foreach ($id_alternatifs as $id_alternatif) {
              $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif' ");
              while ($cafe = mysqli_fetch_assoc($data)) {

                $pembagi1 += pow($cafe['c1'], 2);
                $akar1 = sqrt($pembagi1);

                $pembagi2 += pow($cafe['c2'], 2);
                $akar2 = sqrt($pembagi2);

                $pembagi3 += pow($cafe['c3'], 2);
                $akar3 = sqrt($pembagi3);

                $pembagi4 += pow($cafe['c4'], 2);
                $akar4 = sqrt($pembagi4);

                $pembagi5 += pow($cafe['c5'], 2);
                $akar5 = sqrt($pembagi5);
              }
            }

            ?>



            <?php
            $id_alternatifs = $_POST['id_alternatif'];
            foreach ($id_alternatifs as $id_alternatif) {
              $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif' ");
              while ($cafe = mysqli_fetch_assoc($data)) {

                ?>


                <tr>
                  <td><?= $cafe['id_alternatif']; ?></td>
                  <td><?= $cafe['nama_alternatif']; ?></td>
                  <!-- -----------C1----------- -->
                  <td>
                    <?php $c1 = $cafe['c1'] / $akar1;
                    echo round($c1, 5); ?>
                  </td>
                  <!-- -----------C2----------- -->
                  <td>
                    <?php $c2 = $cafe['c2'] / $akar2;
                    echo round($c2, 5); ?>
                  </td>
                  <!-- -----------C3----------- -->
                  <td>
                    <?php $c3 = $cafe['c3'] / $akar3;
                    echo round($c3, 5); ?>
                  </td>
                  <!-- -----------C4----------- -->
                  <td><?php $c4 = $cafe['c4'] / $akar4;
                  echo round($c4, 5); ?>
                </td>
                <!-- -----------C5----------- -->
                <td><?php $c5 = $cafe['c5'] / $akar5;
                echo round($c5, 5); ?>
              </td>
            </tr>


            <?php

          }
        }
        ?>
      </table>
    </div>


    <br><br>
    <h1 style="border-bottom:3px #6f4f1e solid"></h1>
    <br><br>

    <div class="alert alert-info">
      <center><b>TERBOBOT</b></center>
    </div>

    <div class="table-responsive p-4">
      <table class="table table-striped shadow">
        <tr class="bg-info">
          <th width="150">Id Alternatif</th>
          <th>Nama Alternatif</th>
          <th>Jarak (C1)</th>
          <th>Harga Makanan (C2)</th>
          <th>Harga Minuman (C3)</th>
          <th>Fasilitas (C4)</th>
          <th>Kualitas (C5)</th>
        </tr>

        <?php
        $id_alternatifs = $_POST['id_alternatif'];
        foreach ($id_alternatifs as $id_alternatif) {
          $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif' ");
          while ($cafe = mysqli_fetch_assoc($data)) {

            ?>

            <tr>
              <td><?= $cafe['id_alternatif']; ?></td>
              <td><?= $cafe['nama_alternatif']; ?></td>
              <!-- -----------C1----------- -->
              <td>
                <?php $c1 = $cafe['c1'] / $akar1;
                $jarak1 = $jarak['bobot'] * $c1;
                  // echo $jarak['bobot'] . " * " . round($c1, 6) . " = " . round($jarak1, 6);
                echo round($jarak1, 5);
                ?>
              </td>
              <!-- -----------C2----------- -->
              <td>
                <?php $c2 = $cafe['c2'] / $akar2;
                $makanan1 = $makanan['bobot'] * $c2;
                  // echo $makanan['bobot'] . " * " . round($c2, 6) . " = " . round($makanan1, 6);
                echo round($makanan1, 5);
                ?>
              </td>
              <!-- -----------C3----------- -->
              <td>
                <?php $c3 = $cafe['c3'] / $akar3;
                $minuman1 = $minuman['bobot'] * $c3;
                  // echo $minuman['bobot'] . " * " . round($c3, 6) . " = " . round($minuman1, 6);
                echo round($minuman1, 5);
                ?>
              </td>
              <!-- -----------C4----------- -->
              <td>
                <?php $c4 = $cafe['c4'] / $akar4;
                $fasilitas1 = $fasilitas['bobot'] * $c4;
                  // echo $fasilitas['bobot'] . " * " . round($c4, 6) . " = " . round($fasilitas1, 6);
                echo round($fasilitas1, 5);
                ?>
              </td>
              <!-- -----------C5----------- -->
              <td>
                <?php $c5 = $cafe['c5'] / $akar5;
                $kualitas1 = $kualitas['bobot'] * $c5;
                  // echo $fasilitas['bobot'] . " * " . round($c5, 6) . " = " . round($kualitas1, 6);
                echo round($kualitas1, 5);
                ?>
              </td>
            </tr>

            <?php
          }
        }

        ?>

      </table>
    </div>


    <br><br>
    <h1 style="border-bottom:3px #6f4f1e solid"></h1>
    <br><br>

    <div class="alert alert-info">
      <center><b>HASIL AKHIR</b></center>
    </div>
    <div class="table-responsive p-4">
      <form method="POST" action="perhitungan.php"> <!-- Change to your intended action file -->
        <table class="table table-striped shadow">
          <tr class="bg-info">
            <th width="150">Id Alternatif</th>
            <th>Nama Alternatif</th>
            <th>Min(C1+C2+C3)</th>
            <th>Max(C4+C5)</th>
            <th>MAX-MIN</th>
            <th>Rangking</th>
          </tr>

          <?php
          $id_alternatifs = $_POST['id_alternatif'];
          $results = [];

            // First loop to calculate values and store results
          foreach ($id_alternatifs as $id_alternatif) {
            $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif'");
            while ($cafe = mysqli_fetch_assoc($data)) {


              $c1 = $cafe['c1'] / $akar1;
              $jarak1 = $jarak['bobot'] * $c1;

              $c2 = $cafe['c2'] / $akar2;
              $makanan1 = $makanan['bobot'] * $c2;

              $c3 = $cafe['c3'] / $akar3;
              $minuman1 = $minuman['bobot'] * $c3;

              $c4 = $cafe['c4'] / $akar4;
              $fasilitas1 = $fasilitas['bobot'] * $c4;

              $c5 = $cafe['c5'] / $akar5;
              $kualitas1 = $kualitas['bobot'] * $c5;

                    // Calculate sums for Min and Max
                    $min_sum = round($jarak1, 5) + round($makanan1, 5) + round($minuman1, 5); // C1 + C2 + C3
                    $max_sum = round($fasilitas1, 5) + round($kualitas1, 5); // C4 + C5
                    $max_min = round($max_sum - $min_sum, 5); // Max - Min

                    // Store results including max_min for ranking
                    $results[] = [
                      'id_alternatif' => $cafe['id_alternatif'],
                      'nama_alternatif' => $cafe['nama_alternatif'],
                      'min_sum' => $min_sum,
                      'max_sum' => $max_sum,
                      'max_min' => $max_min
                    ];
                  }
                }

            // Sort results by MAX-MIN for ranking
                usort($results, function ($a, $b) {
                  return $b['max_min'] <=> $a['max_min'];
                });

            // Create a mapping for ranking based on sorted results
                $rankings = [];
                foreach ($results as $index => $result) {
                $rankings[$result['id_alternatif']] = $index + 1; // Store ranking by id
              }

            // Display the original order with rankings
              foreach ($id_alternatifs as $id_alternatif) {
                $data = mysqli_query($con, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif'");
                while ($cafe = mysqli_fetch_assoc($data)) {
                  $current_id = $cafe['id_alternatif'];
                  $rank = isset($rankings[$current_id]) ? $rankings[$current_id] : '-';
                    // Find the corresponding result for min_sum, max_sum, max_min
                  foreach ($results as $result) {
                    if ($result['id_alternatif'] == $current_id) {
                      ?>
                      <tr>
                        <td><?= $result['id_alternatif']; ?></td>
                        <td><?= $result['nama_alternatif']; ?></td>
                        <td><?= round($result['min_sum'], 5); ?></td>
                        <td><?= round($result['max_sum'], 5); ?></td>
                        <td><?= round($result['max_min'], 5); ?></td>
                        <td><?= $rank; ?></td> <!-- Display rank based on sorted results -->
                      </tr>
                      <input type="hidden" name="id_alternatif[]" value="<?= $result['id_alternatif']; ?>">
                      <input type="hidden" name="nama_alternatif[]" value="<?= $result['nama_alternatif']; ?>">
                      <input type="hidden" name="max_min[]" value="<?= $result['max_min']; ?>">
                      <input type="hidden" name="ranking[]" value="<?= $rank; ?>">
                      <?php
                            break; // Exit the loop once we've found the corresponding result
                          }
                        }
                      }
                    }
                    ?>

                    <button type="submit" name="simpan" class="btn" style="float: right; background-color: #6f4f1e; color: white;">Simpan</button>
                    <br><br>
                  </table>
                </form>
              </div>


            </div>
            <div class="col-md-12 bg-primary">
              <div class="copyright">
                <h6>Copyright&copy; putricf</h6>
              </div>
            </div>
          <?php   } ?>

          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>

        </body>

        </html>