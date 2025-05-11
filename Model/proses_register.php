<?php
require_once '../db_hotel.php';
require_once 'pengguna.php';

$db = new Koneksi();
$conn = $db->getKoneksi();

$pengguna = new Pengguna($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $hasil = $pengguna->daftar($nama, $email, $password);

    if ($hasil) {
        echo "Registrasi berhasil! Silakan <a href='../index.php'>login</a>.";
    } else {
        echo "Registrasi gagal. Email mungkin sudah digunakan.";
    }
}
?>
