<?php
/**
 * FILE: models/pengembalianModel.php
 * FUNGSI: Model untuk tabel pengembalian
 */
class pengembalianModel {
    private $conn;
    private $table = 'pengembalian';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}