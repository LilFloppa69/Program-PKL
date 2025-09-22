<?php
if (!isset($koneksi) || !isset($id_dosen)) {
    session_start();
    require '../koneksi.php';
    if (!isset($_SESSION['id_dosen'])) {
        header("Location: login.php");
        exit();
    }
    $id_dosen = $_SESSION['id_dosen'];
}

$query_mahasiswa = "SELECT nama_mahasiswa, nim FROM mahasiswa WHERE id_dosen_pembimbing = $id_dosen";
$result_mahasiswa = mysqli_query($koneksi, $query_mahasiswa);
?>
<div class="charts">
    <div class="charts-card">
        <p class="chart-title">Daftar Mahasiswa</p>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                </tr>
            </thead>
            <tbody>
                <?php while($mhs = mysqli_fetch_assoc($result_mahasiswa)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($mhs['nim']); ?></td>
                    <td><?php echo htmlspecialchars($mhs['nama_mahasiswa']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>