<?php
/**
 * FILE: models/usersModel.php
 * FUNGSI: Model untuk tabel users
 */
class usersModel {
    private $conn;
    private $table = 'users';

    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }

     // METHOD 1: Read semua users
    public function getAllUsers() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // METHOD 2: Get users by ID
    public function getUsersById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); // Return array, bukan statement
    }

    // METHOD 3: Create users baru
    public function createUsers($data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $query = "INSERT INTO " . $this->table . " 
                (username, password, role) 
                VALUES (:username, :password, :role)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashedPassword); 
        $stmt->bindParam(":role", $data['role']);
        
        return $stmt->execute();
    }

    // METHOD 4: Update users
    public function updateUsers($id, $data) {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
        
        $query = "UPDATE " . $this->table . " 
                SET username = :username, 
                    password = :password, 
                    role = :role
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashedPassword);
        $stmt->bindParam(":role", $data['role']);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }   

    // METHOD 5: Delete users
    public function deleteUsers($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>