<?php
// 'user' object
class Weather {
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
    public function getWeather($apiUrl = null, $apiKey = null, $city = null) {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [CURLOPT_URL => $apiUrl . urldecode($city), CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_HTTPHEADER => ["x-rapidapi-host: community-open-weather-map.p.rapidapi.com", "x-rapidapi-key: " . $apiKey, ], ]);
            $response = curl_exec($curl);
            $response = json_decode($response);
            $temp = $response->main;
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                throw new Exception("cURL Error #:" . $err);
            } else {
                return $temp;
            }
        }
        catch(\Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }
    public function getLastWeather() {
        $query = "SELECT value FROM " . $this->table_name . " order by id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC); // get the mysqli result
        $value = $row["value"];
        return $value;
    }
    public function getAvg() {
        $query = "SELECT value FROM " . $this->table_name . " order by id DESC LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(); // get the mysqli result
        $value = $row["0"];
        return $value;
    }
}
?>