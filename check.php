<?php
session_start();
require_once 'WorkWithDatabase.php';
require_once 'Validation.php';

function checkAuthorization ($login, $password): array
{
    $valid = Validation::getInstance();
    $resultMessage = $valid->CheckParameters($login,$password,null,null,null,true);
    if (!$resultMessage) {
        $database = WorkWithDatabase::getInstance();
        $id = $database->getUserID($login);
        if ($id != -1) {
            return [];
        } else {
            return ['message' => 'User not found. Please register. '];
        }
    }
    else {
        return $resultMessage;
    }
}

function checkCookie (): bool
{
    $cookieLogin = $_COOKIE['login'];
    $cookiePassword = $_COOKIE['password'];
    if (!checkAuthorization($cookieLogin, $cookiePassword)) {
        return true;
    }
    else {
        return false;
    }
}