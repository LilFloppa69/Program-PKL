<?php
session_start();
require '../koneksi.php';

if (!isset($_SESSION['id_dosen'])) {
    header('Location: login.php');
    exit();
}

$id_dosen = $_SESSION['id_dosen'];
$nama_dosen = $_SESSION['nama_dosen'];

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Dashboard Dosen</title>
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
  <a href="dashboard_dosen.php" class="sidebar-brand-link">
    <div class="sidebar-brand">
      <span class="material-icons-outlined">school</span> Dashboard Dosen
    </div>
  </a>
  <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
</div>
        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="dashboard_dosen.php?page=mahasiswa"> <span class="material-icons-outlined">group</span> Mahasiswa Bimbingan </a>
          </li>
          <li class="sidebar-list-item">
            <a href="dashboard_dosen.php?page=status_pkl"> <span class="material-icons-outlined">fact_check</span> Status Pendaftaran PKL </a>
          </li>
          <li class="sidebar-list-item">
            <a href="dashboard_dosen.php?page=absensi_kegiatan"> <span class="material-icons-outlined">event_note</span> Absensi & Kegiatan </a>
          </li>
        </ul>
      </aside>

<main class="main-container">
    <div class="main-title">
        <p class="font-weight-bold">
            <?php
            $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

            if ($page == 'mahasiswa') {
                echo 'DAFTAR MAHASISWA BIMBINGAN';
            } elseif ($page == 'status_pkl') {
                echo 'STATUS PENDAFTARAN PKL MAHASISWA';
            } elseif ($page == 'absensi_kegiatan') {
                echo 'DAFTAR ABSENSI DAN KEGIATAN MAHASISWA';
            } else {
                $nama_dosen = isset($_SESSION['nama_dosen']) ? htmlspecialchars($_SESSION['nama_dosen']) : 'Dosen';
                echo 'SELAMAT DATANG, ' . $nama_dosen;
            }
            ?>
        </p>
    </div>

        <?php if ($page == 'dashboard'): ?>
        <div class="main-cards">
          <div class="card">
            <div class="card-inner">
              <p class="text-primary">MAHASISWA BIMBINGAN</p>
              <span class="material-icons-outlined text-blue">group</span>
            </div>
            <a href="dashboard_dosen.php?page=mahasiswa" class="text-primary font-weight-bold">Lihat Detail</a>
          </div>
          <div class="card">
            <div class="card-inner">
              <p class="text-primary">STATUS PENDAFTARAN PKL</p>
              <span class="material-icons-outlined text-orange">fact_check</span>
            </div>
            <a href="dashboard_dosen.php?page=status_pkl" class="text-primary font-weight-bold">Lihat Detail</a>
          </div>
          <div class="card">
            <div class="card-inner">
              <p class="text-primary">ABSENSI & KEGIATAN</p>
              <span class="material-icons-outlined text-green">event_note</span>
            </div>
             <a href="dashboard_dosen.php?page=absensi_kegiatan" class="text-primary font-weight-bold">Lihat Detail</a>
          </div>
        </div>
        <?php elseif ($page == 'mahasiswa'): ?>
            <?php include 'mahasiswa_bimbingan.php'; ?>
        <?php elseif ($page == 'status_pkl'): ?>
            <?php include 'status_pkl.php'; ?>
        <?php elseif ($page == 'absensi_kegiatan'): ?>
            <?php include 'absensi_kegiatan.php'; ?>
        <?php endif; ?>

      </main>
    </div>
  </body>
</html>