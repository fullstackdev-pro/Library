<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Database
{
    private $pdo;

    public function __construct()
    {
        // .env ni yuklash
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    }

    public function connect()
    {
        try {
            $host = $_ENV['DB_HOST'];
            $dbname = $_ENV['DB_DATABASE'];
            $port = $_ENV['DB_PORT'];
            $username = $_ENV['DB_USERNAME'];
            $password = $_ENV['DB_PASSWORD'];

            $this->pdo = new PDO(
                "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
                $username,
                $password
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            echo "Ulanish xatosi: " . $e->getMessage();
            exit;
        }
    }
}
