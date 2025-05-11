<?php
require_once __DIR__ . '/../db_hotel.php'; 

class Kamar {
    private $db;
    private $table = 'kamar';

    public function __construct() {
        $koneksi = new Koneksi();
        $this->db = $koneksi->getKoneksi();
    }

    public function getAllKamar() {
        $query = "SELECT * FROM $this->table";
        $proses = $this->db->prepare($query);
        $proses->execute();
        return $proses->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKamarById($id)
    {
        $proses = $this->db->prepare("SELECT * FROM kamar WHERE id = ?");
        $proses->execute([$id]);
        return $proses->fetch(PDO::FETCH_ASSOC);
    }


    public function inputKamar($nomor_kamar, $tipe, $deskripsi, $harga, $status, $gambar) {
        // Validasi status
        $validStatus = ['tersedia', 'dipesan', 'perbaikan'];
        if (!in_array($status, $validStatus)) {
            $status = 'tersedia';  // Set ke 'tersedia' jika status tidak valid
        }
    
        $query = "INSERT INTO $this->table (nomor_kamar, tipe, deskripsi, harga, status, gambar) 
            VALUES (:nomor_kamar, :tipe, :deskripsi, :harga, :status, :gambar)";
        $proses = $this->db->prepare($query);
        $proses->bindParam(":nomor_kamar", $nomor_kamar);
        $proses->bindParam(":tipe", $tipe);
        $proses->bindParam(":deskripsi", $deskripsi);
        $proses->bindParam(":harga", $harga);
        $proses->bindParam(":status", $status);
        $proses->bindParam(":gambar", $gambar);
        return $proses->execute();
    }    


    public function updateKamar($id, $nomor_kamar, $tipe, $deskripsi, $harga, $status, $gambar) {
        $query = "UPDATE $this->table SET 
                    nomor_kamar = :nomor_kamar, 
                    tipe = :tipe, 
                    deskripsi = :deskripsi, 
                    harga = :harga, 
                    status = :status, 
                    gambar = :gambar 
                WHERE id = :id";
        $proses = $this->db->prepare($query);
        $proses->bindParam(":id", $id);
        $proses->bindParam(":nomor_kamar", $nomor_kamar);
        $proses->bindParam(":tipe", $tipe);
        $proses->bindParam(":deskripsi", $deskripsi);
        $proses->bindParam(":harga", $harga);
        $proses->bindParam(":status", $status);
        $proses->bindParam(":gambar", $gambar);
        return $proses->execute();
    }

    public function hapusKamar($id) {
        $query = "DELETE FROM $this->table WHERE id = :id";
        $proses = $this->db->prepare($query);
        $proses->bindParam(":id", $id);
        return $proses->execute();
    }

    public function cariKamar($keyword) {
        $sql = "SELECT * FROM $this->table WHERE 
                tipe LIKE :keyword OR 
                nomor_kamar LIKE :keyword OR 
                deskripsi LIKE :keyword";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
