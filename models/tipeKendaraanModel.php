<?php
/**
 * FILE: models/tipeKendaraanModel.php
 * FUNGSI: Model untuk tabel tipe_kendaraan
 */
class tipeKendaraanModel {
    private $conn;
    private $table = 'tipe_kendaraan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}