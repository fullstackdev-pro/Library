<?php
session_start();

require_once __DIR__ . '/../models/BookModel.php';

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
                $error = 'Kitob topilmadi :(';
                require __DIR__ . '/../views/books/index.php';
            }
        } else {
            $error = $result['message'];
            require __DIR__ . '/../views/books/index.php';
        }
    }
}