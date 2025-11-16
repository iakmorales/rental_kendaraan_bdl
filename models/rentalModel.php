<?php

class rentalModel {
    private $conn;
    private $table = 'rental';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}