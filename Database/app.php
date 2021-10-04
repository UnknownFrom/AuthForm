<?php

require_once 'connect.php';
global $db;

class App
{
    //public $db;

    /*public function __construct()
    {
        try {
            require_once 'connect.php-fpm';
            global $db;
            $this->db = $db;
        }
        catch (Exception $e)
        {
            echo $e->getMessage();
            die();
        }
    }*/

    static function getResultFromDB($sql, $data)
    {
        try {
            global $db;
            $sth = $db->prepare($sql);
            $sth->execute($data);
            return $sth->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }

    static function setResultToDB($sql, $data)
    {
        try {
            global $db;
            $sth = $db->prepare($sql);
            $sth->execute($data);
        } catch (Exception $e) {
            echo $e->getMessage();
            die();
        }
    }
}