<?php
include 'connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST,  PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'PUT') {
    http_response_code(400);
    echo 'Only GET method is allowed.';
    exit();
}



$postData = file_get_contents('php://input');
$data = json_decode($postData, true);


$id = $data['student_id'];
$name = $data['student_name'];
$no = $data['student_no'];
$class = $data['student_class'];

$sql = mysqli_query($connect, "UPDATE students 
                               set 
                               student_name = '$name', 
                               student_no = '$no',
                               student_class = '$class'
                               where student_id = $id ");
$affectedRow = mysqli_affected_rows($connect);

header('Content-Type: application/json');
echo json_encode([
    'status' => 'ok',
    'msg'    => 'Data has been edited succesfully.',
    'affected_row' => $affectedRow
]);
