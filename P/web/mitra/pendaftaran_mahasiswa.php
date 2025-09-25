<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../koneksi.php';

// Pastikan mitra sudah login
if (!isset($_SESSION['id_mitra'])) {
    header("Location: login.php");
    exit;
}

$id_mitra = $_SESSION['id_mitra'];

// Query untuk mengambil data pendaftaran berdasarkan mitra
$query = "SELECT p.id_pendaftaran, m.nama_mahasiswa, lp.program, p.status, p.tanggal_daftar
          FROM pendaftaran p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
          WHERE lp.id_mitra = '$id_mitra'
          ORDER BY p.tanggal_daftar DESC";

$result = mysqli_query($koneksi, $query);
?>

<div class="table-container">
    <div class="table-card">
        <p class="chart-title">Daftar Pendaftar Mahasiswa</p>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Program</th>
                    <th>Tanggal Daftar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                            <td><?= htmlspecialchars($row['program']); ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal_daftar'])); ?></td>
                            <td>
                                    <?php
                                    $status_class = '';
                                    if ($row['status'] == 'disetujui') { // Ganti 'Diterima' menjadi 'disetujui'
                                        $status_class = 'status-diterima';
                                    } elseif ($row['status'] == 'ditolak') { // Ganti 'Ditolak' menjadi 'ditolak'
                                        $status_class = 'status-ditolak';
                                    } else {
                                        $status_class = 'status-pending';
                                    }
                                    ?>
                                <span class="status-badge <?= $status_class ?>">
                                    <?= htmlspecialchars($row['status']); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">Belum ada mahasiswa yang mendaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>