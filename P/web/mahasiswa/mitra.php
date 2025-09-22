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
        <div class="sidebar-title">
          <div class="sidebar-brand"><span class="material-icons-outlined">inventory</span> Magang Gak jadi</div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="mahasiswa.php" target="_blank"> <span class="material-icons-outlined">dashboard</span> Dashboard </a>
          </li>
          <li class="sidebar-list-item">
            <a href="mitra.php" target="_blank"> <span class="material-icons-outlined">filter_list</span> Daftar Mitra </a>
          </li>
          <li class="sidebar-list-item">
            <a href="absensi.php" target="_blank"> <span class="material-icons-outlined">watch</span> Absensi Harian </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank"> <span class="material-icons-outlined">assignment</span> Logbook </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank"> <span class="material-icons-outlined">shopping_cart</span> Sales Orders </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank"> <span class="material-icons-outlined">poll</span> Reports </a>
          </li>
          <li class="sidebar-list-item">
            <a href="#" target="_blank"> <span class="material-icons-outlined">settings</span> Settings </a>
          </li>
        </ul>
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
            <tr>
              <td>Program Program Plug and Play USU - Ganjil 2025/2026</td>
              <td>Direktorat Pengembangan Pendidikan</td>
              <td>2025-08-19 s/d 2026-01-07</td>
              <td>Ganjil 2025/2026</td>
              <td>Plug n Play</td>
              <td><a href="#" class="link-box">Detail</a></td>
            </tr>
            <tr>
              <td>KKN Tematik USU Ganjil 2025/2026</td>
              <td>Direktorat Pengembangan Pendidikan</td>
              <td>2025-08-19 s/d 2026-01-07</td>
              <td>Ganjil 2025/2026</td>
              <td>KKN Tematik USU</td>
              <td><a href="#" class="link-box">Detail</a></td>
            </tr>
          </tbody>
        </table>
      </main>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.3/apexcharts.min.js"></script>

    <script src="js/scripts.js"></script>
  </body>
</html>
