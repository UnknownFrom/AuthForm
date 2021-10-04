<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: profile.php-fpm');
}
require_once './Templates/register-template.php';