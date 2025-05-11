<?php
session_start();
require_once '../db_hotel.php';  
require_once 'pengguna.php';  

$db = new Koneksi();  
$conn = $db->getKoneksi();  

$pengguna = new Pengguna($conn);  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $pengguna->login($email, $password);
    
    if ($user) {
        $_SESSION['pengguna_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['peran'] = $user['peran'];

        if ($user['peran'] == 'admin') {
            header("Location: ../Admin/dashboard.php");
        } else {
            header("Location: ../View/dashboard.php");
        }
        exit();
    } else {
        echo "Login gagal! Email atau password salah.";
    }
}
?>
