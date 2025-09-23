<?php
require '../koneksi.php';

$id_mitra = $_SESSION['id_mitra'];

$query = "SELECT p.id_pendaftaran, m.nama_mahasiswa, l.judul, p.status
          FROM pendaftaran p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN lowongan l ON p.id_lowongan = l.id_lowongan
          WHERE l.id_mitra = '$id_mitra'";
$result = mysqli_query($koneksi, $query);

if (isset($_GET['approve'])) {
    $id_pendaftaran = $_GET['approve'];
    mysqli_query($koneksi, "UPDATE pendaftaran SET status='Disetujui' WHERE id_pendaftaran='$id_pendaftaran'");
    header("Location: persetujuan.php");
    exit;
}

if (isset($_GET['reject'])) {
    $id_pendaftaran = $_GET['reject'];
    mysqli_query($koneksi, "UPDATE pendaftaran SET status='Ditolak' WHERE id_pendaftaran='$id_pendaftaran'");
    header("Location: persetujuan.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Persetujuan Mitra</title>
</head>
<body>
<h2>Daftar Pendaftaran Mahasiswa</h2>
<table border="1" cellpadding="10">
    <tr>
        <th>Nama Mahasiswa</th>
        <th>Lowongan</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <tr>
        <td><?php echo $row['nama_mahasiswa']; ?></td>
        <td><?php echo $row['judul']; ?></td>
        <td><?php echo $row['status']; ?></td>
        <td>
            <?php if ($row['status'] == 'Menunggu') { ?>
                <a href="?approve=<?php echo $row['id_pendaftaran']; ?>">Setujui</a> | 
                <a href="?reject=<?php echo $row['id_pendaftaran']; ?>">Tolak</a>
            <?php } else { ?>
                <?php echo $row['status']; ?>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
</body>
</html>
