<!-- <?php
require_once '../db_hotel.php';
require_once 'reservasi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pengguna_id = $_POST['pengguna_id'];
    $kamar_id = $_POST['kamar_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $status = 'menunggu';

    $reservasi = new Reservasi();
    $reservasi->buatReservasi($pengguna_id, $kamar_id, $check_in, $check_out, $status);

    header("Location: ../View/dashboard.php");
    exit();
}

?> -->
<?php
require_once '../db_hotel.php'; // Koneksi database
require_once 'reservasi.php'; // Model Reservasi
require_once 'laporan.php'; // Model Laporan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $pengguna_id = $_POST['pengguna_id'];
    $kamar_id = $_POST['kamar_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $status = 'menunggu';

    // Inisialisasi model
    $reservasi = new Reservasi();
    $laporan = new Laporan();

    try {
        // Insert data ke tabel reservasi dan dapatkan ID reservasi
        $reservasi_id = $reservasi->buatReservasi($pengguna_id, $kamar_id, $check_in, $check_out, $status);

        // Insert data ke tabel laporan menggunakan ID reservasi yang baru
        $laporan->buatLaporan($pengguna_id, $reservasi_id);

        // Redirect atau beri pesan sukses
        header("Location: ../View/dashboard.php");
        exit();

    } catch (Exception $e) {
        // Tangani error
        echo "Terjadi kesalahan: " . $e->getMessage();
    }
}
?>
