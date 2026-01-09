<?php
session_start();
// Redirect to login if the session status is not set
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

require '../functions.php';

// Fetch unique id_laporan, corresponding tanggal, and count occurrences
$data = query("SELECT id_laporan, tanggal, COUNT(*) AS jumlah FROM laporan GROUP BY id_laporan, tanggal ORDER BY id_laporan DESC");

// Get the current page name dynamically
$current_page = basename($_SERVER['PHP_SELF']);
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
                background-color: #D2B48C;
                background-image: url(../img/galeri/poto.jpg);
                background-size: cover;
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

            .copyright {
                text-align: center;
                color: #CDD0D4;
            }

            .navbar-nav a:hover {
                color: darkblue;
            }

            .text-riwayat {
                width: 100%;
                color: grey;
                text-align: center;
                border-bottom: 1px solid grey;
                line-height: 0.1em;
                margin: 10px 0 20px;
            }

            tr:hover {
                transform: scale(1.03);
                font-weight: bold;
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

            .btn-coklat {
                background-color: #8B4513 !important; 
                border-color: #8B4513 !important;
                color: white !important; 
            }

            .btn-coklat:hover {
                background-color: #8B4513 !important; 
                border-color: #8B4513 !important;
            }
        </style>
        <title>LAPORAN</title>
    </head>

    <body bgcolor="f0f0f0">
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
                    <a class="nav-link <?= $current_page == 'data_kriteria.php' ? 'active' : '' ?>" href="data_kriteria.php">
                        <font size="4"><b>Data Kriteria</b></font>
                    </a>
                    <a class="nav-link <?= $current_page == 'cafe.php' ? 'active' : '' ?>" href="cafe.php">
                        <font size="4"><b>Data Cafe Purwakarta</b></font>
                    </a>
                    <a class="nav-link <?= $current_page == 'data_cafe.php' ? 'active' : '' ?>" href="data_cafe.php">
                        <font size="4"><b>Perhitungan</b></font>
                    </a>
                    <a class="nav-link <?= $current_page == 'laporan.php' ? 'active' : '' ?>" href="laporan.php">
                        <font size="4"><b>Laporan</b></font>
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
        <br>
        <div class="container bg-light shadow p-3 mb-5">
            <div class="alert alert-info">
                <center><b>LAPORAN CAFE PURWAKARTA TERBAIK</b></center>
            </div>

            <div class="table-responsive p-4">
                <table class="table table-striped shadow">
                    <tr class="bg-info">
                        <th width="150">ID Laporan</th>
                        <th width="300">Tanggal</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>

                    <?php foreach ($data as $hasil_akhir) { ?>
                        <tr>
                            <td><?= $hasil_akhir['id_laporan']; ?></td>
                            <td><?= $hasil_akhir['tanggal']; ?></td>
                            <td><?= $hasil_akhir['jumlah']; ?></td>
                            <td>
                                <a href="detail_laporan.php?kode=<?= $hasil_akhir['id_laporan']; ?>" class="btn btn-coklat">Lihat</a>
                                <a href="hapus_laporan.php?id_laporan=<?= $hasil_akhir['id_laporan']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <br><br>
            <h6 class="text-riwayat"><span class="bg-light">Riwayat Terbaru Pe Ranking</span></h6>
            <br><br>
        </div>

        <div class="col-md-12 bg-primary">
            <div class="copyright">
                <h6>Copyright&copy; Kelompok 5</h6>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4QqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    </body>

    </html>
