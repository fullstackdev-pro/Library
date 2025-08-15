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
            header('Location: index.php?route=book/index');
            exit;
        }
    }

    public function create()
    {
        if (isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $category_name = htmlspecialchars($_POST['category_name']);
                $result = $this->categoryModel->create($category_name);

                if ($result['success']) {
                    header('Location: index.php?route=category/index');
                    exit;
                } else {
                    $error = $result['message'];
                    require __DIR__ . '/../views/categories/create.php';
                }
            } else {
                require __DIR__ . '/../views/categories/create.php';
            }
        } else {
            header('Location: index.php?route=book/index');
            exit;
        }
    }

    public function edit()
    {
        if (isAdmin()) {
            $id = $_POST['id'];
            $category = $this->categoryModel->getCategory((int) $id);

            if ($category['success']) {
                $category = $category['result'][0];
                require __DIR__ . '/../views/categories/edit.php';
            } else {
                $error = $category['message'];
                require __DIR__ . '/../views/categories/edit.php';
            }
        } else {
            header('Location: index.php?route=book/index');
            exit;
        }
    }

    public function update($id)
    {
        if (isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == "POST" && $id) {
                $name = $_POST['category_name'];

                $result = $this->categoryModel->update($name, (int) $id);
                if ($result['success']) {
                    header('Location: index.php?route=category/index');
                    exit;
                } else {
                    $error = "Kategoriyani o'zgartirib bo'lmadi!";
                    require __DIR__ . "/../views/categories/edit.php";
                }
            } else {
                require __DIR__ . '/../views/categories/edit.php';
            }
        } else {
            header('Location: index.php?route=book/index');
            exit;
        }
    }

    public function delete()
    {
        if (isAdmin()) {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $id = $_POST['category_id'];

                $result = $this->categoryModel->delete((int) $id);
                if ($result['success']) {
                    header('Location: index.php?route=category/index');
                    exit;
                } else {
                    $error = "Kategoriyani o'chirib bo'lmadi!";
                    require __DIR__ . "/../views/categories/index.php";
                }
            } else {
                require __DIR__ . '/../views/categories/index.php';
            }
        } else {
            header('Location: index.php?route=book/index');
            exit;
        }
    }
}