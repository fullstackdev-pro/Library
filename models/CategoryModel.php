<?php
require_once __DIR__ . '/../config/database.php';

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
            if (empty($id)) {
                return ['success' => false, 'message' => 'Id bo\'lishi kerak'];
            }

            $stmt = $this->pdo->prepare("SELECT * FROM categories WHERE id = ?");
            $stmt->execute([$id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function create($category_name)
    {
        try {
            if (empty($category_name)) {
                return ['success' => false, 'message' => 'Kategoriya nomi bo\'lishi kerak'];
            }
            $stmt = $this->pdo->prepare("INSERT INTO categories (name) VALUE (?)");
            $result = $stmt->execute([$category_name]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function update($name, $id)
    {
        try {
            if (empty($name) || empty($id)) {
                return ['success' => false, 'message' => 'Kategoriya nomi va Id bo\'lishi kerak'];
            }
            $stmt = $this->pdo->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $result = $stmt->execute([$name, $id]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function delete($id)
    {
        try {
            if (empty($id)) {
                return ['success' => false, 'message' => 'Kategoriya Id bo\'lishi kerak'];
            }
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id = ?");
            $result = $stmt->execute([$id]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

}
