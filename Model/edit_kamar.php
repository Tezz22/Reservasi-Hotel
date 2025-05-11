<?php
require_once '../db_hotel.php';
require_once 'kamar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nomor_kamar = $_POST['nomor_kamar'];
    $tipe = $_POST['tipe'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $status = $_POST['status'];

    $gambar = $_FILES['gambar']['name'];
    if ($_FILES['gambar']['error'] === 0) {
        $gambar = uniqid() . '_' . basename($_FILES['gambar']['name']);
        $targetDir = '../../Public/uploads/';
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $targetDir . $gambar);
    } else {
        $gambar = $_POST['gambar_lama'];
    }

    $kamarEdit = new Kamar();
    $result = $kamarEdit->updateKamar($id, $nomor_kamar, $tipe, $deskripsi, $harga, $status, $gambar);

    if ($result) {
        header("Location: ../Admin/dashboard.php");
        exit();
    } else {
        echo "Gagal mengupdate kamar!";
    }
}
?>