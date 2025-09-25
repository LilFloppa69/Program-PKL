<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require '../koneksi.php';

// Ambil ID mitra dari session (sesuaikan dengan sistem login Anda)
$id_mitra = $_SESSION['id_mitra'];

// Handle approve/reject actions
if (isset($_GET['approve'])) {
    $id_pendaftaran = intval($_GET['approve']); // amankan input
    $update_query = "UPDATE pendaftaran SET status='Diterima' WHERE id_pendaftaran=$id_pendaftaran";
    if (mysqli_query($koneksi, $update_query)) {
        header("Location: persetujuan.php");
        exit;
    } else {
        echo "Error update: " . mysqli_error($koneksi);
    }
}


if (isset($_GET['reject'])) {
    $id_pendaftaran = intval($_GET['reject']);
    $update_query = "UPDATE pendaftaran SET status='Ditolak' WHERE id_pendaftaran=$id_pendaftaran";
    if (mysqli_query($koneksi, $update_query)) {
        header("Location: persetujuan.php");
        exit;
    } else {
        echo "Error update: " . mysqli_error($koneksi);
    }
}

// Query untuk mengambil data pendaftaran berdasarkan mitra
$query = "SELECT p.id_pendaftaran, p.id_mahasiswa, m.nama_mahasiswa, lp.program, p.status, p.tanggal_daftar
          FROM pendaftaran p
          JOIN mahasiswa m ON p.id_mahasiswa = m.id_mahasiswa
          JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
          WHERE lp.id_mitra = '$id_mitra'
          ORDER BY p.tanggal_daftar DESC";

$result = mysqli_query($koneksi, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Persetujuan Pendaftaran</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  background-color: #e6e8ed;
  color: #666666;
  font-family: "Montserrat", sans-serif;
}

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .main-title h1 {
            color: #333;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .main-title h2 {
            color: #666;
            font-weight: 400;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .custom-table th {
            background: #77a13c;
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        .custom-table td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .custom-table tr:hover {
            background-color: #f8f9fa;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-diterima {
            background-color: #d4edda;
            color: #155724;
        }

        .status-ditolak {
            background-color: #f8d7da;
            color: #721c24;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-approve {
            background-color: #28a745;
            color: white;
        }

        .btn-approve:hover {
            background-color: #218838;
            color: white;
        }

        .btn-reject {
            background-color: #dc3545;
            color: white;
        }

        .btn-reject:hover {
            background-color: #c82333;
            color: white;
        }

        .no-data {
            text-align: center;
            padding: 50px;
            color: #666;
            font-style: italic;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #77a13c;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="main-title">
            <h1>Persetujuan Pendaftaran PKL</h1>
            <h2>Kelola persetujuan mahasiswa yang mendaftar program PKL</h2>
        </div>

        <?php
        // Hitung statistik
        $stats_query = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN p.status = 'Pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN p.status = 'Diterima' THEN 1 ELSE 0 END) as diterima,
            SUM(CASE WHEN p.status = 'Ditolak' THEN 1 ELSE 0 END) as ditolak
        FROM pendaftaran p
        JOIN lowongan_pkl lp ON p.id_lowongan = lp.id_lowongan
        WHERE lp.id_mitra = '$id_mitra'";
        
        $stats_result = mysqli_query($koneksi, $stats_query);
        $stats = mysqli_fetch_assoc($stats_result);
        ?>

        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-number"><?= $stats['total'] ?? 0 ?></div>
                <div class="stat-label">Total Pendaftar</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['pending'] ?? 0 ?></div>
                <div class="stat-label">Menunggu</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['diterima'] ?? 0 ?></div>
                <div class="stat-label">Diterima</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= $stats['ditolak'] ?? 0 ?></div>
                <div class="stat-label">Ditolak</div>
            </div>
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
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id_mahasiswa']); ?></td>
                            <td><?= htmlspecialchars($row['nama_mahasiswa']); ?></td>
                            <td><?= htmlspecialchars($row['program']); ?></td>
                            <td><?= date('d/m/Y', strtotime($row['tanggal_daftar'])); ?></td>
                            <td>
                                <?php
                                $status_class = '';
                                switch($row['status']) {
                                    case 'Pending':
                                        $status_class = 'status-pending';
                                        break;
                                    case 'Diterima':
                                        $status_class = 'status-diterima';
                                        break;
                                    case 'Ditolak':
                                        $status_class = 'status-ditolak';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $status_class ?>"><?= htmlspecialchars($row['status']); ?></span>
                            </td>
                            <td>
                                <?php if (strtolower($row['status']) == 'pending'): ?>
                                    <div class="action-buttons">
                                        <a href="?approve=<?= $row['id_pendaftaran']; ?>" class="btn btn-approve" onclick="return confirm('Yakin ingin menyetujui pendaftaran ini?')">Terima</a>
                                        <a href="?reject=<?= $row['id_pendaftaran']; ?>" class="btn btn-reject" onclick="return confirm('Yakin ingin menolak pendaftaran ini?')">Tolak</a>
                                    </div>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="no-data">Belum ada pendaftaran untuk program PKL Anda</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>