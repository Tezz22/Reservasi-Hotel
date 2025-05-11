<?php
class Pengguna {
    private $db;

    public function __construct($koneksi) {
        $this->db = $koneksi;
    }

    public function login($email, $password) {
        $query = "SELECT * FROM pengguna WHERE email = :email";
        $proses = $this->db->prepare($query);
        $proses->bindParam(":email", $email, PDO::PARAM_STR);
        $proses->execute();

        if ($proses->rowCount() > 0) {
            $user = $proses->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false; 
        }
    }

    public function daftar($nama, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $peran = 'tamu';

        $query = "INSERT INTO pengguna (nama, email, password, peran) VALUES (:nama, :email, :password, :peran)";
        $proses = $this->db->prepare($query);
        $proses->bindParam(":nama", $nama, PDO::PARAM_STR);
        $proses->bindParam(":email", $email, PDO::PARAM_STR);
        $proses->bindParam(":password", $hash, PDO::PARAM_STR);
        $proses->bindParam(":peran", $peran, PDO::PARAM_STR);
        
        return $proses->execute();
    }

    public function logout() {
        session_start();
        session_unset(); 
        session_destroy(); 
    }
    
}
?>
