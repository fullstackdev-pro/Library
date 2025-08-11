<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middlewares/auth.php';
session_start();

class CategoryModel
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
            $stmt = $this->pdo->query('SELECT * FROM categories ORDER BY categories.created_at DESC');
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function getCategory($id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE categories.id == ?");
            $result = $stmt->execute($id);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function update($title, $id)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO title values ? WHERE categories.id == $id");
            $result = $stmt->execute($title);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

}
