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
    <form method="post" enctype="multipart/form-data">
        <label>ФИО</label>
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
        <button type="submit" class="reg">Зарегистрироваться</button>
        <p>
            У вас уже есть аккаунт? - <a href="auth.php">авторизируйтесь</a>!
            <br>
            <label class="star">*</label> - обязательные поля для заполнения
        </p>
        <?php
            if(isset($_SESSION['message'])){
                echo '<p class="msg">' . $_SESSION['message'] . '</p>';
            }
            unset($_SESSION['message']);
        ?>
    </form>
<script>
    $(document).ready(function (){
        $('button.reg').on('click', function (){
            var full_nameVal = $('input.full_name').val();
            var loginVal = $('input.login').val();
            var emailVal = $('input.email').val();
            //var avatarVal = $('input.avatar').val();
            var passwordVal = $('input.password').val();
            var password_confirmVal = $('input.password_confirm').val();

            $.ajax({
                method: "POST",
                url: "vendor/signup.php",
                data: { full_name: full_nameVal,
                    login: loginVal,
                    email: emailVal,
                    //avatar: avatarVal,
                    password: passwordVal,
                    password_confirm: password_confirmVal}
            })
                .done(function( msg ) {
                    alert( "Data Saved: " + msg );
                });
        })
    })
</script>
</body>
</html>