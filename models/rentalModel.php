<?php
/**
 * FILE: models/rentalModel.php
 * FUNGSI: Model untuk tabel rental
 */
class rentalModel {
    private $conn;
    private $table = 'Rental';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllRental() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function createRental($data) {
        $query = "INSERT INTO " . $this->table . " (pelanggan_id, kendaraan_id, sopir_id, tanggal_mulai, tanggal_selesai_rencana, total_biaya_rencana, status_rental) VALUES (:rental_id, :pelanggan_id, :kendaraan_id, :sopir_id, :tanggal_mulai, :tanggal_selesai_rencana, :total_biaya_rencana, :status_rental)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pelanggan_id", $data['pelanggan_id']);
        $stmt->bindParam(":kendaraan_id", $data['kendaraan_id']);
        $stmt->bindParam(":sopir_id", $data['sopir_id']);
        $stmt->bindParam(":tanggal_mulai", $data['tanggal_mulai']);
        $stmt->bindParam(":tanggal_selesai_rencana", $data['tanggal_selesai_rencana']);
        $stmt->bindParam(":total_biaya_rencana", $data['total_biaya_rencana']);
        $stmt->bindParam(":status_rental", $data['status_rental']);
    
        return $stmt->execute();
    }

    public function getRentalById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $id);
        $stmt->execute();
        return $stmt;
    }

    public function updateRental($id, $data) {
        $query = "UPDATE " . $this->table . " SET pelanggan_id = :pelanggan_id, kendaraan_id = :kendaraan_id, sopir_id = :sopir_id, tanggal_mulai = :tanggal_mulai, tanggal_selesai_rencana = :tanggal_selesai_rencana, total_biaya_rencana = :total_biaya_rencana, status_rental = :status_rental WHERE rental_id = :rental_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":pelanggan_id", $data['pelanggan_id']);
        $stmt->bindParam(":kendaraan_id", $data['kendaraan_id']);
        $stmt->bindParam(":sopir_id", $data['sopir_id']);
        $stmt->bindParam(":tanggal_mulai", $data['tanggal_mulai']);
        $stmt->bindParam(":tanggal_selesai_rencana", $data['tanggal_selesai_rencana']);
        $stmt->bindParam(":total_biaya_rencana", $data['total_biaya_rencana']);
        $stmt->bindParam(":status_rental", $data['status_rental']);
        $stmt->bindParam(":rental_id", $id);
    
        return $stmt->execute();
    }

    public function deleteRental($id) {
        $query = "DELETE FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $id);
        return $stmt->execute();
    }
}
?>