<?php
    $connect = mysqli_connect('localhost', 'root','','paveladmin');
    if(!isset($connect))
    {
        die("Error connect to DateBase");
    }