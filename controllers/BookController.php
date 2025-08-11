<?php
session_start();

require_once __DIR__ . '/../models/BookModel.php';
require_once __DIR__ . '/../middlewares/auth.php';

class BookController
{
    private $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
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
                $books = $result['result'];
                require __DIR__ . '/../views/books/show.php';
            }
        } else {
            $error = $result['message'];
        }
    }

    public function create()
    {
        if (isAdmin()) {
            $categories = $this->bookModel->getCategories()['result'];

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            } else {
                require __DIR__ . '/../views/books/create.php';
            }
        } else {
            header('Location: index.php?route=book/index');
        }

    }
}