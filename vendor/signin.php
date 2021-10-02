<?php

session_start();
require_once '../Database/app.php';
require_once '../assets/constants.php';

$login = $_POST['login'];
$password = $_POST['password'];

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}
if ($password === '') {
    $error_fields[] = 'password';
}
if (!empty($error_fields)) {
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Проверьте правильность полей',
        'fields' => $error_fields
    ];
    echo json_encode($response);
    die();
}
$password = md5($_POST['password']);
$data = [
    'login' => $login,
    'password' => $password
];

$user = checkUser($data);
if (!$user) {
    $error_fields[] = 'login';
    $error_fields[] = 'password';
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Неверный логин или пароль',
        'fields' => $error_fields
    ];
    echo json_encode($response);
    die();
}

$_SESSION['user'] = [
    'id' => $user['id'],
    'fullName' => $user['fullName'],
    'avatar' => $user['avatar'],
    'email' => $user['email']
];
$response = [
    'status' => true
];

echo json_encode($response);

function checkUser($data)
{
    $sql = 'SELECT * FROM `test` WHERE `login` = :login AND `password` = :password';
    return App::getResultFromDB($sql, $data);
}


