
<?php
/**
 * FILE: models/pengembalianModel.php
 * FUNGSI: Model untuk tabel pengembalian
 */
class pengembalianModel {
    private $conn;
    private $table = 'Pengembalian';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // METHOD 1: Read semua pengembalian
    public function getAllPengembalian() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY pengembalian_id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Create pengembalian baru (ID dari sequence)
    public function createPengembalian($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (rental_id, tanggal_kembali_aktual, denda, kondisi_akhir) 
                  VALUES (:rental_id, :tanggal_kembali_aktual, :denda, :kondisi_akhir)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":rental_id", $data['rental_id']);
        $stmt->bindParam(":tanggal_kembali_aktual", $data['tanggal_kembali_aktual']);
        $stmt->bindParam(":denda", $data['denda']);
        $stmt->bindParam(":kondisi_akhir", $data['kondisi_akhir']);
       
        return $stmt->execute();
    }

    // METHOD 3: Hitung keterlambatan pengembalian
    public function hitungKeterlambatan($rental_id, $tanggal_kembali) {
        $query = "SELECT total_keterlambatan(:rental, :tgl) AS telat";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rental', $rental_id);
        $stmt->bindParam(':tgl', $tanggal_kembali);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // METHOD 4: Hitung denda keterlambatan
    public function hitungDenda($rental_id, $tanggal_kembali) {
        $query = "SELECT hitung_denda(:rental, :tgl) AS denda";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':rental', $rental_id);
        $stmt->bindParam(':tgl', $tanggal_kembali);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // METHOD 5: Delete pengembalian berdasarkan ID
    public function deletePengembalian($id) {
        $query = "DELETE FROM " . $this->table . " WHERE pengembalian_id = :pengembalian_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pengembalian_id", $id);
        return $stmt->execute();
    }

    // METHOD 6: Cek apakah rental sudah dikembalikan
    public function isRentalReturned($rental_id) {
        $query = "SELECT COUNT(*) as count FROM " . $this->table . " WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $rental_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // METHOD 7: Get rental aktif (belum dikembalikan)
    public function getActiveRentals() {
        $query = "SELECT r.rental_id, r.tanggal_selesai_rencana 
                  FROM Rental r 
                  WHERE r.status_rental = 'Aktif' 
                  AND r.rental_id NOT IN (SELECT rental_id FROM Pengembalian)
                  ORDER BY r.rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 8: Update status rental setelah pengembalian
    public function updateRentalStatus($rental_id) {
        $query = "UPDATE Rental SET status_rental = 'Selesai' WHERE rental_id = :rental_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":rental_id", $rental_id);
        return $stmt->execute();
    }
}
?>
