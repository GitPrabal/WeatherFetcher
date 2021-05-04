<?php
require 'config/database.php';
require 'config/constants.php';
require 'objects/Task.php';
require 'objects/Create.php';

// get database connection
$database = new Database();
$db = $database->getConnection();
// Check Method Type
if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    $result = json_encode(array("message" => "Method Not Allowed."));
    return $result;
}

try {

    $createTask = new Create($db);
    $task    = json_decode(file_get_contents("php://input"));
    $data = $createTask->createTable();
    $data = $createTask->createTask($task->job, $task->status);

    if ( $data ) {
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