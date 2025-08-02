<?php

require_once __DIR__ . '/../config/database.php';

class UserModel
{
    private $pdo;

    public function __construct()
    {
        $db = new Database();
        $this->pdo = $db->connect();
    }

    public function register($username, $email, $password)
    {
        try {
            if (empty($username) || empty($email) || empty($password)) {
                $error = "Barcha ma'lumotlar bo'lishi kerak";
                return ['success' => false, 'message' => $error];
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $user = $stmt->execute([$username, $email, $hashedPassword]);

            return ['success' => true, 'result' => $user];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function login($email, $password)
    {
        try {
            if (empty($email) || empty($password)) {
                $error = "Barcha ma'lumotlar bo'lishi kerak";
                return ['success' => false, 'message' => $error];
            }

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    return ['success' => true, 'result' => $user];
                } else {
                    return ['success' => false, 'message' => "Parol noto'g'ri"];
                }
            } else {
                return ['success' => false, 'message' => "User topilmadi"];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
