<?php

namespace Api;

require '../bootstrap.php';

use Api\Config\Database;
use Api\models\Create;
use Api\service\Service;
use Api\models\CreateWeather;

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
$city = empty($city->city) ? city : $city->city;

$data = $service->getWeather($city);

try {
    if (!empty($data) && isset($data->temp)) {
        $createWeather = new CreateWeather($db);
        $data = $createWeather->createWeather($city, $data->temp);
        http_response_code(200);
        echo json_encode(array("message" => "Created."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Fail."));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("message" => "Service Unavailable"));
}
