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
        $query = "SELECT * FROM " . $this->table . " ORDER BY pelanggan_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create Pelanggan baru
    public function createPelanggan($data) {
        $query = "INSERT INTO " . $this->table . " (nama_pelanggan, no_ktp, no_telepon, email, alamat, punya_sim) 
        VALUES (:nama_pelanggan, :no_ktp, :no_telepon, :email, :alamat, :punya_sim)";

        $stmt = $this->conn->prepare($query);
        $punya_sim = $data['punya_sim'] ? 'true' : 'false';

        // Bind parameters untuk keamanan (mencegah SQL injection)
        $stmt->bindParam(":nama_pelanggan", $data['nama_pelanggan']);
        $stmt->bindParam(":no_ktp", $data['no_ktp']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":alamat", $data['alamat']);
        $stmt->bindParam(":punya_sim", $punya_sim);
        

        return $stmt->execute();
    }

    public function getPelangganById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE pelanggan_id = :pelanggan_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pelanggan_id", $id);
        $stmt->execute();
        return $stmt;
    }

    public function updatePelanggan($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_pelanggan = :nama_pelanggan, 
                      no_ktp = :no_ktp, 
                      no_telepon = :no_telepon, 
                      email = :email, 
                      alamat = :alamat,
                      punya_sim = :punya_sim
                  WHERE pelanggan_id = :pelanggan_id";

        $stmt = $this->conn->prepare($query);

        $punya_sim = $data['punya_sim'] ? 'true' : 'false';

        $stmt->bindParam(":nama_pelanggan", $data['nama_pelanggan']);
        $stmt->bindParam(":no_ktp", $data['no_ktp']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":alamat", $data['alamat']);
        $stmt->bindParam(":punya_sim", $punya_sim);
        $stmt->bindParam(":pelanggan_id", $id);

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