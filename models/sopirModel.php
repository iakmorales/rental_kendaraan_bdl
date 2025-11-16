<?php

class sopirModel {
    private $conn;
    private $table = 'sopir';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

}