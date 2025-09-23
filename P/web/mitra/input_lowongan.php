<?php
require '../koneksi.php';

// Pastikan hanya mitra yang login
if (!isset($_SESSION['id_mitra'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $lokasi = $_POST['lokasi'];
    $id_mitra = $_SESSION['id_mitra'];

    $query = "INSERT INTO lowongan (id_mitra, judul, deskripsi, lokasi) 
              VALUES ('$id_mitra', '$judul', '$deskripsi', '$lokasi')";
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
</head>
<body>
<h2>Input Lowongan</h2>
<form method="POST">
    <label>Judul</label><br>
    <input type="text" name="judul" required><br><br>
    
    <label>Deskripsi</label><br>
    <textarea name="deskripsi" required></textarea><br><br>
    
    <label>Lokasi</label><br>
    <input type="text" name="lokasi" required><br><br>
    
    <button type="submit">Simpan</button>
</form>
<?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>
