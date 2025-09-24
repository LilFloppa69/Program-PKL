<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['id_mitra'])) {
    header("Location: dashboard_mitra.php");
    exit;
}

$id_mitra = $_SESSION['id_mitra'];
$nama_mitra = $_SESSION['nama_mitra'];

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>Dashboard Mitra</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
  <link rel="stylesheet" href="../../Style/style.css" />
</head>
<body>
  <div class="grid-container">
    <!-- Header -->
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

    <!-- Sidebar -->
    <aside id="sidebar">
      <?php include 'navigasi.php'?>
    </aside>

    <!-- Main -->
    <main class="main-container">
      <div class="main-title">
        <p class="font-weight-bold">
          <?php
          if ($page == 'input_lowongan') {
              echo 'INPUT LOWONGAN PKL';
          } elseif ($page == 'pendaftaran') {
              echo 'DAFTAR PENDAFTARAN MAHASISWA';
          } elseif ($page == 'persetujuan') {
              echo 'SETUJUI / TOLAK PENDAFTARAN';
          } else {
              echo 'SELAMAT DATANG, ' . htmlspecialchars($nama_mitra);
          }
          ?>
        </p>
      </div>

      <?php if ($page == 'dashboard'): ?>
      <div class="main-cards">
        <div class="card">
          <div class="card-inner">
            <p class="text-primary">INPUT LOWONGAN</p>
            <span class="material-icons-outlined text-blue">post_add</span>
          </div>
          <a href="dashboard_mitra.php?page=input_lowongan" class="text-primary font-weight-bold">Lihat Detail</a>
        </div>
        <div class="card">
          <div class="card-inner">
            <p class="text-primary">PENDAFTARAN MAHASISWA</p>
            <span class="material-icons-outlined text-orange">group</span>
          </div>
          <a href="dashboard_mitra.php?page=pendaftaran" class="text-primary font-weight-bold">Lihat Detail</a>
        </div>
        <div class="card">
          <div class="card-inner">
            <p class="text-primary">PERSETUJUAN PENDAFTARAN</p>
            <span class="material-icons-outlined text-green">check_circle</span>
          </div>
          <a href="dashboard_mitra.php?page=persetujuan" class="text-primary font-weight-bold">Lihat Detail</a>
        </div>
      </div>
      <?php elseif ($page == 'input_lowongan'): ?>
          <?php include 'input_lowongan.php'; ?>
      <?php elseif ($page == 'pendaftaran'): ?>
          <?php include 'pendaftaran_mahasiswa.php'; ?>
      <?php elseif ($page == 'persetujuan'): ?>
          <?php include 'persetujuan.php'; ?>
      <?php endif; ?>
    </main>
  </div>
</body>
</html>
