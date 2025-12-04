<?php
/**
 * FILE: models/rentalModel.php
 * FUNGSI: Model untuk tabel rental
 */
class rentalModel {
    private $conn;
    private $table = 'rental';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllRental() {
        $query = "SELECT r.*, 
                            p.nama_pelanggan, 
                            k.merk, k.model, k.plat_nomor,
                            s.nama_sopir 
                    FROM " . $this->table . " r
                    JOIN Pelanggan p ON r.pelanggan_id = p.pelanggan_id
                    JOIN Kendaraan k ON r.kendaraan_id = k.kendaraan_id
                    LEFT JOIN Sopir s ON r.sopir_id = s.sopir_id
                    ORDER BY r.rental_id DESC";
                    
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
    }

    public function getRentalNonActive() {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE status_rental = 'Selesai' 
                  ORDER BY rental_id DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function insertRental($data) {
        try {
            $query = "INSERT INTO " . $this->table . " (pelanggan_id, kendaraan_id, sopir_id, tanggal_mulai, tanggal_selesai_rencana, total_biaya_rencana, status_rental) 
            VALUES (:pelanggan_id, :kendaraan_id, :sopir_id, :tanggal_mulai, :tanggal_selesai_rencana, :total_biaya_rencana, :status_rental)";

            $stmt = $this->conn->prepare($query);
            $pelanggan_id = htmlspecialchars(strip_tags($data['pelanggan_id']));
            $kendaraan_id = htmlspecialchars(strip_tags($data['kendaraan_id']));
            $sopir_id     = !empty($data['sopir_id']) ? htmlspecialchars(strip_tags($data['sopir_id'])) : NULL;

            $stmt->bindParam(":pelanggan_id", $pelanggan_id);
            $stmt->bindParam(":kendaraan_id", $kendaraan_id);
            $stmt->bindParam(":sopir_id", $sopir_id);
            $stmt->bindParam(":tanggal_mulai", $data['tanggal_mulai']);
            $stmt->bindParam(":tanggal_selesai_rencana", $data['tanggal_selesai_rencana']);
            $stmt->bindParam(":total_biaya_rencana", $data['total_biaya_rencana']);
            $stmt->bindParam(":status_rental", $data['status_rental']);
        
            if($stmt->execute()) {
                    return true;
                }
            return false;
        } catch (PDOException $e) {
            if (strpos($e->getMessage(), 'tidak memiliki SIM') !== false) {
                // Kita lempar ulang errornya dengan pesan yang bersih untuk Controller/Frontend
                throw new Exception("GAGAL BOOKING: Pelanggan ini tidak memiliki SIM, tidak bisa menyewa Lepas Kunci.");
            } else {
                // Jika error lain (misal koneksi putus)
                throw new Exception("Database Error: " . $e->getMessage());
            }
        }
    }

    public function getRentalById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $id);
        $stmt->execute();
        return $stmt;
    }

    public function updateRental($id, $data) {
        try {
            $query = "UPDATE " . $this->table . " SET pelanggan_id = :pelanggan_id, kendaraan_id = :kendaraan_id, sopir_id = :sopir_id, tanggal_mulai = :tanggal_mulai, tanggal_selesai_rencana = :tanggal_selesai_rencana, total_biaya_rencana = :total_biaya_rencana, status_rental = :status_rental 
            WHERE rental_id = :rental_id";

            $stmt = $this->conn->prepare($query);
            $sopir_id = !empty($data['sopir_id']) ? $data['sopir_id'] : NULL;

            $stmt->bindParam(":pelanggan_id", $data['pelanggan_id']);
            $stmt->bindParam(":kendaraan_id", $data['kendaraan_id']);
            $stmt->bindParam(":sopir_id", $sopir_id);
            $stmt->bindParam(":tanggal_mulai", $data['tanggal_mulai']);
            $stmt->bindParam(":tanggal_selesai_rencana", $data['tanggal_selesai_rencana']);
            $stmt->bindParam(":total_biaya_rencana", $data['total_biaya_rencana']);
            $stmt->bindParam(":status_rental", $data['status_rental']);
            $stmt->bindParam(":rental_id", $id);
        
            if($stmt->execute()) {
                return true;
            }
            return false;
        } catch (PDOException $e) {
          if (strpos($e->getMessage(), 'tidak memiliki SIM') !== false) {
                // Kita lempar ulang errornya dengan pesan yang bersih untuk Controller/Frontend
                throw new Exception("GAGAL BOOKING: Pelanggan ini tidak memiliki SIM, tidak bisa menyewa Lepas Kunci.");
            } else {
                // Jika error lain (misal koneksi putus)
                throw new Exception("Database Error: " . $e->getMessage());
            }
        }
    }

    public function deleteRental($id) {
        $query = "DELETE FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $id);
        return $stmt->execute();
    }
}
?>