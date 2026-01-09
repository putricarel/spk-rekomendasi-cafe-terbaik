<?php
session_start();
// Redirect to login if the session status is not set
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

require '../functions.php';

$kode = $_GET['kode'];
$data = query("SELECT * FROM laporan WHERE id_laporan = '$kode'");

// Calculate the summary
$alternatif_count = count($data);
$highest_ranking = null;
$highest_alternatif = null;
$highest_hasil = null;

foreach ($data as $detail_data) {
    if ($detail_data['ranking'] == 1) {
        $highest_ranking = $detail_data['ranking'];
        $highest_alternatif = $detail_data['nama_alternatif'];
        $highest_hasil = $detail_data['max_min'];
        break; // We found the highest ranking, exit the loop
    }
}

// If there are no records
if ($alternatif_count === 0) {
    $summary = "Kesimpulan: Tidak ada data untuk ditampilkan.";
} else {
    $summary = "Kesimpulan: Berdasarkan hasil perhitungan menggunakan metode MOORA, dari jumlah alternatif ($alternatif_count), dapat dilihat bahwa  '$highest_alternatif' memiliki nilai terbesar dengan hasil $highest_hasil. dengan kata lain $highest_alternatif terpilih sebagai cafe tujuan.";
}
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
            .col-md-12 {
                padding: 8px;
                background-color: #8B4513 !important;
            }
            .copyright {
                text-align: center;
                color: #FFFF;
            }
            .navbar-nav a:hover {
                color: darkblue;
            }
            tr:hover {
                transform: scale(1.03);
                font-weight: bold;
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
            @media print {
                .no-print {
                    display: none; /* Hide elements with class 'no-print' when printing */
                }
            }
        </style>
        <title>Detail Laporan</title>
    </head>

    <body>
        <form method="post" action="perhitungan.php">
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
                        <a class="nav-link active" href="laporan.php"><b>Laporan</b></a>
                    </div>

                    <div class="navbar-nav ms-auto" style="margin: 10px;">
                        <a class="log nav-link m-auto" href="../logout.php">
                            <b>Logout</b>
                            <img src="../img/logout.png" width="30">
                        </a>
                    </div>
                </div>
            </nav>
        </form>
        <br>
        <div class="container bg-light shadow p-3 mb-5">
            <div class="alert alert-info">
                <center><b>DETAIL LAPORAN</b></center>
            </div>

            <div class="no-print">
                <a href="laporan.php" class="btn" style="background-color: #6f4f1e; color: white; margin-bottom: 15px;">Kembali</a>
                <button onclick="window.print()" class="btn btn-primary" style="background-color: #6f4f1e; color: white; margin-bottom: 15px;">Cetak</button>
            </div>

            <div class="table-responsive p-4">
                <table class="table table-striped shadow">
                    <tr class="bg-info">
                        <th>ID Laporan</th>
                        <th>Tanggal</th>
                        <th>id_alternatif</th>
                        <th>nama_alternatif</th>
                        <th>Hasil</th>
                        <th>Ranking</th>
                    </tr>

                    <?php if ($alternatif_count > 0): ?>
                        <?php foreach ($data as $detail_data): ?>
                            <tr>
                                <td><?= $detail_data['id_laporan']; ?></td>
                                <td><?= $detail_data['tanggal']; ?></td>
                                <td><?= $detail_data['id_alternatif']; ?></td>
                                <td><?= $detail_data['nama_alternatif']; ?></td>
                                <td><?= $detail_data['max_min']; ?></td>
                                <td><?= $detail_data['ranking']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data ditemukan</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>

            <div class="alert alert-info">
                <p><?= $summary; ?></p>
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