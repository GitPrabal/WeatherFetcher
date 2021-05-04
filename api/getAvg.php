<?php

require 'config/database.php';
require 'config/constants.php';
require 'config/headers.php';
require 'models/Weather.php';
// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    http_response_code(405);
    $result = json_encode(array("message" => "Method Not Allowed."));
    echo $result;
    return;
}

try {
    $days  = constant("last_days");
    $weather = new Weather($db);
    $data = json_decode(file_get_contents("php://input"));
    $weather->last_days = empty($data->last_days) ? $days : $data->last_days;
    $data = $weather->getAvg($weather->last_days);

    if (!empty($data)) {
        http_response_code(200);
        echo json_encode(array("results" => $data, "message" => "success",));
    } else {
        $data = array();
        http_response_code(200);
        echo json_encode(array("results" => $data, "message" => 'success'));
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(array("results" => $data, "message" => "Internal Server Error"));
}
