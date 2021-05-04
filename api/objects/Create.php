<?php
// 'user' object
class Create {
    // database connection and table name
    private $conn;
    private $table_name = "weather";
    private $task_table = 'task';
    // object properties
    public $city;
    public $value;
    // constructor
    public function __construct($db) {
        $this->conn = $db;
    }
    function createWeather($city = null, $value = null) {
        // insert query
        $query = "INSERT INTO " . $this->table_name . " SET city = :city, value = :value";
        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $city = htmlspecialchars(strip_tags($city));
        $value = htmlspecialchars(strip_tags($value));
        // bind the values
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':value', $value);
        // execute the query, also check if query was successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function createTable() {
        $query = "CREATE TABLE IF NOT EXISTS ".$this->task_table." (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        job LONGTEXT,
        status varchar(100),
        created_at TIMESTAMP)";
        // prepare the query
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();

    }

    function createTask($job=null,$status=null){

        $query = "INSERT INTO " . $this->task_table . " SET job = :job, status = :status";
        // prepare the query
        $stmt = $this->conn->prepare($query);
        // sanitize
        $job = htmlspecialchars(strip_tags($job));
        $status = htmlspecialchars(strip_tags($status));
        // bind the values
        $stmt->bindParam(':job', $job);
        $stmt->bindParam(':status', $status);
        // execute the query, also check if query was successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>