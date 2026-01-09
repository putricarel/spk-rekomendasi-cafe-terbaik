<?php
session_start();
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "moora");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Include the ID in the query
$query = "SELECT id, nama_alternatif, jarak, harga_makanan, harga_minuman, fasilitas, kualitas FROM cafe";
$result = $conn->query($query);

// Handle form submission for adding a cafe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
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
        header("Location: cafe.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle form submission for deleting a cafe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = $_POST['id'];

    $delete_query = "DELETE FROM cafe WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: cafe.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Handle form submission for editing a cafe
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $id = $_POST['id'];
    $nama_alternatif = $_POST['nama_alternatif'];
    $jarak = $_POST['jarak'];
    $harga_makanan = $_POST['harga_makanan'];
    $harga_minuman = $_POST['harga_minuman'];
    $fasilitas = $_POST['fasilitas'];
    $kualitas = $_POST['kualitas'];

    $update_query = "UPDATE cafe SET nama_alternatif = ?, jarak = ?, harga_makanan = ?, harga_minuman = ?, fasilitas = ?, kualitas = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $nama_alternatif, $jarak, $harga_makanan, $harga_minuman, $fasilitas, $kualitas, $id);

    if ($stmt->execute()) {
        header("Location: cafe.php");
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
            .container {
                background-color: #FFF;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            }
            .btn-brown {
                background-color: #8B4513;
                color: white;
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
        </style>
        <title>Data Cafe Purwakarta</title>
    </head>
    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus cafe ini?");
        }

        function setEditData(cafe) {
            document.getElementById('edit_id').value = cafe.id;
            document.getElementById('edit_nama_alternatif').value = cafe.nama_alternatif;
            document.getElementById('edit_jarak').value = cafe.jarak;
            document.getElementById('edit_harga_makanan').value = cafe.harga_makanan;
            document.getElementById('edit_harga_minuman').value = cafe.harga_minuman;
            document.getElementById('edit_fasilitas').value = cafe.fasilitas;
            document.getElementById('edit_kualitas').value = cafe.kualitas;
        }
    </script>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php"><b>Home</b></a>
                    <a class="nav-link" href="data_kriteria.php"><b>Data Kriteria</b></a>
                    <a class="nav-link" href="cafe.php"><b>Data Cafe Purwakarta</b></a>
                    <a class="nav-link" href="data_cafe.php"><b>Perhitungan</b></a>
                    <a class="nav-link" href="laporan.php"><b>Laporan</b></a>
                </div>
                <div class="navbar-nav ml-auto">
                    <a class="log nav-link" href="../logout.php"><b>Logout</b><img src="../img/logout.png" width="30"></a>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <div class="alert alert-info">
                <center><b>Data Cafe Purwakarta</b></center>
            </div>
            <button class="btn btn-brown" data-bs-toggle="modal" data-bs-target="#addCafeModal">Tambah Cafe</button>
            <div class="table-responsive p-4">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Alternatif</th>
                            <th>Jarak</th>
                            <th>Harga Makanan</th>
                            <th>Harga Minuman</th>
                            <th>Fasilitas</th>
                            <th>Kualitas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($cafe = $result->fetch_assoc()) {
                                echo "<tr>
                                <td>{$no}</td>
                                <td>{$cafe['nama_alternatif']}</td>
                                <td>{$cafe['jarak']}</td>
                                <td>{$cafe['harga_makanan']}</td>
                                <td>{$cafe['harga_minuman']}</td>
                                <td>{$cafe['fasilitas']}</td>
                                <td>{$cafe['kualitas']}</td>
                                <td>
                                <button class='btn btn-warning btn-sm' data-bs-toggle='modal' data-bs-target='#editCafeModal' onclick='setEditData(".json_encode($cafe).")'>Edit</button>
                                <form method='POST' action='' style='display:inline;' onsubmit='return confirmDelete();'>
                                <input type='hidden' name='id' value='{$cafe['id']}'>
                                <input type='hidden' name='action' value='delete'>
                                <button type='submit' class='btn btn-danger btn-sm'>Hapus</button>
                                </form>
                                </td>
                                </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Cafe Modal -->
        <div class="modal fade" id="addCafeModal" tabindex="-1" aria-labelledby="addCafeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCafeModalLabel">Tambah Cafe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="add">
                            <div class="mb-3">
                                <label for="nama_alternatif" class="form-label">Nama Alternatif</label>
                                <input type="text" class="form-control" id="nama_alternatif" name="nama_alternatif" required>
                            </div>
                            <div class="mb-3">
                                <label for="jarak" class="form-label">Jarak</label>
                                <input type="text" class="form-control" id="jarak" name="jarak" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_makanan" class="form-label">Harga Makanan</label>
                                <input type="text" class="form-control" id="harga_makanan" name="harga_makanan" required>
                            </div>
                            <div class="mb-3">
                                <label for="harga_minuman" class="form-label">Harga Minuman</label>
                                <input type="text" class="form-control" id="harga_minuman" name="harga_minuman" required>
                            </div>
                            <div class="mb-3">
                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                <input type="text" class="form-control" id="fasilitas" name="fasilitas" required>
                            </div>
                            <div class="mb-3">
                                <label for="kualitas" class="form-label">Kualitas</label>
                                <input type="text" class="form-control" id="kualitas" name="kualitas" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Cafe Modal -->
        <div class="modal fade" id="editCafeModal" tabindex="-1" aria-labelledby="editCafeModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCafeModalLabel">Edit Cafe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="">
                            <input type="hidden" name="action" value="edit">
                            <input type="hidden" name="id" id="edit_id">
                            <div class="mb-3">
                                <label for="edit_nama_alternatif" class="form-label">Nama Alternatif</label>
                                <input type="text" class="form-control" id="edit_nama_alternatif" name="nama_alternatif" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_jarak" class="form-label">Jarak</label>
                                <input type="text" class="form-control" id="edit_jarak" name="jarak" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_harga_makanan" class="form-label">Harga Makanan</label>
                                <input type="text" class="form-control" id="edit_harga_makanan" name="harga_makanan" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_harga_minuman" class="form-label">Harga Minuman</label>
                                <input type="text" class="form-control" id="edit_harga_minuman" name="harga_minuman" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_fasilitas" class="form-label">Fasilitas</label>
                                <input type="text" class="form-control" id="edit_fasilitas" name="fasilitas" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_kualitas" class="form-label">Kualitas</label>
                                <input type="text" class="form-control" id="edit_kualitas" name="kualitas" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>