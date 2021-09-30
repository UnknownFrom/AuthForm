<?php
    session_start();
    require_once ('connect.php');
    global $connect;

    $login = $_POST['login'];
    $password = ($_POST['password']);

    $error_fields = [];

    if ($login ===''){
        $error_fields[] = 'login';
    }
    if($password ==='')
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
    $password = md5($_POST['password']);
    $check_user = mysqli_query($connect, "SELECT * FROM `test` WHERE `login` = '$login' AND `password` = '$password'");
    if (mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        $_SESSION['user'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "avatar" => $user['avatar'],
            "email" => $user['email']
        ];
        //header('Location: ../profile.php');
        $response = [
                "status" => true
        ];

        echo json_encode($response);

    } else {
        //$_SESSION['message'] = 'Не верный логин или пароль';
        //header('Location: ../auth.php');
        $response = [
            "status" => false,
            "message" => "Неверный логин или пароль"
        ];

        echo json_encode($response);
    }
    ?>

