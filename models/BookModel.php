<?php
require_once __DIR__ . '/../config/database.php';

class BookModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database;
        $this->pdo = $db->connect();
    }

    public function index()
    {
        try {
            $stmt = $this->pdo->query('SELECT * FROM books ORDER BY books.created_at DESC');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }
}