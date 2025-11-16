<?php

class kendaraanModel {
    private $conn;
    private $table = 'kendaraan';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}
?>