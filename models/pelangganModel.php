<?php
/**
 * FILE: models/pelangganModel.php
 * FUNGSI: Model untuk tabel pelanggan
 */
class pelangganModel {
    private $conn;
    private $table = 'Pelanggan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

     // METHOD 1: Read semua pelanggan
    public function getAllPelanggan() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create Pelanggan baru
    public function createPelanggan($data) {
        $query = "INSERT INTO " . $this->table . " (pelanggan_id, nama_pelanggan, no_ktp, no_telepon, email, alamat) VALUES (:pelanggan_id, :nama_pelanggan, :no_ktp, :no_telepon, :email, :alamat)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":pelanggan_id", $data['pelanggan_id']);
        $stmt->bindParam(":nama_pelanggan", $data['nama_pelanggan']);
        $stmt->bindParam(":no_ktp", $data['no_ktp']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":alamat", $data['alamat']);
        

        return $stmt->execute();
    }

    // METHOD 4: Delete pelanggan berdasarkan ID
    public function deletePelanggan($id) {
        $query = "DELETE FROM " . $this->table . " WHERE pelanggan_id = :pelanggan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pelanggan_id", $id);
        return $stmt->execute();
    }

}
?>