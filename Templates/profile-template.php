<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link rel="stylesheet" href="../assets/css/main.css">
</head>
<body>
<form action="../vendor/signin.php" method="post">
    <img src="<?= $_SESSION['user']['avatar'] ?>" style="align-self: center" width="200" alt="">
    <h2 style="margin: 5px 0; font-size: 20px; align-self: center"><?= $_SESSION['user']['fullName'] ?></h2>
    <a href="mailto: <?= $_SESSION['user']['email'] ?>" style="align-self: center"><?= $_SESSION['user']['email'] ?></a>
    <a href="../vendor/logout.php" class="logout">Выход</a>
</form>
</body>
</html>