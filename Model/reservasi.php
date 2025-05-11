<?php
require_once '../db_hotel.php';

class Reservasi {
    private $db;
    private $table = 'reservasi';

    public function __construct() {
        $koneksi = new Koneksi();
        $this->db = $koneksi->getKoneksi();
    }

    public function buatReservasi($pengguna_id, $kamar_id, $check_in, $check_out, $status) {
        $query = "INSERT INTO $this->table (pengguna_id, kamar_id, check_in, check_out, status) 
            VALUES (:pengguna_id, :kamar_id, :check_in, :check_out, :status)";
        $proses = $this->db->prepare($query);
        
        $proses->bindParam(':pengguna_id', $pengguna_id);
        $proses->bindParam(':kamar_id', $kamar_id);
        $proses->bindParam(':check_in', $check_in);
        $proses->bindParam(':check_out', $check_out);
        $proses->bindParam(':status', $status);
        
        if ($proses->execute()) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getAllReservasi() {
        $query = "SELECT * FROM $this->table";
        $proses = $this->db->prepare($query);
        $proses->execute();
        return $proses->fetchAll(PDO::FETCH_ASSOC);
    }

    // public function updateStatus($id, $status) {
    // $query = "UPDATE $this->table SET status = :status WHERE id = :id";
    // $proses = $this->db->prepare($query);
    // return $proses->execute(['status' => $status, 'id' => $id]);
    // }

    public function updateStatus($reservasi_id, $status)
    {
        $query = "UPDATE $this->table SET status = :status WHERE id = :reservasi_id";
        $proses = $this->db->prepare($query);
        $proses->bindParam(':status', $status);
        $proses->bindParam(':reservasi_id', $reservasi_id);

        // Update status reservasi
        if ($proses->execute()) {
            return true;
        }
        return false;
    }

}
