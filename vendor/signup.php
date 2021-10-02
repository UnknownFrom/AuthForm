<?php
session_start();
require_once('connect.php');
global $connect;

$fullName = $_POST['fullName'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];

if (checkLogin($login)) {
    $response = [
        'status' => false,
        'type' => 1,
        'message' => 'Такой логин уже существует',
        'fields' => ['login']
    ];
    echo json_encode($response);
    die();
}

$error_fields = [];

if ($login === '') {
    $error_fields[] = 'login';
}
if ($password === '') {
    $error_fields[] = 'password';
}
if ($fullName === '') {
    $error_fields[] = 'fullName';
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_fields[] = 'email';
}
if ($passwordConfirm === '') {
    $error_fields[] = 'passwordConfirm';
}

const ERROR_CORRECT_FIELDS = 1;

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

const ERROR_LOAD_AVATAR = 2;

if ($password === $passwordConfirm) {
    if (isset($_FILES['avatar'])) {
        $path = 'uploads/' . time() . $_FILES['avatar']['name'];
        if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
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

    toSetData($data);

    $response = [
        'status' => true,
        'message' => 'Регистрация прошла успешно'
    ];

} else {
    $error_fields[] = 'password';
    $error_fields[] = 'passwordConfirm';
    $response = [
        'status' => false,
        'type' => ERROR_CORRECT_FIELDS,
        'message' => 'Пароли не совпадают',
        'fields' => $error_fields
    ];
}
echo json_encode($response);

function checkLogin($login)
{
    global $db;
    $sql = 'SELECT * FROM test WHERE login = ?';
    $sth = $db->prepare($sql);
    $sth->execute([$login]);
    return $sth->fetch(PDO::FETCH_ASSOC);
}

function toSetData($data)
{
    global $db;
    $sql = 'INSERT INTO test (id, fullName, login, email, password, avatar) VALUES (NULL, :fullName, :login, :email, :password, :path)';
    $sth = $db->prepare($sql);
    $sth->execute($data);
}
