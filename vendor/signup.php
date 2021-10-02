<?php
session_start();
require_once('connect.php');
global $connect, $db;

const ERROR_CORRECT_FIELDS = 1;
const ERROR_LOAD_AVATAR = 2;

$fullName = $_POST['fullName'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];


if (checkLogin($login, $db)) {
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Такой логин уже существует',
        'fields' => ['login']
    ];
    echo json_encode($response);
    die();
}

$errorFields = [];

if ($login === '') {
    $errorFields[] = 'login';
}
if ($password === '') {
    $errorFields[] = 'password';
}
if ($fullName === '') {
    $errorFields[] = 'fullName';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorFields[] = 'email';
}
if ($passwordConfirm === '') {
    $errorFields[] = 'passwordConfirm';
}

if (!empty($errorFields)) {
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Проверьте правильность полей',
        'fields' => $errorFields
    ];
    echo json_encode($response);
    die();
}

if ($password !== $passwordConfirm) {
    $errorFields[] = 'password';
    $errorFields[] = 'passwordConfirm';
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Пароли не совпадают',
        'fields' => $errorFields
    ];
    echo json_encode($response);
    die();
}

if (isset($_FILES['avatar'])) {
    $path = 'uploads/' . time() . $_FILES['avatar']['name'];
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) { /*если аватар не загружается*/
        $response = [
            'status' => false,
            'type' => ERROR_LOAD_AVATAR,
            'message' => 'Ошибка при загрузке аватара'
        ];
        echo json_encode($response);
        die();
    }
} else {
    $path = '';
}

$password = md5($password);
$data = [
    'fullName' => $fullName,
    'login' => $login,
    'email' => $email,
    'password' => $password,
    'path' => $path
];

toSetData($data, $db);

$response = [
    'status' => true,
    'message' => 'Регистрация прошла успешно'
];

echo json_encode($response);

function checkLogin($login, $db)
{
    $sql = 'SELECT * FROM test WHERE login = ?';
    $sth = $db->prepare($sql);
    $sth->execute([$login]);
    return $sth->fetch(PDO::FETCH_ASSOC);
}

function toSetData($data, $db)
{
    $sql = 'INSERT INTO test (id, fullName, login, email, password, avatar) VALUES (NULL, :fullName, :login, :email, :password, :path)';
    $sth = $db->prepare($sql);
    $sth->execute($data);
}
