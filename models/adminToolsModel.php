<?php
class adminToolsModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function runIndexingTest($scenario, $param) {
        $result = [
            'without_index' => null,
            'with_index' => null,
            'time_without' => 'N/A',
            'time_with' => 'N/A',
            'query_used' => ''
        ];
        switch ($scenario) {
            case 'kendaraan':
                $indexName = "idx_rental_kendaraan_id";
                $createSql = "CREATE INDEX IF NOT EXISTS idx_rental_kendaraan_id ON Rental(kendaraan_id)";
                $querySql = "SELECT * FROM Rental WHERE kendaraan_id = :p";
                $result['query_used'] = "SELECT * FROM Rental WHERE kendaraan_id = '$param'";
                break;

            case 'sim':
                $indexName = "idx_rental_punya_sim";
                $createSql = "CREATE INDEX IF NOT EXISTS idx_rental_punya_sim ON Pelanggan(punya_sim)";
                $param = ($param === 'true' || $param === '1') ? 'true' : 'false';
                $querySql = "SELECT * FROM Pelanggan WHERE punya_sim = $param"; 
                $result['query_used'] = "SELECT * FROM Pelanggan WHERE punya_sim = $param";
                break;

            case 'partial':
                $indexName = "idx_rental_status_aktif";
                $createSql = "CREATE INDEX IF NOT EXISTS idx_rental_status_aktif ON Rental(rental_id) WHERE status_rental = 'Aktif'";
                $querySql = "SELECT * FROM Rental WHERE status_rental = 'Aktif'";
                $result['query_used'] = "SELECT * FROM Rental WHERE status_rental = 'Aktif'";
                $param = null; 
                break;
                
            default:
                return false;
        }

        try {
            
            $this->conn->exec("DROP INDEX IF EXISTS $indexName");
            
            
            $stmt = $this->conn->prepare("EXPLAIN ANALYZE " . $querySql);
            if ($param !== null && $scenario !== 'sim') { 
                $stmt->bindParam(':p', $param); 
            }
            $stmt->execute();
            $result['without_index'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result['time_without'] = $this->parseExecutionTime($result['without_index']);

           
            $this->conn->exec($createSql);
            
            
            $stmt = $this->conn->prepare("EXPLAIN ANALYZE " . $querySql);
            if ($param !== null && $scenario !== 'sim') { 
                $stmt->bindParam(':p', $param); 
            }
            $stmt->execute();
            $result['with_index'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $result['time_with'] = $this->parseExecutionTime($result['with_index']);

        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }

        return $result;
    }

    
    private function parseExecutionTime($explainResult) {
        $text = "";
        foreach ($explainResult as $row) {
            $text .= implode(" ", $row); 
        }

   
        if (preg_match('/Execution Time:\s+([\d\.]+)\s+ms/i', $text, $matches)) {
            return $matches[1] . " ms";
        }
        return "0.01 ms"; // Fallback
    }

    public function getListKendaraanID() {
        $stmt = $this->conn->query("SELECT DISTINCT kendaraan_id FROM Rental LIMIT 20");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getPendapatanKendaraan($kendaraan_id) {
        try {
            $stmt = $this->conn->prepare("SELECT func_total_pendapatan_kendaraan(:id) as total");
            $stmt->bindParam(':id', $kendaraan_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return false;
        }
    }


    public function getRiwayatKendaraan($kendaraan_id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM func_riwayat_rental_kendaraan(:id)");
            $stmt->bindParam(':id', $kendaraan_id);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            return false;
        }
    }

    // METHOD UNTUK MEMANGGIL STORED PROCEDURE
    public function execBookingExpress($pelanggan_id, $kendaraan_id, $lama_hari) {
        try {
            $query = "CALL proc_booking_express(:pid, :kid, :hari)";
            
            $stmt = $this->conn->prepare($query);
            
            // Bind Parameter
            $stmt->bindParam(':pid', $pelanggan_id);
            $stmt->bindParam(':kid', $kendaraan_id);
            $stmt->bindParam(':hari', $lama_hari);
            
            return $stmt->execute();

        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }
}
?>