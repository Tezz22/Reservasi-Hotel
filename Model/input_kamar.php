<?php
require_once '../db_hotel.php';
require_once 'kamar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomor_kamar = $_POST['nomor_kamar'];
    $tipe = $_POST['tipe'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    
    $status = $_POST['status'] ?? 'tersedia';
    $validStatus = ['tersedia', 'dipesan', 'perbaikan'];

    if (!in_array($status, $validStatus)) {
        $status = 'tersedia';
    }

    $gambar = '';
    if ($_FILES['gambar']['error'] === 0) {
        $gambar = uniqid() . '_' . basename($_FILES['gambar']['name']);
        $targetDir = '../Public/uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $gambar);
    }

    $kamar = new Kamar();
    $kamar->inputKamar($nomor_kamar, $tipe, $deskripsi, $harga, $status, $gambar);

    header("Location: ../Admin/dashboard.php");
    exit();
}
?>
