<?php
/**
 * FILE: models/loginModel.php
 * FUNGSI: Model untuk autentikasi user
 */
class loginModel {
    private $conn;
    private $table = 'users';
    
    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }
    
    // METHOD 1: Authenticate user
    public function authenticate($username, $password) {
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
    
    // METHOD 2: Get user by ID
    public function getUserById($id) {
        $query = "SELECT id, username, role FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // METHOD 3: Create user baru (untuk registrasi)
    public function createUser($data) {
        try {
            $query = "INSERT INTO " . $this->table . " (username, password, role) 
                    VALUES (:username, :password, :role)";
            
            $stmt = $this->conn->prepare($query);
            
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":role", $data['role']);
            
            return $stmt->execute();
            
        } catch (PDOException $e) {
            error_log("Error creating user: " . $e->getMessage());
            return false;
        }
    }
    
    // METHOD 4: Check if username exists
    public function usernameExists($username) {
        $query = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}
?>