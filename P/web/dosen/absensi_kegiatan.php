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

$query_absensi = "SELECT m.nama_mahasiswa, a.tanggal, a.status_kehadiran
                  FROM absensi a
                  JOIN mahasiswa m ON a.id_mahasiswa = m.id_mahasiswa
                  WHERE m.id_dosen_pembimbing = $id_dosen";
$result_absensi = mysqli_query($koneksi, $query_absensi);

$query_kegiatan = "SELECT m.nama_mahasiswa, k.tanggal, k.deskripsi_kegiatan
                   FROM kegiatan k
                   JOIN mahasiswa m ON k.id_mahasiswa = m.id_mahasiswa
                   WHERE m.id_dosen_pembimbing = $id_dosen";
$result_kegiatan = mysqli_query($koneksi, $query_kegiatan);
?>
<div class="charts">
    <div class="charts-card">
        <p class="chart-title">Absensi Mahasiswa</p>
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Kehadiran</th>
                </tr>
            </thead>
            <tbody>
                <?php while($absensi = mysqli_fetch_assoc($result_absensi)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($absensi['nama_mahasiswa']); ?></td>
                    <td><?php echo htmlspecialchars($absensi['tanggal']); ?></td>
                    <td><?php echo htmlspecialchars($absensi['status_kehadiran']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <div class="charts-card">
        <p class="chart-title">Kegiatan Mahasiswa</p>
        <table>
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($kegiatan = mysqli_fetch_assoc($result_kegiatan)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($kegiatan['nama_mahasiswa']); ?></td>
                    <td><?php echo htmlspecialchars($kegiatan['tanggal']); ?></td>
                    <td><?php echo htmlspecialchars($kegiatan['deskripsi_kegiatan']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>