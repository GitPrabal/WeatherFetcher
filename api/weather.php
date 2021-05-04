<?php
require 'config/constants.php';
require 'config/database.php';
require 'config/headers.php';
require 'models/Weather.php';
require 'models/Create.php';
require 'service/Service.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    http_response_code(405);
    $result = json_encode(array("message" => "Method Not Allowed."));
    return $result;
}

$service = new Service($db);
$city    = json_decode(file_get_contents("php://input"));
$city = empty($city->city) ? constant("city") : $city->city;
$data = $service->getWeather( $city);

try {

    if (!empty($data) && isset($data->temp)) {
        $createWeather = new Create($db);
        $data = $createWeather->createWeather($weather->city, $data->temp);
        http_response_code(200);
        echo json_encode(array("message" => "Created."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Fail."));
    }

}
catch(Exception $e) {
     http_response_code(503);
    echo json_encode(array("message" => $e));
}
?>