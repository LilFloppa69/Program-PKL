<?php
session_start();
include("../koneksi.php"); // file koneksi yang tadi kamu buat

// pastikan mahasiswa sudah login
if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: login_mahasiswa.php");
    exit;
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

// ambil data mahasiswa
$query = "SELECT nama_mahasiswa FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_mahasiswa = $row['nama_mahasiswa'];
} else {
    $nama_mahasiswa = "Mahasiswa";
}

// ambil data dosen utk ditampilkan ke cardnya ya kon

$query = "
    SELECT m.nama_mahasiswa, d.nama_dosen 
    FROM mahasiswa m 
    LEFT JOIN dosen d ON m.id_dosen_pembimbing = d.id_dosen 
    WHERE m.id_mahasiswa = '$id_mahasiswa'
";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $nama_mahasiswa = $row['nama_mahasiswa'];
    $nama_dosen = $row['nama_dosen'] ?? "Belum ada dosen pembimbing";
} else {
    $nama_mahasiswa = "Mahasiswa";
    $nama_dosen = "Belum ada dosen pembimbing";
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

    <link rel="stylesheet" href="../../Style/style.css" />
  </head>
  <body>
    <div class="grid-container">
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
          <span class="material-icons-outlined">search</span>
        </div>
        <div class="header-right">
          <span class="material-icons-outlined">notifications</span>
          <span class="material-icons-outlined">email</span>
          <span class="material-icons-outlined">account_circle</span>
        </div>
      </header>

      <aside id="sidebar">
        <?php include 'navigasi.php';?>
      </aside>

      <main class="main-container">
        <div class="main-title">
          <h1 class="font-weight-bold">Halo, <?php echo $nama_mahasiswa; ?></h1>
          <h2 class="font-weight-bold">Dashboard Aktivitas Magang</h2>
          <p class="activity font-weight-bold">Oops kamu belum mendaftar magang samsek</p>
        </div>

        <div class="main-cards">
          <div class="card">
            <div class="card-inner">
              <p class="text-primary">PRODUCTS</p>
              <span class="material-icons-outlined text-blue">inventory_2</span>
            </div>
            <span class="text-primary font-weight-bold">249</span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">Dosen Pembimbing</p>
              <span class="material-icons-outlined text-orange">person</span>
            </div>
            <span class="text-primary font-weight-bold">
              <?php echo htmlspecialchars($nama_dosen); ?> 
            </span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">SALES ORDERS</p>
              <span class="material-icons-outlined text-green">shopping_cart</span>
            </div>
            <span class="text-primary font-weight-bold">79</span>
          </div>

          <div class="card">
            <div class="card-inner">
              <p class="text-primary">INVENTORY ALERTS</p>
              <span class="material-icons-outlined text-red">notification_important</span>
            </div>
            <span class="text-primary font-weight-bold">56</span>
          </div>
        </div>

        <div class="charts">
          <div class="charts-card">
            <p class="chart-title">Top 5 Products</p>
            <div id="bar-chart"></div>
          </div>

          <div class="charts-card">
            <p class="chart-title">Purchase and Sales Orders</p>
            <div id="area-chart"></div>
          </div>
        </div>
      </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

    <script src="js/scripts.js"></script>
  </body>
</html>
