<?php

require_once '../Database/app.php';
require_once '../assets/constants.php';

$fullName = $_POST['fullName'];
$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$passwordConfirm = $_POST['passwordConfirm'];

if (App::getResultFromDB(SELECT_LOGIN, ['login' => $login])) {
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

App::setResultToDB(INSERT_USER, $data);
//toSetData($data);

$response = [
    'status' => true,
    'message' => 'Регистрация прошла успешно'
];

echo json_encode($response);