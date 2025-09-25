<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require '../koneksi.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_mitra'])) {
    echo json_encode(['success' => false, 'message' => 'Session tidak valid']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id_pendaftaran'])) {
    $id_pendaftaran = intval($_POST['id_pendaftaran']);
    $action = $_POST['action'];

    $status_update = '';
    if ($action === 'approve') {
        $status_update = 'Disetujui';   // 👈 pastikan sama persis dengan DB
    } elseif ($action === 'reject') {
        $status_update = 'Ditolak';
    }

    if ($status_update) {
        $stmt = $koneksi->prepare("UPDATE pendaftaran SET status = ? WHERE id_pendaftaran = ?");
        $stmt->bind_param("si", $status_update, $id_pendaftaran);

        if ($stmt->execute()) {
            // Ambil statistik terbaru
            $id_mitra = $_SESSION['id_mitra'];
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

            // balikin JSON untuk update UI
            echo json_encode([
                'success' => true,
                'new_status' => $status_update,
                'new_class' => ($status_update === 'Disetujui' ? 'status-disetujui' : 'status-ditolak'),
                'stats' => $stats
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Action tidak valid']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Request tidak valid']);
}

$koneksi->close();
