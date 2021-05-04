<?php
require 'config/database.php';
require 'config/constants.php';
require 'config/headers.php';
require 'objects/Weather.php';
require 'objects/Create.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    $result = json_encode(array("message" => "Method Not Allowed."));
    return $result;
}

$weather = new Weather($db);
$city    = json_decode(file_get_contents("php://input"));
$apiUrl  = constant("apiUrl");
$apiKey  = constant("apiKey");
$weather->city = empty($city->city) ? constant("city") : $city->city;
$data = $weather->getWeather($apiUrl, $apiKey, $weather->city);

try {

    if (!empty($data) && isset($data->temp) && $weather->getWeather($apiUrl, $apiKey, $weather->city)) {
        $weather->value = $data->temp;
        $createWeather = new Create($db);
        $data = $createWeather->createWeather($weather->city, $weather->value);
        http_response_code(200);
        echo json_encode(array("message" => "Created."));
    } else {
        echo json_encode(array("message" => "Fail."));
    }

}
catch(Exception $e) {
    echo json_encode(array("message" => $e));
}
?>