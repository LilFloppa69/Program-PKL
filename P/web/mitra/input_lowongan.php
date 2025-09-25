<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../koneksi.php';

// Pastikan hanya mitra yang login
if (!isset($_SESSION['id_mitra'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $program = $_POST['program'];
    $mitra = $_POST['mitra'];
    $periode_mulai = $_POST['periode_mulai'];
    $periode_selesai = $_POST['periode_selesai'];
    $tahun_ajaran = $_POST['tahun_ajaran'];
    $kategori = $_POST['kategori'];
    $id_mitra = $_SESSION['id_mitra'];

    // Gabungkan periode
    $periode = $periode_mulai . " s.d " . $periode_selesai;

    $query = "INSERT INTO lowongan_pkl (id_mitra, program, mitra, periode, tahun_ajaran, kategori) 
              VALUES ('$id_mitra', '$program', '$mitra', '$periode', '$tahun_ajaran', '$kategori')";
    if (mysqli_query($koneksi, $query)) {
        $success = "Lowongan berhasil ditambahkan.";
    } else {
        $error = "Gagal menambahkan lowongan: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Lowongan</title>
    <link rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 400px;
            margin: 50px auto;
            padding: 25px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        input, textarea, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #45a049;
        }

        .periode {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .periode input {
            flex: 1;
        }

        .success {
            color: green;
            margin-top: 10px;
            text-align: center;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

    </style>
</head>
<body>
<div class="container">
    <h2>Input Lowongan</h2>
    <form method="POST">
        <label>Program</label>
        <input type="text" name="program" required>

        <label>Mitra</label>
        <input type="text" name="mitra" required>

        <label>Periode Program</label>
        <div class="periode">
            <input type="date" name="periode_mulai" required> 
            <span>sampai</span> 
            <input type="date" name="periode_selesai" required>
        </div>

        <label>Tahun Ajaran</label>
        <input type="text" name="tahun_ajaran" placeholder="2025/2026" required>

        <label>Kategori</label>
        <select name="kategori" required>
            <option value="">-- Pilih Kategori --</option>
            <option value="WFH">WFH</option>
            <option value="WFO">WFO</option>
        </select>

        <button type="submit">Simpan</button>
    </form>

    <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
</div>
</body>
</html>
