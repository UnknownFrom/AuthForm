<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /');
}
require_once './Templates/profile-template.php';