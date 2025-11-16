<?php
/**
 * FILE: models/rentalModel.php
 * FUNGSI: Model untuk tabel rental
 */
class rentalModel {
    private $conn;
    private $table = 'rental';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}