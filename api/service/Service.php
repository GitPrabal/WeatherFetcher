<?php
// 'user' object
class Service {
    // database connection and table name
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function getWeather($city = null) {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [CURLOPT_URL => apiUrl . urldecode($city), CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_ENCODING => "", CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 30, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => "GET", CURLOPT_HTTPHEADER => ["x-rapidapi-host: community-open-weather-map.p.rapidapi.com", "x-rapidapi-key: " . apiKey, ], ]);
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
    
}
?>