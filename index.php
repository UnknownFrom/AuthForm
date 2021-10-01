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
    <title>Выбор</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<form class="fr">
    <button formaction="auth.php">Авторизоваться</button>
    <button formaction="register.php">Зарегистрироваться</button>
</form>
</body>
</html>