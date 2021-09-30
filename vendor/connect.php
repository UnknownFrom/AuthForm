<?php
try {
    $config = require_once 'config.php';
    $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'];
    $db = new PDO($dsn, $config['username'], $config['password']);
}
catch (PDOException $e)
{
    echo $e->getMessage();
    die();
}
