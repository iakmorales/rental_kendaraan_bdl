<?php
/**
 * FILE: models/rentalModel.php
 * FUNGSI: Model untuk tabel rental
 */
class rentalModel {
    private $conn;
    private $table = 'Rental';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

     // METHOD 1: Read semua rental
    public function getAllRental() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create rental baru
    public function createRental($data) {
        $query = "INSERT INTO " . $this->table . " (rental_id, pelanggan_id, kendaraan_id, sopir_id, tanggal_mulai, tanggal_selesai_rencana, total_biaya_rencana, status_rental) VALUES (:rental_id, :pelanggan_id, :kendaraan_id, :sopir_id, :tanggal_mulai, :tanggal_selesai_rencana, :total_biaya_rencana, :status_rental)";

        $stmt = $this->conn->prepare($query);

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":rental_id", $data['rental_id']);
        $stmt->bindParam(":pelanggan_id", $data['pelanggan_id']);
        $stmt->bindParam(":kendaraan_id", $data['kendaraan_id']);
        $stmt->bindParam(":sopir_id", $data['sopir_id']);
        $stmt->bindParam(":tanggal_mulai", $data['tanggal_mulai']);
        $stmt->bindParam(":tanggal_selesai_rencana", $data['tanggal_selesai_rencana']);
        $stmt->bindParam(":total_biaya_rencana", $data['total_biaya_rencana']);
        $stmt->bindParam(":status_rental", $data['status_rental']);
    
        return $stmt->execute();
    }

    // METHOD 4: Delete rental berdasarkan ID
    public function deleteRental($id) {
        $query = "DELETE FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $id);
        return $stmt->execute();
    }
}
?>