<?php

require 'config/database.php';
require 'config/constants.php';
//require 'config/headers.php';
require 'models/Weather.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    http_response_code(405);
    $result = json_encode(array("message" => "Method Not Allowed."));
    echo $result;
    return;
}

try {
    $weather = new Weather($db);
    $data = $weather->getLastWeather();
    if (!empty($data)) {
        http_response_code(200);
        echo json_encode(array("results" => $data, "message" => "success",));
    } else {
        $data = array();
        http_response_code(200);
        echo json_encode(array("results" => $data, "message" => 'fail'));
    }
} catch (Exception $e) {
    http_response_code(200);
    echo json_encode(array("results" => $data, "message" => "Internal Server Error"));
}
