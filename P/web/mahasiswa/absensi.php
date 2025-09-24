<?php
session_start();
require '../koneksi.php';

// Pastikan mahasiswa sudah login
if (!isset($_SESSION['id_mahasiswa'])) {
    header("Location: login.php");
    exit;
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tanggal = $_POST['tanggal'];
    $status_kehadiran = $_POST['status_kehadiran'];
    $deskripsi_kegiatan = $_POST['deskripsi_kegiatan'];

    // Insert absensi
    $query_absensi = "INSERT INTO absensi (id_mahasiswa, tanggal, status_kehadiran) VALUES ('$id_mahasiswa', '$tanggal', '$status_kehadiran')";
    mysqli_query($koneksi, $query_absensi);

    // Insert kegiatan
    $query_kegiatan = "INSERT INTO kegiatan (id_mahasiswa, tanggal, deskripsi_kegiatan) VALUES ('$id_mahasiswa', '$tanggal', '$deskripsi_kegiatan')";
    mysqli_query($koneksi, $query_kegiatan);

    $success = "Absensi dan kegiatan berhasil dicatat.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Absensi Harian</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="../../Style/style.css" />
</head>
<body>
    <div class="grid-container">
        <header class="header">
            </header>

        <aside id="sidebar">
            <?php include 'navigasi.php'; ?>
        </aside>

        <main class="main-container">
            <div class="main-title">
                <p class="font-weight-bold">ABSENSI DAN KEGIATAN HARIAN</p>
            </div>

            <div class="charts">
                <div class="charts-card">
                    <p class="chart-title">Input Absensi dan Kegiatan</p>
                    <?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>
                    <form method="POST">
                        <label>Tanggal</label><br>
                        <input type="date" name="tanggal" required><br><br>

                        <label>Status Kehadiran</label><br>
                        <select name="status_kehadiran" required>
                            <option value="Hadir">Hadir</option>
                            <option value="Izin">Izin</option>
                            <option value="Sakit">Sakit</option>
                        </select><br><br>

                        <label>Deskripsi Kegiatan</label><br>
                        <textarea name="deskripsi_kegiatan" required></textarea><br><br>

                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>