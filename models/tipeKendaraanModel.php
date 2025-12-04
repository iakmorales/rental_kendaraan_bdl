<?php
/**
 * FILE: models/tipeKendaraanModel.php
 * FUNGSI: Model untuk tabel tipe_kendaraan
 */
class tipeKendaraanModel {
    private $conn;
    private $table = 'tipe_kendaraan';

    public function __construct($db) {
        $this->conn = $db;
    }

    // 1. READ ALL
    public function getAllTipeKendaraan() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY tipe_id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // 2. CREATE
    public function createTipeKendaraan($data) {
        $query = "INSERT INTO " . $this->table . " (nama_tipe, deskripsi) VALUES (:nama_tipe, :deskripsi)";

        $stmt = $this->conn->prepare($query);

        // Bersihkan data
        $nama_tipe = htmlspecialchars(strip_tags($data['nama_tipe']));
        $deskripsi = htmlspecialchars(strip_tags($data['deskripsi']));

        $stmt->bindParam(":nama_tipe", $nama_tipe);
        $stmt->bindParam(":deskripsi", $deskripsi);
        
        return $stmt->execute();
    }

    // 3. GET BY ID
    public function getTipeKendaraanById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE tipe_id = :tipe_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipe_id", $id);
        $stmt->execute();
        return $stmt;
    }

    // 4. UPDATE
    public function updateTipeKendaraan($id, $data) {
        $query = "UPDATE " . $this->table . " SET nama_tipe = :nama_tipe, deskripsi = :deskripsi WHERE tipe_id = :tipe_id";

        $stmt = $this->conn->prepare($query);

        $nama_tipe = htmlspecialchars(strip_tags($data['nama_tipe']));
        $deskripsi = htmlspecialchars(strip_tags($data['deskripsi']));

        $stmt->bindParam(":nama_tipe", $nama_tipe);
        $stmt->bindParam(":deskripsi", $deskripsi);
        $stmt->bindParam(":tipe_id", $id);
        
        return $stmt->execute();
    }

    // 5. DELETE
    public function deleteTipeKendaraan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE tipe_id = :tipe_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":tipe_id", $id);
        return $stmt->execute();
    }
}
?>