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
    <style>
    form {
        max-width: 500px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
    }

    form label {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    form input[type="date"],
    form select,
    form textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Montserrat', sans-serif;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    form input[type="date"]:focus,
    form select:focus,
    form textarea:focus {
        border-color: #77a13c;
        outline: none;
        box-shadow: 0 0 5px rgba(119, 161, 60, 0.5);
    }

    form textarea {
        min-height: 100px;
        resize: vertical;
    }

    form button {
        background: #77a13c;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 10px 16px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    form button:hover {
        background: #5d812f;
    }
</style>

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