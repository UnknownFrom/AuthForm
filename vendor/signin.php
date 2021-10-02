<?php
session_start();
require_once('connect.php');
global $connect;

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
if ($user) {
    $_SESSION['user'] = [
        'id' => $user['id'],
        'fullName' => $user['fullName'],
        'avatar' => $user['avatar'],
        'email' => $user['email']
    ];
    $response = [
        'status' => true
    ];
} else {
    $response = [
        'status' => false,
        'message' => 'Неверный логин или пароль'
    ];
}
echo json_encode($response);

function checkUser($data)
{
    global $db;
    $sql = 'SELECT * FROM `test` WHERE `login` = :login AND `password` = :password';
    $sth = $db->prepare($sql);
    $sth->execute($data);
    return $sth->fetch(PDO::FETCH_ASSOC);
}


