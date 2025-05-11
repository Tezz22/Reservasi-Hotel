<?php
require_once '../db_hotel.php';
require_once 'reservasi.php';
require_once 'laporan.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['reservasi_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if ($id && in_array($status, ['menunggu', 'terkonfirmasi', 'dibatalkan'])) {
        $reservasiModel = new Reservasi($db);

        if ($reservasiModel->updateStatus($id, $status)) {
            $laporanModel = new Laporan($db);
            
            $laporanModel->updateLaporan($id, $status);
        }
    }
}

header('Location: ../Admin/reservasi_admin.php');
exit;
?>