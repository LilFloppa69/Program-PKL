<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../koneksi.php';

// Pastikan user sudah login dan punya id_mitra
if (!isset($_SESSION['id_mitra'])) {
    die("Anda belum login atau session tidak valid.");
}
$id_mitra = $_SESSION['id_mitra'];

// Handle approve/reject via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_pendaftaran'])) {
    $id_pendaftaran = intval($_POST['id_pendaftaran']);
    $status_update = '';

    if ($_POST['action'] === 'approve') {
        $status_update = 'Disetujui';
    } elseif ($_POST['action'] === 'reject') {
        $status_update = 'Ditolak';
    }

    if ($status_update) {
        $stmt = $koneksi->prepare("UPDATE pendaftaran SET status = ? WHERE id_pendaftaran = ?");
        $stmt->bind_param("si", $status_update, $id_pendaftaran);
        if ($stmt->execute()) {
            header("Location: persetujuan.php");
            exit;
        } else {
            echo "Error update: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Ambil data pendaftaran
$stmt = $koneksi->prepare("
    SELECT p.id_pendaftaran, p.id_mahasiswa, m.nama_mahasiswa, lp.program, p.status, p.tanggal_daftar
    FROM pendaftaran p
    JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
    JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
    WHERE lp.id_mitra = ?
    ORDER BY p.tanggal_daftar DESC
");
$stmt->bind_param("i", $id_mitra);
$stmt->execute();
$result = $stmt->get_result();

// Statistik
$stats_stmt = $koneksi->prepare("
    SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN p.status = 'Pending' THEN 1 ELSE 0 END) as pending,
        SUM(CASE WHEN p.status = 'Disetujui' THEN 1 ELSE 0 END) as disetujui,
        SUM(CASE WHEN p.status = 'Ditolak' THEN 1 ELSE 0 END) as ditolak
    FROM pendaftaran p
    JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
    WHERE lp.id_mitra = ?
");
$stats_stmt->bind_param("i", $id_mitra);
$stats_stmt->execute();
$stats = $stats_stmt->get_result()->fetch_assoc();
$stats_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Persetujuan Pendaftaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <style>
        body { font-family: "Montserrat", sans-serif; background:#e6e8ed; color:#666; margin:0; padding:0; }
        .container { max-width:1200px; margin:20px auto; background:white; padding:30px; border-radius:10px; box-shadow:0 0 20px rgba(0,0,0,0.1); }
        .main-title h1 { color:#333; margin-bottom:10px; }
        .main-title h2 { color:#666; margin-bottom:30px; font-weight:400; }
        .stats-cards { display:grid; grid-template-columns:repeat(auto-fit,minmax(150px,1fr)); gap:20px; margin-bottom:30px; }
        .stat-card { background:white; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); text-align:center; }
        .stat-number { font-size:24px; font-weight:700; color:#77a13c; margin-bottom:5px; }
        .stat-label { color:#666; font-size:14px; }
        .custom-table { width:100%; border-collapse:collapse; margin-top:20px; }
        .custom-table th { background:#77a13c; color:white; padding:15px; text-align:left; }
        .custom-table td { padding:15px; border-bottom:1px solid #eee; }
        .custom-table tr:hover { background:#f8f9fa; }
        .status-badge { padding:5px 12px; border-radius:15px; font-size:12px; font-weight:600; text-transform:uppercase; }
        .status-pending { background:#fff3cd; color:#856404; }
        .status-disetujui { background:#d4edda; color:#155724; }
        .status-ditolak { background:#f8d7da; color:#721c24; }
        .btn { padding:8px 16px; border:none; border-radius:5px; cursor:pointer; font-weight:600; font-size:12px; }
        .btn-approve { background:#28a745; color:white; }
        .btn-reject { background:#dc3545; color:white; }
        .action-buttons { display:flex; gap:10px; }
        .no-data { text-align:center; padding:50px; font-style:italic; color:#666; }
    </style>
</head>
<body>
<div class="container">
    <div class="main-title">
        <h1>Persetujuan Pendaftaran PKL</h1>
        <h2>Kelola persetujuan mahasiswa yang mendaftar program PKL</h2>
    </div>

    <div class="stats-cards">
        <div class="stat-card"><div class="stat-number" id="total-pendaftar"><?= $stats['total'] ?></div><div class="stat-label">Total Pendaftar</div></div>
        <div class="stat-card"><div class="stat-number" id="pending"><?= $stats['pending'] ?></div><div class="stat-label">Menunggu</div></div>
        <div class="stat-card"><div class="stat-number" id="diisetujui"><?= $stats['disetujui'] ?></div><div class="stat-label">Disetujui</div></div>
        <div class="stat-card"><div class="stat-number" id="ditolak"><?= $stats['ditolak'] ?></div><div class="stat-label">Ditolak</div></div>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>ID MAHASISWA</th>
                <th>NAMA MAHASISWA</th>
                <th>PROGRAM</th>
                <th>TANGGAL DAFTAR</th>
                <th>STATUS</th>
                <th>AKSI</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): 
                $status_class = match($row['status']){
                    'Pending' => 'status-pending',
                    'Disetujui' => 'status-disetujui',
                    'Ditolak' => 'status-ditolak',
                    default => ''
                };
            ?>
            <tr>
                <td><?= htmlspecialchars($row['id_mahasiswa']); ?></td>
                <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                <td><?= htmlspecialchars($row['program']); ?></td>
                <td><?= date('d/m/Y', strtotime($row['tanggal_daftar'])); ?></td>
                <td><span class="status-badge <?= $status_class ?>"><?= htmlspecialchars($row['status']); ?></span></td>
                <td>
                    <?php if (strtolower($row['status']) === 'pending'): ?>
                        <div class="action-buttons">
    <button class="btn btn-approve action-btn" data-id="<?= $row['id_pendaftaran']; ?>" data-action="approve">Terima</button>
    <button class="btn btn-reject action-btn" data-id="<?= $row['id_pendaftaran']; ?>" data-action="reject">Tolak</button>
</div>

                    <?php else: ?>
                        <span class="status-badge <?= $status_class ?>"><?= htmlspecialchars($row['status']); ?></span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="6" class="no-data">Belum ada pendaftaran untuk program PKL Anda</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<script>
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if(!confirm('Yakin ingin melakukan aksi ini?')) return;

        const id = this.dataset.id;
        const action = this.dataset.action;

        fetch('persetujuan_action.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `id_pendaftaran=${id}&action=${action}`
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                // Update row status
                const row = this.closest('tr');
                const statusCell = row.querySelector('.status-badge');
                statusCell.textContent = data.new_status;
                statusCell.className = 'status-badge ' + data.new_class;

                // Hapus tombol aksi
                row.querySelector('.action-btn').closest('td').innerHTML = statusCell.outerHTML;

                // Update statistik
                document.getElementById('total-pendaftar').textContent = data.stats.total;
                document.getElementById('pending').textContent = data.stats.pending;
                document.getElementById('disetujui').textContent = data.stats.disetujui;
                document.getElementById('ditolak').textContent = data.stats.ditolak;
            } else {
                alert('Gagal update: ' + data.message);
            }
        });
    });
});
</script>

</body>
</html>

<?php
$stmt->close();
$koneksi->close();
?>
