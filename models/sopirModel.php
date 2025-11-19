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
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create sopir baru
    public function createSopir($data) {
        $query = "INSERT INTO " . $this->table_name . " (sopir_id, nama_sopir, no_telepon, tarif_sopir_per_hari, status) VALUES (:sopir_id, :nama_sopir, :no_telepon, :tarif_sopir_per_hari, :status)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":sopir_id", $data['sopir_id']);
        $stmt->bindParam(":nama_sopir", $data['nama_sopir']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":tarif_sopir_per_hari", $data['tarif_sopir_per_hari']);
        $stmt->bindParam(":status", $data['status']);
        
        return $stmt->execute();
    }

    // METHOD 4: Delete sopir berdasarkan ID
    public function deleteSopir($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE sopir_id = :sopir_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":sopir_id", $id);
        return $stmt->execute();
    }
}
?>