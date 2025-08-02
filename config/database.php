<?php

class Database
{
    private $host = 'localhost';
    private $dbname = 'library';
    private $username = 'root';
    private $password = 'qwer1234';
    private $pdo;

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Ulanish xatosi: " . $e->getMessage();
        }
    }
}
