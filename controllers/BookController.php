<?php
session_start();

require_once __DIR__ . '/../models/BookModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../middlewares/auth.php';

class BookController
{
    private $bookModel;
    private $categoryModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $result = $this->bookModel->index();

        if ($result['success']) {
            if (!empty($result['result'])) {
                $books = $result['result'];
                require __DIR__ . '/../views/books/index.php';
            } else {
                $error = 'Kitoblar topilmadi :(';
                require __DIR__ . '/../views/books/index.php';
            }
        } else {
            $error = $result['message'];
            require __DIR__ . '/../views/books/index.php';
        }
    }

    public function show()
    {
        $id = htmlspecialchars($_POST['id']);
        $result = $this->bookModel->show($id);

        if ($result['success']) {
            if (empty($result['result'])) {
                $error = "Bu kitob haqida batafsil ma'lumot topilmadi";
                require __DIR__ . '/../views/books/show.php';
            } else {
                $book = $result['result'];
                require __DIR__ . '/../views/books/show.php';
            }
        } else {
            $error = $result['message'];
            require __DIR__ . '/../views/books/show.php';
        }
    }

    public function create()
    {
        if (isAdmin()) {
            $categories = $this->categoryModel->index()['result'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $title = $_POST['title'];
                $author = $_POST['author'];
                $category_id = (int) $_POST['category_id'];
                $description = $_POST['description'];
                $available = (bool) $_POST['available'];

                $name = basename($_FILES["photo"]['name']);
                $tmp_name = $_FILES["photo"]['tmp_name'];
                $type = mime_content_type($_FILES["photo"]['tmp_name']);
                $size = $_FILES["photo"]['size'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $imageName = uniqid('upload_', true) . '.' . $ext;

                $allowed_mimes = ['image/jpg', 'image/jpeg', 'image/png'];
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $max_file_size = 2 * 1024 * 1024; // 2MB

                // Rasmlar saqlanadigan papka (fizik yo'l bilan)
                $uploadDir = __DIR__ . '/../public/images/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (in_array($ext, $allowed_extensions) && in_array($type, $allowed_mimes)) {
                    if ($size <= $max_file_size) {
                        if (is_uploaded_file($tmp_name)) {
                            if (move_uploaded_file($tmp_name, $uploadDir . $imageName)) {
                                $result = $this->bookModel->create($title, $author, $category_id, $description, $available, $imageName);

                                if ($result['success']) {
                                    header('Location: index.php?route=book/index');
                                    exit;
                                } else {
                                    require __DIR__ . '/../views/books/create.php';
                                }
                            } else {
                                exit("❌ Faylni ko‘chirishda xatolik!");
                            }
                        } else {
                            exit("Fayl yuklanmadi!");
                        }
                    } else {
                        exit("Fayl hajmi 2MB dan oshmasligi kerak.");
                    }
                } else {
                    exit("Fayl turi ruxsat etilmagan.");
                }

            } else {
                require __DIR__ . '/../views/books/create.php';
            }
        } else {
            header('Location: index.php?route=book/index');
        }

    }
}