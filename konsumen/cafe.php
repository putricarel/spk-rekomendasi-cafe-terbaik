<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);

$conn = mysqli_connect("localhost", "root", "", "moora");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT nama_alternatif, jarak, harga_makanan, harga_minuman, fasilitas, kualitas FROM cafe";
$result = $conn->query($query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_alternatif = $_POST['nama_alternatif'];
    $jarak = $_POST['jarak'];
    $harga_makanan = $_POST['harga_makanan'];
    $harga_minuman = $_POST['harga_minuman'];
    $fasilitas = $_POST['fasilitas'];
    $kualitas = $_POST['kualitas'];

    $insert_query = "INSERT INTO cafe (nama_alternatif, jarak, harga_makanan, harga_minuman, fasilitas, kualitas) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssss", $nama_alternatif, $jarak, $harga_makanan, $harga_minuman, $fasilitas, $kualitas);

    if ($stmt->execute()) {
        header("Location: cafe.php"); // Refresh the page to see new data
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #D2B48C;
            background-image: url(../img/galeri/poto.jpg);
            background-size: cover;
        }

        .navbar {
            background-color: #8B4513;
        }

        .navbar-brand img {
            border-radius: 50%;
        }

        .navbar-nav .nav-link {
            color: #FFFF;
        }

        .navbar-nav .nav-link.active {
            color: #FFFF !important;
            font-weight: bold;
        }

        .navbar-nav .nav-link:hover {
            color: #FFFF !important;
        }

        .container {
            background-color: #F5DEB3;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-brown {
            background-color: #8B4513; /* Brown color */
            color: white; /* Text color */
        }

        .btn-brown:hover {
            background-color: #7a3e12; /* Darker shade on hover */
        }

        /* Carousel */
        .carousel img {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bg-primary {
            background-color: #8B4513 !important;
            padding: 8px;
            color: #F5DEB3 !important;
        }

        .alert-brown {
            background-color: #8B4513;
            color: #FFFFFF;
            font-weight: bold;
            border: none;
        }

        .copyright h6 {
            margin: 10px 0;
            font-weight: bold;
            text-align: center;
        }
    </style>

    <title>Data Cafe Purwakarta</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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
            <a class="log nav-link" href="../logout.php"><b>Logout</b><img src="../img/logout.png" width="30"></a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Data Cafe Purwakarta</h2>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Nama Alternatif</th>
                <th>Jarak</th>
                <th>Harga Makanan</th>
                <th>Harga Minuman</th>
                <th>Fasilitas</th>
                <th>Kualitas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['nama_alternatif']}</td>
                            <td>{$row['jarak']}</td>
                            <td>{$row['harga_makanan']}</td>
                            <td>{$row['harga_minuman']}</td>
                            <td>{$row['fasilitas']}</td>
                            <td>{$row['kualitas']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>