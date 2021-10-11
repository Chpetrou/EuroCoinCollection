<?php

require_once '../includes/dboperation.php';
require_once '../includes/token.php';
require_once '../includes/constants.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['email']) && isset($_POST['password'])) {

        $db = new DbOperation();

        if ($db->loginUser($_POST['email'], $_POST['password'])) {
            $response['error'] = false;
            $usrID = $db-> getIDFromEmail($_POST['email']);

            $token = array();
            $token['id'] = $usrID;
            $token['email'] = $_POST['email'];
            $newtoken = JWT::encode($token, SECRET_SERVER_KEY);
            $response['token'] = $newtoken;
            session_start();
            $_SESSION['token'] = $response['token'];
            http_response_code(200);
        } else {
            http_response_code(401);
            $response['code'] = $errors['error5']['code'];
            $response['message'] = $errors['error5']['desc'];
        }

    } else {
        http_response_code(406);
        $response['code'] = $errors['error6']['code'];
        $response['message'] = $errors['error6']['desc'];
    }

} else {
    $response['code'] = $errors['error7']['code'];
    $response['message'] = $errors['error7']['desc'];
    http_response_code(404);
    include('../../404.shtml'); // provide your own HTML for the error page
    die();
}
echo json_encode($response);
