<?php
    Class Database{

        private $link;

        public function __construct()
        {
            $this->connect();
        }

        private function connect()
        {
            $config = require_once 'config.php';
            $dsn = 'mysql:host='.$config['host'].';dbname='.$config['db_name'].';charset='.$config['charset'];
            $this->link = new PDO($dsn, $config['username'], $config['password']);
            return $this;
        }

        public function execute($sql, $data)
        {
            $sth = $this->link->prepare($sql);

            return $sth->execute(array(':full_name' => $data['full_name'], ':login' => $data['login'],
                ':email' => $data['email'], ':password' => $data['password'], ':path' => $data['path']));
        }
        public function query($sql, $data)
        {
            $sth = $this->link->prepare($sql);
            $sth->bindValue(":login", $data["login"]);
            $sth->execute();
            $result = $sth->featchAll(PDO::FETCH_ASSOC);

            if($result === false)
            {
                return[];
            }

            return $result;
        }

    }

