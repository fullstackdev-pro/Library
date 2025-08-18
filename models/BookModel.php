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

    public function show($id)
    {
        if (empty($id)) {
            return ['success' => false, 'message' => 'id bo\'lishi kerak'];
        }

        try {
            $stmt = $this->pdo->prepare('SELECT * FROM books WHERE id = ?');
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function create($title, $author, $category_id, $description, $available, $image)
    {
        try {
            if (empty($title) || empty($author) || empty($category_id) || empty($description) || empty($available) || empty($image)) {
                return ['success' => false, 'message' => "Barcha ma'lumotlar bo'lishi kerak"];
            }

            $stmt = $this->pdo->prepare('INSERT INTO books (title, author, category_id, description, available, image) VALUES (?, ?, ?, ?, ?, ?)');
            $result = $stmt->execute([$title, $author, $category_id, $description, $available, $image]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function edit($title, $author, $category_id, $description, $available, $image, $id)
    {
        try {
            if (empty($title) || empty($author) || empty($category_id) || empty($description) || empty($available) || empty($image)) {
                return ['success' => false, 'message' => "Barcha ma'lumotlar bo'lishi kerak"];
            }

            $stmt = $this->pdo->prepare(
                'UPDATE books
                        SET title = ?, author = ?, category_id = ?, description = ?, available = ?, image = ? 
                        WHERE id = ?'
            );

            $result = $stmt->execute([$title, $author, $category_id, $description, $available, $image, $id]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

    public function delete($id)
    {
        try {
            if (empty($id)) {
                return ['success' => false, 'message' => 'Id bo\'lishi kerak'];
            }

            $stmt = $this->pdo->prepare('DELETE FROM books WHERE id = ?');
            $result = $stmt->execute([$id]);

            return ['success' => true, 'result' => $result];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }


    }

    public function search($search)
    {
        try {
            if (empty($search)) {
                $error = '$search bo\'lishi kerak';
                return ['success' => false, 'result' => $error];
            }

            $stmt = $this->pdo->prepare("
        SELECT *, 
        CASE
         WHEN MATCH(title, author, description) AGAINST(:search IN NATURAL LANGUAGE MODE) THEN 3
         WHEN title LIKE CONCAT('%', :search, '%') THEN 3
         WHEN author LIKE CONCAT('%', :search, '%') THEN 2
         WHEN description LIKE CONCAT('%', :search, '%') THEN 1
         ELSE 0
           END AS relevance
        FROM books
        WHERE MATCH(title, author, description) AGAINST(:search IN NATURAL LANGUAGE MODE)
            OR title LIKE CONCAT('%', :search, '%')
            OR author LIKE CONCAT('%', :search, '%')
            OR description LIKE CONCAT('%', :search, '%')
        ORDER BY relevance DESC;
        ");

            $stmt->execute([":search" => $search]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($results)) {
                return ['success' => true, 'result' => $results];
            } else {
                $error = "Qidiruvda hech narsa topilmadi";
                return ['success' => false, 'message' => $error];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }

}