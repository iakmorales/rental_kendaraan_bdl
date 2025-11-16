<?php
/**
 * FILE: models/pelangganModel.php
 * FUNGSI: Model untuk tabel pelanggan
 */
class pelangganModel {
    private $conn;
    private $table = 'pelanggan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}