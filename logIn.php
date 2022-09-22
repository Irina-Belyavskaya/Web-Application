<?php
session_start();
require_once 'WorkWithDatabase.php';
require_once 'check.php';
require_once 'Validation.php';

$headers = apache_request_headers();
$is_ajax = (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
if ($is_ajax) {
    $dataForm = file_get_contents('php://input');
    $personIfo = json_decode($dataForm, true);

    $resultMessage = checkAuthorization($personIfo["login"], $personIfo['password']);
    if (!$resultMessage) {
        setcookie('login', $personIfo["login"], 0, '/');
        setcookie('password', $personIfo["password"], 0, '/');

        header('HTTP/1.1 200 OK');
        header('Content-Type: application/json');
    }
    else {
        header('HTTP/1.1 400 Bad Request');
    }
    echo json_encode($resultMessage);
}