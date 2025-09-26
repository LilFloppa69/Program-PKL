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

$query_pkl = "SELECT m.nim, m.nama_mahasiswa, p.status
              FROM mahasiswa m
              LEFT JOIN pendaftaran p ON m.id_mahasiswa = p.id_mahasiswa
              WHERE m.id_dosen_pembimbing = $id_dosen";

$result_pkl = mysqli_query($koneksi, $query_pkl);
?>
<div class="charts">
    <div class="charts-card">
        <p class="chart-title">Status Pendaftaran PKL</p>
        <table border="1" cellspacing="0" cellpadding="8">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result_pkl) > 0): ?>
                    <?php while($pkl = mysqli_fetch_assoc($result_pkl)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($pkl['nim']); ?></td>
                        <td><?php echo htmlspecialchars($pkl['nama_mahasiswa']); ?></td>
                        <td>
                            <?php 
                                echo $pkl['status'] ? htmlspecialchars($pkl['status']) : "Belum mendaftar"; 
                            ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Belum ada mahasiswa bimbingan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
