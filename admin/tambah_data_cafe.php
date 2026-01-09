<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

require '../functions.php';

// Database connection
$conn = mysqli_connect("localhost", "root", "", "moora");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch nama_alternatif for the select options, excluding those already used
$query_nama_alternatif = "
SELECT nama_alternatif 
FROM cafe 
WHERE nama_alternatif NOT IN (
    SELECT nama_alternatif FROM alternatif
)
";
$result_nama_alternatif = $conn->query($query_nama_alternatif);

// Handle form submission
if (isset($_POST['simpan'])) {
    if (tambah_cafe($_POST) > 0) {
        echo "<script>
        alert('Data Berhasil Di Tambah');
        document.location.href='data_cafe.php';
        </script>";
    } else {
        echo "<script>
        alert('Data Gagal Di Tambah');
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
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <title>TAMBAH DATA CAFE</title>
        <style>
            body {
                background-color: #f0f0f0;
            }
            .container {
                min-height: calc(100vh - 211px);
            }
            .col-md-12.bg-primary {
                padding: 8px;
                background-color: #8B4513 !important;
            }
            .copyright {
                text-align: center;
                color: #fff;
            }
            .navbar-nav a:hover {
                color: darkblue;
            }
        </style>
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
                <div class="navbar-nav ml-auto" style="margin: 10px;">
                    <a class="log nav-link" href="../logout.php"><b>Logout</b><img src="../img/logout.png" width="30"></a>
                </div>
            </div>
        </nav>

        <div class="container bg-light shadow p-3 mb-5">
            <h2 class="text-center">TAMBAH DATA CAFE</h2>
            <form method="post">
                <table class="table">
                    <tr>
                        <td><label>Id Alternatif</label></td>
                        <td><input type="text" name="id_alternatif" class="form-control" required></td>
                    </tr>
                    <tr>
                        <td><label>Nama Alternatif</label></td>
                        <td>
                            <select name="nama_alternatif" class="form-control" required>
                                <option value="">Select Nama Alternatif</option>
                                <?php
                                if ($result_nama_alternatif) {
                                    if ($result_nama_alternatif->num_rows > 0) {
                                        while ($row = $result_nama_alternatif->fetch_assoc()) {
                                            echo "<option value=\"{$row['nama_alternatif']}\">{$row['nama_alternatif']}</option>";
                                        }
                                    } else {
                                        echo "<option value=\"\">No Data Available</option>";
                                    }
                                } else {
                                    die("Query failed: " . $conn->error);
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Jarak (C1)</label></td>
                        <td>
                            <select name="c1" class="form-control" required>
                                <option value="">Select Jarak</option>
                                <?php foreach ($c1_options as $value => $label) : ?>
                                    <option value="<?= $value; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Harga Makanan (C2)</label></td>
                        <td>
                            <select name="c2" class="form-control" required>
                                <option value="">Select Harga Makanan</option>
                                <?php foreach ($c2_options as $value => $label) : ?>
                                    <option value="<?= $value; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Harga Minuman (C3)</label></td>
                        <td>
                            <select name="c3" class="form-control" required>
                                <option value="">Select Harga Minuman</option>
                                <?php foreach ($c3_options as $value => $label) : ?>
                                    <option value="<?= $value; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Fasilitas (C4)</label></td>
                        <td>
                            <select name="c4" class="form-control" required>
                                <option value="">Select Fasilitas</option>
                                <?php foreach ($c4_options as $value => $label) : ?>
                                    <option value="<?= $value; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label>Kualitas (C5)</label></td>
                        <td>
                            <select name="c5" class="form-control" required>
                                <option value="">Select Kualitas</option>
                                <?php foreach ($c5_options as $value => $label) : ?>
                                    <option value="<?= $value; ?>"><?= $label; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" name="simpan" class="btn btn-success">Simpan</button>
                            <a href="data_cafe.php" class="btn btn-danger">Batal</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="col-md-12 bg-primary">
            <div class="copyright">
                <h6>Copyright&copy; Kelompok 5</h6>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>

    <?php
    $conn->close();
?>