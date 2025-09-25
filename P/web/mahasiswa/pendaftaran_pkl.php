<?php
session_start();
require '../koneksi.php';

$message = "";
$message_type = "";

// Ambil id_lowongan dari URL
$id_lowongan = isset($_GET['id_lowongan']) ? $_GET['id_lowongan'] : '';

// Ambil data lowongan berdasarkan id_lowongan
$lowongan_data = null;
if ($id_lowongan) {
    $query_lowongan = "SELECT lp.id_lowongan, lp.program, lp.mitra, lp.periode, lp.tahun_ajaran, lp.kategori 
                       FROM lowongan_pkl lp 
                       WHERE lp.id_lowongan = ?";
    $stmt = mysqli_prepare($koneksi, $query_lowongan);
    mysqli_stmt_bind_param($stmt, "i", $id_lowongan);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $lowongan_data = mysqli_fetch_assoc($result);
}

// Proses form ketika di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_mahasiswa = $_POST['id_mahasiswa'];
    $tanggal_daftar = $_POST['tanggal_daftar'];
    $status = 'Pending'; // Default status
    
    // Insert ke database
    $query_insert = "INSERT INTO pendaftaran (id_mahasiswa, id_lowongan, status, tanggal_daftar) 
                     VALUES (?, ?, ?, ?)";
    
    $stmt_insert = mysqli_prepare($koneksi, $query_insert);
    mysqli_stmt_bind_param($stmt_insert, "siss", $id_mahasiswa, $id_lowongan, $status, $tanggal_daftar);
    
    if (mysqli_stmt_execute($stmt_insert)) {
        $message = "Pendaftaran berhasil disimpan!";
        $message_type = "success";
    } else {
        $message = "Error: " . mysqli_error($koneksi);
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran PKL</title>
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
            box-sizing: border-box;
        }

        input[readonly] {
            background-color: #f9f9f9;
            color: #666;
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

        .info-box {
            background: #e7f3ff;
            border: 1px solid #b3d7ff;
            border-radius: 4px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #0066cc;
        }

        .info-row {
            margin: 5px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Pendaftaran PKL</h2>
    
    <?php if ($lowongan_data): ?>
        <div class="info-box">
            <h3>Detail Program</h3>
            <div class="info-row"><strong>Program:</strong> <?= htmlspecialchars($lowongan_data['program']) ?></div>
            <div class="info-row"><strong>Mitra:</strong> <?= htmlspecialchars($lowongan_data['mitra']) ?></div>
            <div class="info-row"><strong>Periode:</strong> <?= htmlspecialchars($lowongan_data['periode']) ?></div>
            <div class="info-row"><strong>Tahun Ajaran:</strong> <?= htmlspecialchars($lowongan_data['tahun_ajaran']) ?></div>
            <div class="info-row"><strong>Kategori:</strong> <?= htmlspecialchars($lowongan_data['kategori']) ?></div>
        </div>
    <?php else: ?>
        <div class="error">Data lowongan tidak ditemukan!</div>
    <?php endif; ?>

    <?php if ($message): ?>
        <div class="<?= $message_type ?>"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($lowongan_data): ?>
    <form method="POST">
        <label>ID Mahasiswa</label>
        <input type="text" name="id_mahasiswa" required placeholder="Masukkan ID Mahasiswa">

        <label>ID Lowongan</label>
        <input type="text" name="id_lowongan" value="<?= htmlspecialchars($id_lowongan) ?>" readonly>

        <label>Tanggal Daftar</label>
        <input type="date" name="tanggal_daftar" value="<?= date('Y-m-d') ?>" required>

        <button type="submit">Daftar PKL</button>
    </form>
    <?php endif; ?>
</div>
</body>
</html>