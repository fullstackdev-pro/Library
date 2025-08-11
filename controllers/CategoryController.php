<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (isAdmin()) {
            $result = $this->categoryModel->index();
            if ($result['success']) {
                if (!empty($result['result'])) {
                    $categories = $result['result'];
                    require __DIR__ . '/../views/categories/index.php';
                } else {
                    $error = 'Kategoriyalar topilmadi :(';
                    require __DIR__ . '/../views/categories/index.php';
                }
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/categories/index.php';
            }

        } else {
            header('Location: index.php?route=books/index');
            exit;
        }
    }

    public function create()
    {
        if (isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {

            } else {
                require __DIR__ . '/../views/categories/create.php';
            }
        } else {
            header('Location: index.php?route=books/index');
            exit;
        }
    }

    public function edit()
    {
        if (isAdmin()) {
            $id = $_POST['id'];
            $category = $this->categoryModel->getCategory($id);

            if ($category['success']) {
                $category = $category['result'];
                require __DIR__ . '/../views/categories/edit.php';
            } else {
                $error = $category['message'];
                require __DIR__ . '/../views/categories/edit.php';
            }
        } else {
            header('Location: index.php?route=books/index');
            exit;
        }
    }

    public function update($id)
    {
        if (isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == "POST" && $id) {
                $title = $_POST['title'];

                $result = $this->categoryModel->update($title, $id);
                if ($result['success']) {
                    header('Location: index.php?route=task/index');
                    exit;
                } else {
                    $error = "Kategoriyani o'zgartirib bo'lmadi!";
                    require __DIR__ . "/../views/categories/edit.php";
                }
            } else {
                require __DIR__ . '/../views/categories/edit.php';
            }
        } else {
            header('Location: index.php?route=books/index');
            exit;
        }
    }

    public function delete()
    {

    }
}