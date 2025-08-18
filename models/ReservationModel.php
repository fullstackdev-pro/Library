<?php
require_once __DIR__ . '/../config/database.php';

class ReservationModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function index($user_id)
    {
        try {
            if (empty($user_id)) {
                return ['success' => false, 'message' => "User id bo'lishi kerak"];
            }

            $stmt = $this->pdo->prepare('SELECT * FROM reservations WHERE user_id = ?');
            $stmt->execute([$user_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                $error = "Hech narsa topilmadi";
                return ['success' => false, 'message' => $error];
            }

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function create($user_id, $book_id)
    {
        try {
            if (empty($user_id) || empty($book_id)) {
                $error = "Barcha ma\'lumotlar bo\'lishi kerak";
                return ['success' => false, 'message' => $error];
            }

            $stmt = $this->pdo->prepare('INSERT INTO reservations (user_id, book_id) VALUES (?, ?)');
            $result = $stmt->execute([$user_id, $book_id]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }
}