<?php
include 'connection.php';


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

exit(0);
}


$method = $_SERVER['REQUEST_METHOD'];
if ($method !== 'POST') {
    http_response_code(400);
    echo 'Only POST method is allowed.';
    exit();
}


$postData = file_get_contents('php://input');
$data = json_decode($postData, true);


$username = $data['username'];
$password = sha1($data['password']);

$response = [];
$sql = mysqli_query($connect, "SELECT * FROM user where username = '$username' and password = '$password' ");
$numRows = mysqli_num_rows($sql);

if($numRows > 0){
    $row = mysqli_fetch_assoc($sql);
    $response = $row;
    
    echo json_encode(['status' => 'succes', 'msg' => 'User found', 'data' => $response]);
}else {
    echo json_encode(['status' => 'fail', 'msg' => 'User not found', 'data' => $response]);
}
?>