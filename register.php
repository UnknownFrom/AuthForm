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
</head>
<body>
    <form action="vendor/signup.php" method="post" enctype="multipart/form-data">
        <label>ФИО</label>
        <input type="text" name="full_name" placeholder="Введите полное имя">
        <label>Логин*</label>
        <input type="text" name="login" placeholder="Введите логин">
        <label>e-mail*</label>
        <input type="email" name="email" placeholder="Введите почту">
        <label>Изображение профиля</label>
        <input type="file" name="avatar">
        <label>Пароль*</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля*</label>
        <input type="password" name="password_confirm" placeholder="Повторите пароль">
        <button type="submit">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="auth.php">авторизируйтесь</a>!
        </p>
        <?php
            if(isset($_SESSION['message'])){
                echo '<p class="msg">' . $_SESSION['message'] . '</p>';
            }
            unset($_SESSION['message']);
        ?>
    </form>
</body>
</html>