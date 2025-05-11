<?php
class Koneksi {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "db_hotel";
    private $conn;

    public function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";
            $this->conn = new PDO($dsn, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Koneksi Gagal: " . $e->getMessage());
        }
    }

    // Fungsi untuk mengambil koneksi PDO-nya
    public function getKoneksi() {
        return $this->conn;
    }
}
?>

