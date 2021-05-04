<?php
// 'user' object
class Create {
    // database connection and table name
    private $conn;
    private $table_name = "weather";
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
}

?>