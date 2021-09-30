<?php
    session_start();
    require_once ('connect.php');
    global $connect;

    $data = [
        "login" => $_POST['login'],
        "password" => ($_POST['password'])
    ];

    $error_fields = [];

    if ($data['login'] === ''){
        $error_fields[] = 'login';
    }
    if($data['password'] === '')
    {
        $error_fields[] = 'password';
    }
    if(!empty($error_fields)){
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Проверьте правильность полей",
            "fields" => $error_fields
        ];
        echo json_encode($response);
        die();
    }
    $data['password'] = md5($_POST['password']);
    $check_user = checkUser();
    if ($check_user){
        $user = $check_user;
        $_SESSION['user'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "avatar" => $user['avatar'],
            "email" => $user['email']
        ];
        $response = [
                "status" => true
        ];

        echo json_encode($response);

    } else {
        $response = [
            "status" => false,
            "message" => "Неверный логин или пароль"
        ];

        echo json_encode($response);
    }

    function checkUser(){
        global $db, $data;
        $sql = "SELECT * FROM `test` WHERE `login` = :login AND `password` = :password";
        $sth = $db->prepare($sql);
        $sth->execute($data);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    ?>


