<?php
require_once '../db_hotel.php';
require_once 'pengguna.php';

$db = new Koneksi();
$conn = $db->getKoneksi();
$pengguna = new Pengguna($conn);

$pengguna->logout();

header("Location: ../index.php");
exit();
