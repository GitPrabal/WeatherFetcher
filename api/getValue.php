<?php

namespace Api;

require '../bootstrap.php';

use Api\Config\Database;
use Api\models\Weather;

require 'Config/constants.php';
require 'Config/headers.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'GET') {

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
	    http_response_code(404);
	    echo json_encode(array("results" => $data, "message" => 'fail'));
	}

  }catch (Exception $e) {

  		echo json_encode(array("results" => $data, "message" => $e));
}

?>