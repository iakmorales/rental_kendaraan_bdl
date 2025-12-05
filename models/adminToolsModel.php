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
}
?>