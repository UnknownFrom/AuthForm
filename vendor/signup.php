<?php
    session_start();
    require_once ('connect.php');
    global $connect;

    $full_name = $_POST['full_name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    if($password == $password_confirm){

        if($login != NULL && $email != NULL && $password != NULL) {
            $password = md5($password);
            if ($_FILES['avatar']['name'] != "") {
                $path = 'uploads/' . time() . $_FILES['avatar']['name'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path);
                if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
                    $_SESSION['message'] = 'Ошибка при загрузке аватара';
                    header('Location: ../register.php');
                }
            } else {
                $path = NULL;
            }
            mysqli_query($connect, "INSERT INTO `test` (`id`, `full_name`, `login`, `email`, `password`, `avatar`) VALUES (NULL, '$full_name', '$login', '$email', '$password', '$path')");
            $_SESSION['message'] = 'Регистрация прошла успешно!';
            header('Location: ../auth.php');
        }
        else{
            $_SESSION['message'] = 'Введите все требуемые данные';
            header('Location: ../register.php');
        }


    } else {
        $_SESSION['message'] = 'Пароли не совпадают';
        header('Location: ../register.php');
    }