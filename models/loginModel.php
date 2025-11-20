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
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Verifikasi password (gunakan password_hash saat registrasi)
            if (password_verify($password, $user['password'])) {
                return $user;
            }
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
            
            echo "Query: " . $query . "<br>";
            
            $stmt = $this->conn->prepare($query);
            
            // Hash password sebelum disimpan
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);
            
            echo "Hashed Password: " . $hashedPassword . "<br>";
            
            // Bind parameters
            $stmt->bindParam(":username", $data['username']);
            $stmt->bindParam(":password", $hashedPassword);
            $stmt->bindParam(":role", $data['role']);
            
            $result = $stmt->execute();
            
            echo "Execute Result: " . ($result ? 'TRUE' : 'FALSE') . "<br>";
            
            if (!$result) {
                echo "Error Info: <pre>";
                print_r($stmt->errorInfo());
                echo "</pre>";
            }
            
            return $result;
            
        } catch (PDOException $e) {
            echo "PDO Error: " . $e->getMessage() . "<br>";
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