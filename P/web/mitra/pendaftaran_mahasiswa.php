<?php
session_start();
require '../koneksi.php';

if (isset($_GET['id_lowongan']) && isset($_SESSION['id_mahasiswa'])) {
    $id_lowongan = mysqli_real_escape_string($koneksi, $_GET['id_lowongan']);
    $id_mahasiswa = mysqli_real_escape_string($koneksi, $_SESSION['id_mahasiswa']);

    // Cek apakah sudah daftar sebelumnya
    $cek = mysqli_query($koneksi, "
        SELECT * FROM pendaftaran_pkl 
        WHERE id_lowongan='$id_lowongan' 
        AND id_mahasiswa='$id_mahasiswa'
    ");

    if (mysqli_num_rows($cek) > 0) {
        $error = "Anda sudah mendaftar pada lowongan ini.";
    } else {
        $query = "
            INSERT INTO pendaftaran_pkl (id_mahasiswa, id_lowongan, status, created_at) 
            VALUES ('$id_mahasiswa', '$id_lowongan', 'Menunggu', NOW())
        ";
        if (mysqli_query($koneksi, $query)) {
            $success = "Pendaftaran berhasil, menunggu persetujuan mitra.";
        } else {
            $error = "Gagal mendaftar: " . mysqli_error($koneksi);
        }
    }
} else {
    $error = "Akses tidak valid.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Mahasiswa</title>
</head>
<body>
<h2>Pendaftaran Mahasiswa</h2>
<?php if (isset($success)) echo "<p style='color:green'>$success</p>"; ?>
<?php if (isset($error)) echo "<p style='color:red'>$error</p>"; ?>
<a href="daftar_lowongan.php">Kembali ke daftar lowongan</a>
</body>
</html>
