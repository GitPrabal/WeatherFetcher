<?php
// 'user' object
class Weather {
    // database connection and table name
    private $conn;
    private $table_name = "weather";

    public function __construct($db) {
        $this->conn = $db;
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