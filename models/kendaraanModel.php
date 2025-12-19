<?php
/**
 * FILE: models/kendaraanModel.php
 * FUNGSI: Model untuk tabel Kendaraan
 */
class KendaraanModel {
    private $conn;
    private $table = 'Kendaraan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // METHOD 1: Read semua kendaraan
    public function getAllKendaraan() {
        $query = "SELECT k.*, t.nama_tipe 
                  FROM " . $this->table . " k
                  LEFT JOIN Tipe_Kendaraan t ON k.tipe_id = t.tipe_id
                  ORDER BY k.kendaraan_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllKendaraan2() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY kendaraan_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAllKendaraan3() {
        try {
            $stmt = $this->conn->prepare("
                SELECT k.*, t.nama_tipe
                FROM Kendaraan k
                LEFT JOIN Tipe_Kendaraan t ON k.tipe_id = t.tipe_id
                ORDER BY k.kendaraan_id ASC"
            );
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // METHOD 2: Create kendaraan baru
    public function createKendaraan($data) {
        $query = "INSERT INTO " . $this->table . " 
                (kendaraan_id, tipe_id, plat_nomor, merk, model, tahun, harga_sewa_per_hari, status_ketersediaan) 
                VALUES (:kendaraan_id, :tipe_id, :plat_nomor, :merk, :model, :tahun, :harga_sewa_per_hari, :status_ketersediaan)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":kendaraan_id", $data['kendaraan_id']);
        $stmt->bindParam(":tipe_id", $data['tipe_id']);
        $stmt->bindParam(":plat_nomor", $data['plat_nomor']);
        $stmt->bindParam(":merk", $data['merk']);
        $stmt->bindParam(":model", $data['model']);
        $stmt->bindParam(":tahun", $data['tahun']);
        $stmt->bindParam(":harga_sewa_per_hari", $data['harga_sewa_per_hari']);
        $stmt->bindParam(":status_ketersediaan", $data['status_ketersediaan']);
        
        return $stmt->execute();
    }

    // METHOD 3: Get kendaraan by ID
    public function getKendaraanById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE kendaraan_id = :kendaraan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kendaraan_id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    // METHOD 4: Update kendaraan
    public function updateKendaraan($id, $data) {
        $query = "UPDATE " . $this->table . " 
                SET tipe_id = :tipe_id, 
                    plat_nomor = :plat_nomor, 
                    merk = :merk, 
                    model = :model, 
                    tahun = :tahun,
                    harga_sewa_per_hari = :harga_sewa_per_hari,
                    status_ketersediaan = :status_ketersediaan
                WHERE kendaraan_id = :kendaraan_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":tipe_id", $data['tipe_id']);
        $stmt->bindParam(":plat_nomor", $data['plat_nomor']);
        $stmt->bindParam(":merk", $data['merk']);
        $stmt->bindParam(":model", $data['model']);
        $stmt->bindParam(":tahun", $data['tahun']);
        $stmt->bindParam(":harga_sewa_per_hari", $data['harga_sewa_per_hari']);
        $stmt->bindParam(":status_ketersediaan", $data['status_ketersediaan']);
        $stmt->bindParam(":kendaraan_id", $id);
        
        return $stmt->execute();
    }
    
    // METHOD 5: Delete kendaraan
    public function deleteKendaraan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE kendaraan_id = :kendaraan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kendaraan_id", $id);
        return $stmt->execute();
    }

    // METHOD 6: Cek apakah plat_nomor sudah ada (untuk validasi unik)
    public function isPlatExists($plat_nomor, $exclude_id = null) {
        if ($exclude_id) {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                    WHERE plat_nomor = :plat_nomor AND kendaraan_id != :kendaraan_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":plat_nomor", $plat_nomor);
            $stmt->bindParam(":kendaraan_id", $exclude_id);
        } else {
            $query = "SELECT COUNT(*) as count FROM " . $this->table . " 
                    WHERE plat_nomor = :plat_nomor";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":plat_nomor", $plat_nomor);
        }
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // METHOD 7: Get semua tipe kendaraan untuk dropdown
    public function getAllTipeKendaraan() {
        $query = "SELECT * FROM Tipe_Kendaraan ORDER BY nama_tipe";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
}
?>