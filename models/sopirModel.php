<?php
/**
 * FILE: models/sopirModel.php
 * FUNGSI: Model untuk tabel sopir
 */
class sopirModel {
    private $conn;
    private $table = 'Sopir';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

     // METHOD 1: Read semua sopir
    public function getAllSopir() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY sopir_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create sopir baru
    public function createSopir($data) {
        $query = "INSERT INTO " . $this->table . " 
                (sopir_id, nama_sopir, no_telepon, tarif_sopir_per_hari, status, catatan) 
                VALUES (:sopir_id, :nama_sopir, :no_telepon, :tarif_sopir_per_hari, :status, :catatan)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":sopir_id", $data['sopir_id']);
        $stmt->bindParam(":nama_sopir", $data['nama_sopir']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":tarif_sopir_per_hari", $data['tarif_sopir_per_hari']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":catatan", $data['catatan']);
        
        return $stmt->execute();
    }

    // METHOD 3: Get sopir by ID
    public function getSopirById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE sopir_id = :sopir_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sopir_id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // METHOD 4: Update sopir
    public function updateSopir($id, $data) {
        $query = "UPDATE " . $this->table . " 
                SET nama_sopir = :nama_sopir, 
                    no_telepon = :no_telepon, 
                    tarif_sopir_per_hari = :tarif_sopir_per_hari, 
                    status = :status,
                    catatan = :catatan
                WHERE sopir_id = :sopir_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":nama_sopir", $data['nama_sopir']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":tarif_sopir_per_hari", $data['tarif_sopir_per_hari']);
        $stmt->bindParam(":status", $data['status']);
        $stmt->bindParam(":catatan", $data['catatan']);
        $stmt->bindParam(":sopir_id", $id);
        
        return $stmt->execute();
    }
    
    // METHOD 5: Delete sopir
    public function deleteSopir($id) {
        $query = "DELETE FROM " . $this->table . " WHERE sopir_id = :sopir_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sopir_id", $id);
        return $stmt->execute();
    }

    // METHOD 6: Cek apakah no_telepon sudah ada (untuk validasi unik)
    public function isPhoneExists($no_telepon, $exclude_id = null) {
        if ($exclude_id) {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                    WHERE no_telepon = :no_telepon AND sopir_id != :sopir_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":no_telepon", $no_telepon);
            $stmt->bindParam(":sopir_id", $exclude_id);
        } else {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                    WHERE no_telepon = :no_telepon";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":no_telepon", $no_telepon);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
}
?>