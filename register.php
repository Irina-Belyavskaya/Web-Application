<?php
session_start();
require_once 'WorkWithDatabase.php';
require_once 'Validation.php';

$headers = apache_request_headers();
$is_ajax = (isset($headers['X-Requested-With']) && $headers['X-Requested-With'] == 'XMLHttpRequest');
if ($is_ajax) {
    $dataForm = file_get_contents('php://input');
    $personIfo = json_decode($dataForm, true);

    $valid = Validation::getInstance();
    $resultMessage = $valid->CheckParameters($personIfo["login"],$personIfo["password"],$personIfo["passwordConfirm"],$personIfo["email"],$personIfo["name"], false);
    if ($resultMessage) {
        header('HTTP/1.1 400 Bad Request');

    } else {
        $database = WorkWithDatabase::getInstance();
        $isAdd = $database->addPerson($personIfo["login"],$personIfo["password"],$personIfo["email"],$personIfo["name"]);
        if ($isAdd) {
            $_SESSION['user'] = $personIfo["name"];
            header('HTTP/1.1 200 OK');
        }
    }
    header('Content-Type: application/json');
    echo json_encode($resultMessage);
}









