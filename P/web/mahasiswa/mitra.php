<?php
session_start();
require '../koneksi.php';

// Query ambil semua lowongan dari mitra
$query = "SELECT lp.id_lowongan, lp.program, lp.mitra, lp.periode, lp.tahun_ajaran, lp.kategori 
          FROM lowongan_pkl lp
          JOIN mitra m ON lp.id_mitra = m.id_mitra
          ORDER BY lp.created_at DESC";
$result = mysqli_query($koneksi, $query);
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
          <h1 class="font-weight-bold Program">Daftar Program</h1>
          <h2 class="font-weight-bold">Daftar program yang ditawarkan</h2>
        </div>

        <table class="custom-table">
          <thead>
            <tr>
              <th>PROGRAM</th>
              <th>MITRA</th>
              <th>PERIODE PROGRAM</th>
              <th>TAHUN AJARAN</th>
              <th>KATEGORI</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?= htmlspecialchars($row['program']); ?></td>
                  <td><?= htmlspecialchars($row['mitra']); ?></td>
                  <td><?= htmlspecialchars($row['periode']); ?></td>
                  <td><?= htmlspecialchars($row['tahun_ajaran']); ?></td>
                  <td><?= htmlspecialchars($row['kategori']); ?></td>
                  <td><a href="pendaftaran_pkl.php?id_lowongan=<?= $row['id_lowongan']; ?>" class="link-box">Daftar</a></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" style="text-align:center;">Belum ada program tersedia</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>
    <script src="js/scripts.js"></script>
  </body>
</html>
