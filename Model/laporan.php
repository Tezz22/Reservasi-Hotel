<?php
class Laporan
{
    private $db;

    public function __construct() {
        $koneksi = new Koneksi();
        $this->db = $koneksi->getKoneksi();
    }

    public function getAllLaporan() {
        $query = "SELECT * FROM laporan";
        $proses = $this->db->prepare($query);
        $proses->execute();
        return $proses->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buatLaporan($user_id, $reservasi_id)
    {
        $query = "INSERT INTO laporan (dibuat_oleh, reservasi_id, parameter) 
            VALUES (:dibuat_oleh, :reservasi_id, :parameter)";
        $proses = $this->db->prepare($query);
        $proses->bindParam(':dibuat_oleh', $user_id);
        $proses->bindParam(':reservasi_id', $reservasi_id);
        $proses->bindParam(':parameter', $parameter);
        
        $parameter = 'Reservasi oleh user ' . $user_id;
        
        return $proses->execute();
    }

    public function updateLaporan($reservasi_id, $status)
    {
        $query = "UPDATE laporan SET parameter = :parameter WHERE reservasi_id = :reservasi_id";
        $proses = $this->db->prepare($query);

        // Menentukan parameter laporan berdasarkan status baru
        $parameter = 'Reservasi dengan status ' . $status;

        $proses->bindParam(':parameter', $parameter);
        $proses->bindParam(':reservasi_id', $reservasi_id);
        
        return $proses->execute();
    }
}