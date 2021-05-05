<?php
// 'user' object
class Weather {
    // database connection and table name
    private $conn;
    private $table_name = "weather";

    public function __construct($db) {
        $this->conn = $db;
    }
    
  
    public function getLastWeather() {
        $query = "SELECT city,value,added_date FROM " . $this->table_name . " order by id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $row = $stmt->fetch(PDO::FETCH_ASSOC); // get the mysqli result
    }

    public function getAvg($limit = null) {

    	$query = "SELECT avg(value) as average FROM (SELECT value FROM ".$this->table_name." ORDER BY id DESC LIMIT $limit) t1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row;
    }
}
?>