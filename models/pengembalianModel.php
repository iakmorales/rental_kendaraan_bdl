<?php

class pengembalianModel {
    private $conn;
    private $table = 'pengembalian';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}