<?php
/**
 * FILE: models/tipeKendaraanModel.php
 * FUNGSI: Model untuk tabel tipe_kendaraan
 */
class tipeKendaraanModel {
    private $conn;
    private $table = 'Tipe_Kendaraan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

     // METHOD 1: Read semua tipe kendaraan
    public function getAllTipeKendaraan() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create tipe kendaraan baru
    public function createTipeKendaraan($data) {
        $query = "INSERT INTO " . $this->table . " (tipe_id, nama_tipe, deskripsi) VALUES (:tipe_id, :nama_tipe, :deskripsi)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":tipe_id", $data['tipe_id']);
        $stmt->bindParam(":nama_tipe", $data['nama_tipe']);
        $stmt->bindParam(":deskripsi", $data['deskripsi']);
        
        return $stmt->execute();
    }

    // METHOD 4: Delete tipe berdasarkan ID
    public function deleteTipeKendaraan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE tipe_id = :tipe_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipe_id", $id);
        return $stmt->execute();
    }
}
?>