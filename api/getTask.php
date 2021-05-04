<?php

require 'config/database.php';
require 'config/constants.php';
require 'config/headers.php';
require 'objects/Task.php';
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

	$taskList = new Task($db);
	$data = $taskList->getTask();

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