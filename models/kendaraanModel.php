<?php
/**
 * FILE: models/kendaraanModel.php
 * FUNGSI: Model untuk tabel kendaraan
 */
class kendaraanModel {
    private $conn;
    private $table = 'Kendaraan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // METHOD 1: Read semua kendaraan
    public function getAllVehicles() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create kendaraan baru
    public function createVehicle($data) {
        $query = "INSERT INTO " . $this->table_name . " (kendaraan_id, tipe_id, plat_nomor, merk, model, tahun, harga_sewa_per_hari, status_ketersediaan) VALUES (:kendaraan_id, :tipe_id, :plat_nomor, :merk, :model, :tahun, :harga_sewa_per_hari, :status_ketersediaan)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
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

    // METHOD 4: Delete kendaraan berdasarkan ID
    public function deleteVehicle($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE kendaraan_id = :kendaraan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kendaraan_id", $id);
        return $stmt->execute();
    }

}
?>