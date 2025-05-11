<?php
require_once 'kamar.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $kamarHapus = new Kamar();
    $hasilHapus = $kamarHapus->hapusKamar($id);

    if ($hasilHapus) {
        header('Location: /Admin/dashboard.php');
        exit();
    } else {
        echo "Gagal menghapus kamar.";
    }
} else {
    echo "ID kamar tidak ditemukan.";
}
?>
