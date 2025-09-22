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

$query_pkl = "SELECT m.nama_mahasiswa, m.nim, p.status
              FROM pendaftaran_pkl p
              JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
              WHERE m.id_dosen_pembimbing = $id_dosen";
$result_pkl = mysqli_query($koneksi, $query_pkl);
?>
<div class="charts">
    <div class="charts-card">
        <p class="chart-title">Status Pendaftaran PKL</p>
        <table>
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php while($pkl = mysqli_fetch_assoc($result_pkl)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($pkl['nim']); ?></td>
                    <td><?php echo htmlspecialchars($pkl['nama_mahasiswa']); ?></td>
                    <td><?php echo htmlspecialchars($pkl['status']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>