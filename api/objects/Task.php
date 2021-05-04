<?php
// 'user' object
class Task {
    // database connection and table name
    private $conn;
    private $table_name = "task";

    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getTask() {

        $query = "SELECT id,job FROM " . $this->table_name . " where status = 'pending' ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>