<?php
session_start();
// Redirect to login if session 'status' is not set
if (!isset($_SESSION['status'])) {
    header("Location: ../index.php?pesan=logindahulu");
    exit;
}

require '../functions.php'; // Ensure this file contains the function to connect to the database

// Open all data from the 'alternatif' table
$data_cafe = tampilcafe("SELECT * FROM alternatif");

// Re-fetch total data
$data_cafe1 = mysqli_query($con, "SELECT * FROM alternatif");

// Process search request
if (isset($_POST['cari'])) {
    $input = $_POST['input'];
    // Display data matching the search input
    $data_cafe = tampilcafe("SELECT * FROM alternatif WHERE nama_alternatif LIKE '%$input%'");
}
?>

<!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

        <style>
            body {
                background-color: #f0f0f0;
            }

            .container {
                min-height: calc(100vh - 211px - -60px);
            }

            .navbar-nav .nav-link.active {
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
            .bg-brown-input {
                background-color: #D2B48C; 
                border: 1px solid #8B4513; 
                color: #FFFFFF;
            }
            .btn-brown {
                background-color: #8B4513; 
                color: #FFFFFF;
                border: none;
            }
        </style>
    </head>

    <body>
        <?php
        $currentPage = basename($_SERVER['PHP_SELF']);
        ?>

        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #8B4513;">
            <a class="navbar-brand" href="#"><img src="../img/stt.png" width="50"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>" href="index.php">
                        <font size="4"><b>Home</b></font>
                    </a>
                    <a class="nav-link <?php echo ($currentPage == 'data_cafe.php') ? 'active' : ''; ?>" href="data_cafe.php">
                        <font size="4"><b>Perhitungan</b></font>
                    </a>
                </div>
                <div class="navbar-nav ml-auto">
                    <a class="log nav-link" href="../logout.php">
                        <font size="4"><b>Logout</b></font>
                        <img src="../img/logout.png" width="30">
                    </a>
                </div>
            </div>
        </nav>
        <br>
        <div class="container bg-light shadow p-3 mb-5">
            <div class="alert alert-info">
                <center><b>DATA CAFE PURWAKARTA</b></center>
            </div>

            <div class="form-inline mb-3">
                <form method="POST" action="" class="form-group">
                 <input type="text" name="input" autofocus autocomplete="off" class="form-control shadow bg-brown-input text-light" placeholder="Cari...">
                 <button type="submit" name="cari" class="btn btn-brown shadow">Cari</button>
             </form>
         </div>

         <script>
            function checkAll(ele) {
                var checkboxes = document.getElementsByTagName('input');
                if (ele.checked) {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = true;
                        }
                    }
                } else {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = false;
                        }
                    }
                }
            }
        </script>

        <div class="table-responsive">
            <table class="table table-striped shadow">
                <?php $tot = mysqli_num_rows($data_cafe1);
                echo "Total Data : <b>" . $tot . "</b>";
                ?>
                <tr class="bg-info">
                    <th>Id Alternatif</th>
                    <th>Nama Alternatif</th>
                    <th>Jarak (C1)</th>
                    <th>Harga Makanan (C2)</th>
                    <th>Harga Minuman (C3)</th>
                    <th>Fasilitas (C4)</th>
                    <th>Kualitas (C5)</th>
                </tr>

                <?php foreach ($data_cafe as $cafe) { ?>
                    <tr>
                      <td><?= $cafe['id_alternatif']; ?></td>
                      <td><?= $cafe['nama_alternatif']; ?></td>
                      <td><?= $cafe['c1']; ?></td>
                      <td><?= $cafe['c2']; ?></td>
                      <td><?= $cafe['c3']; ?></td>
                      <td><?= $cafe['c4']; ?></td>
                      <td><?= $cafe['c5']; ?></td>
                    </tr>
                <?php } ?>
            </table>
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