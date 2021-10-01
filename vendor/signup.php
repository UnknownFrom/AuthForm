<?php
    session_start();
    require_once ('connect.php');
    global $connect;

    $data = [
        "full_name" => $_POST['full_name'],
        "login" => $_POST['login'],
        "email" => $_POST['email'],
        "password" => $_POST['password']
    ];
    $password_confirm = $_POST['password_confirm'];

    $check_login = checkLogin();

    if ($check_login){
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Такой логин уже существует",
            "fields" => ['login']
        ];
        echo json_encode($response);
        die();
    }
    $error_fields = [];

    if ($data['login'] === ''){
        $error_fields[] = 'login';
    }
    if($data['password'] === '')
    {
        $error_fields[] = 'password';
    }
    if($data['full_name'] === '')
    {
        $error_fields[] = 'full_name';
    }
    if($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL))
    {
        $error_fields[] = 'email';
    }
    if($password_confirm === '')
    {
        $error_fields[] = 'password_confirm';
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

    if($data['password'] === $password_confirm) {
        if(isset($_FILES['avatar'])) {
            $path = 'uploads/' . time() . $_FILES['avatar']['name'];
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
                $response = [
                    "status" => false,
                    "message" => "Ошибка при загрузке аватара"
                ];
                echo json_encode($response);
                die();
            }
        }
        else{
            $path = '';
        }
        $data['password'] = md5($data['password']);
        $data['path'] = $path;

        toSetData();

        $response = [
            "status" => true,
            "message" => "Регистрация прошла успешно"
        ];
        echo json_encode($response);

    } else {
        $error_fields[] = 'password';
        $error_fields[] = 'password_confirm';
        $response = [
            "status" => false,
            "type" => 1,
            "message" => "Пароли не совпадают",
            "fields" => $error_fields
        ];
        echo json_encode($response);
    }

    function checkLogin()
    {
        global $db, $data;
        $sql = "SELECT * FROM test WHERE login = ?";
        $sth = $db->prepare($sql);
        $sth->execute(array($data['login']));
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    function toSetData()
    {
        global $db, $data;
        $sql = 'INSERT INTO test (id, full_name, login, email, password, avatar) VALUES (NULL, :full_name, :login, :email, :password, :path)';
        $sth = $db->prepare($sql);
        $sth->execute($data);
    }
