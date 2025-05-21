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
    if ($method !== 'DELETE') {
        http_response_code(400);
        echo 'Only DELETE method is allowed.';
        exit();
    }

    $id = $_GET['student_id'];

    $postData = file_get_contents('php://input');
    $data = json_decode($postData, true);




    $sql = mysqli_query($connect, "DELETE from students where student_id = $id ");
    $affectedRow = mysqli_affected_rows($connect);

    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'ok',
        'msg'    => 'Data has been deleted succesfully.',
        'affected_row' => $affectedRow
    ]);



    ?>