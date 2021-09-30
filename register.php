<?php
    session_start();

    if(isset($_SESSION['user'])){
        header('Location: profile.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous">
    </script>
</head>
<body>
    <form>
        <label>ФИО<label class="star">*</label></label>
        <input type="text" name="full_name" class="full_name" placeholder="Введите полное имя">
        <label>Логин<label class="star">*</label></label>
        <input type="text" name="login" class="login" placeholder="Введите логин">
        <label>e-mail<label class="star">*</label></label>
        <input type="email" name="email" class="email" placeholder="Введите почту">
        <label>Изображение профиля</label>
        <input type="file" name="avatar" class="avatar">
        <label>Пароль<label class="star">*</label></label>
        <input type="password" name="password" class="password" placeholder="Введите пароль">
        <label>Подтверждение пароля<label class="star">*</label></label>
        <input type="password" name="password_confirm" class="password_confirm" placeholder="Повторите пароль">
        <button type="submit" class="button-reg">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="auth.php">авторизируйтесь</a>!
            <br>
            <label class="star">*</label> - обязательные поля для заполнения
        </p>
        <p class="msg none">1</p>
    </form>


    <script src="assets/js/http_code.jquery.com_jquery-3.6.0.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>