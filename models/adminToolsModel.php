<?php
class adminToolsModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getExplainAnalyze($query) {
        try {
            $stmt = $this->conn->prepare("EXPLAIN ANALYZE " . $query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN); 
        } catch (PDOException $e) {
            return ["Error: " . $e->getMessage()];
        }
    }

    // 2. FUNGSI SIMULASI TRANSAKSI SUKSES (COMMIT)
    public function simulasiTransaksiSukses() {
        $log = [];
        try {
            $this->conn->beginTransaction();
            $log[] = "1. Transaksi DIMULAI (BEGIN).";

            // Step A: Insert Dummy Pelanggan
            $sql1 = "INSERT INTO Pelanggan (nama_pelanggan, no_ktp, no_telepon, alamat, punya_sim) 
                     VALUES ('Test User Sukses', '99999999', '0812345678', 'Jl Test', 'true') RETURNING pelanggan_id";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute();
            $id = $stmt1->fetchColumn();
            $log[] = "2. Insert Pelanggan Dummy Berhasil. ID: $id.";

            // Step B: Update data dummy (Simulasi perubahan lain)
            $sql2 = "UPDATE Pelanggan SET alamat = 'Jl. Update Sukses' WHERE pelanggan_id = :id";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([':id' => $id]);
            $log[] = "3. Update Alamat Pelanggan Berhasil.";

            $this->conn->commit();
            $log[] = "4. Transaksi DI-COMMIT. (Data tersimpan permanen).";

            // Hapus data dummy agar tidak nyampah (Cleanup)
            $this->conn->exec("DELETE FROM Pelanggan WHERE pelanggan_id = $id");
            $log[] = "5. (Cleanup) Data dummy dihapus kembali.";

            return ['status' => 'success', 'log' => $log];

        } catch (Exception $e) {
            $this->conn->rollBack();
            return ['status' => 'error', 'log' => $log, 'message' => $e->getMessage()];
        }
    }

    // 3. FUNGSI SIMULASI TRANSAKSI GAGAL (ROLLBACK)
    public function simulasiTransaksiRollback() {
        $log = [];
        try {
            $this->conn->beginTransaction();
            $log[] = "1. Transaksi DIMULAI (BEGIN).";

            // Step A: Insert Dummy Pelanggan (Harusnya berhasil sementara)
            $sql1 = "INSERT INTO Pelanggan (nama_pelanggan, no_ktp, no_telepon, alamat, punya_sim) 
                     VALUES ('Test User Rollback', '88888888', '0898765432', 'Jl Test Fail', 'true') RETURNING pelanggan_id";
            $stmt1 = $this->conn->prepare($sql1);
            $stmt1->execute();
            $newId = $stmt1->fetchColumn();
            $log[] = "2. Insert Pelanggan Dummy Berhasil (ID Sementara: $newId).";

            // Step B: Insert Rental dengan Data INVALID untuk memicu Error
            // Kita masukkan ID Kendaraan yang TIDAK ADA ('K9999') untuk memicu FK Error
            $log[] = "3. Mencoba Insert Rental dengan Kendaraan ID 'K9999' (Tidak Ada)...";
            
            $sql2 = "INSERT INTO Rental (pelanggan_id, kendaraan_id, tanggal_mulai, tanggal_selesai_rencana, total_biaya_rencana) 
                     VALUES (:p_id, 'K9999', NOW(), NOW(), 50000)";
            $stmt2 = $this->conn->prepare($sql2);
            $stmt2->execute([':p_id' => $newId]);

            // Code di bawah ini tidak akan tereksekusi karena error di atas
            $this->conn->commit();

        } catch (Exception $e) {
            // Tangkap Error
            $this->conn->rollBack();
            $log[] = "4. TERJADI ERROR: " . $e->getMessage();
            $log[] = "5. Transaksi DI-ROLLBACK. (Semua perubahan dibatalkan).";
            
            // Cek apakah data pelanggan tadi benar-benar hilang?
            $stmtCheck = $this->conn->query("SELECT count(*) FROM Pelanggan WHERE no_ktp = '88888888'");
            $count = $stmtCheck->fetchColumn();
            if($count == 0) {
                $log[] = "6. VERIFIKASI: Data Pelanggan ID $newId TIDAK DITEMUKAN di database (Rollback Sukses).";
            }

            return ['status' => 'rollback', 'log' => $log];
        }
    }
}
?>