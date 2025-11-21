<?php
/**
 * FILE: config/database.php
 * FUNGSI: Membuat koneksi ke database PostgreSQL
 */
class Database {
    private $host = "localhost";
    private $port = "5433";
    private $db_name = "db_rental_kendaraan2";
    private $username = "postgres";
    private $password = "AdminMi29";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);

            // Mode error
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        } catch(PDOException $exception) {
            // error
            echo "❌ Error koneksi database: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

