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

$query_pkl = "SELECT m.nama_mahasiswa, m.nim, p.status, lp.program 
              FROM pendaftaran p
              JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
              JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
              WHERE m.id_dosen_pembimbing = '$id_dosen'";
$result_pkl = mysqli_query($koneksi, $query_pkl);
?>
<div class="charts">
    <div class="charts-card">
        <p class="chart-title">Status Pendaftaran PKL</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Program</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result_pkl && mysqli_num_rows($result_pkl) > 0): ?>
                    <?php while($pkl = mysqli_fetch_assoc($result_pkl)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pkl['nim']); ?></td>
                        <td><?php echo htmlspecialchars($pkl['nama_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($pkl['program']); ?></td>
                        <td><?php echo htmlspecialchars($pkl['status']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align:center;">Tidak ada data pendaftaran PKL untuk mahasiswa bimbingan Anda.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>