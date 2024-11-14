<?php
require_once 'config.php';

// Database connection class
class Database {
    private $conn;
    
    // Constructor - establish database connection
    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log("Database connection established successfully");
        } catch(PDOException $e) {
            $this->log("Connection failed: " . $e->getMessage());
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    // Get database connection
    public function getConnection() {
        return $this->conn;
    }
    
    // Helper function for console logging
    private function log($message) {
        error_log($message);
    }
} 