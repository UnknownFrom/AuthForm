<?php
    $connect = mysqli_connect('localhost', 'root','','paveladmin');
    if(!$connect)
    {
        die("Error connect to DateBase");
    }