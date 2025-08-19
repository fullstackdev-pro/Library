<?php

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
        $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
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
                $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
                $author = htmlspecialchars($_POST['author'], ENT_QUOTES, 'UTF-8');
                $category_id = htmlspecialchars((int) $_POST['category_id'], ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
                $available = (bool) htmlspecialchars($_POST['available'], ENT_QUOTES, 'UTF-8');

                $name = basename($_FILES["photo"]['name']);
                $tmp_name = $_FILES["photo"]['tmp_name'];
                $type = mime_content_type($_FILES["photo"]['tmp_name']);
                $size = $_FILES["photo"]['size'];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $imageName = uniqid('upload_', true) . '.' . $ext;

                $allowed_mimes = ['image/jpg', 'image/jpeg', 'image/png'];
                $allowed_extensions = ['jpg', 'jpeg', 'png'];
                $max_file_size = 4 * 1024 * 1024; // 2MB

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

    public function edit()
    {
        if (isAdmin()) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $result = $this->bookModel->show($id);
            $categories = $this->categoryModel->index()['result'];

            if ($result['success']) {
                if (empty($result['result'])) {
                    $error = "Bu kitob haqida batafsil ma'lumot topilmadi";
                    require __DIR__ . '/../views/books/edit.php';
                } else {
                    $book = $result['result'];
                    require __DIR__ . '/../views/books/edit.php';
                }
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/books/edit.php';
            }
        } else {
            header('Location: index.php?route=book/index');
        }
    }

    public function update()
    {
        if (isAdmin()) {
            $id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $result = $this->bookModel->show($id);

            if ($result['success']) {
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $id = (int) htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
                    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
                    $author = htmlspecialchars($_POST['author'], ENT_QUOTES, 'UTF-8');
                    $category_id = (int) htmlspecialchars($_POST['category_id'], ENT_QUOTES, 'UTF-8');
                    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');
                    $available = (bool) htmlspecialchars($_POST['available'], ENT_QUOTES, 'UTF-8');
                    $name = basename($_FILES["photo"]['name']);
                    $oldPhoto = htmlspecialchars($_POST['oldPhoto'], ENT_QUOTES, 'UTF-8');

                    // Surat o'zgartirilmasa
                    if (!$name) {
                        $book = $this->bookModel->edit($title, $author, $category_id, $description, $available, $oldPhoto, $id);

                        if ($book['success']) {
                            header('Location: index.php?route=book/index');
                            exit;
                        } else {
                            require __DIR__ . '/../views/books/create.php';
                        }
                    }
                    // Surat o'zgartirligan bo'lsa
                    else {
                        $tmp_name = $_FILES["photo"]['tmp_name'];
                        $type = mime_content_type($_FILES["photo"]['tmp_name']);
                        $size = $_FILES["photo"]['size'];
                        $ext = pathinfo($name, PATHINFO_EXTENSION);
                        $imageName = uniqid('upload_', true) . '.' . $ext;

                        $allowed_mimes = ['image/jpg', 'image/jpeg', 'image/png'];
                        $allowed_extensions = ['jpg', 'jpeg', 'png'];
                        $max_file_size = 4 * 1024 * 1024; // 4MB

                        // Rasmlar saqlanadigan papka (fizik yo'l bilan)
                        $uploadDir = __DIR__ . '/../public/images/';

                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0777, true);
                        }

                        if (in_array($ext, $allowed_extensions) && in_array($type, $allowed_mimes)) {
                            if ($size <= $max_file_size) {
                                if (is_uploaded_file($tmp_name)) {

                                    // ✅ Eski rasmni o‘chirish
                                    if (!empty($oldPhoto)) {
                                        $oldPath = $uploadDir . $oldPhoto;
                                        if (file_exists($oldPath)) {
                                            unlink($oldPath);
                                        }
                                    }

                                    if (move_uploaded_file($tmp_name, $uploadDir . $imageName)) {
                                        $book = $this->bookModel->edit(
                                            $title,
                                            $author,
                                            $category_id,
                                            $description,
                                            $available,
                                            $imageName,
                                            $id
                                        );

                                        if ($book['success']) {
                                            header('Location: index.php?route=book/index');
                                            exit;
                                        } else {
                                            require __DIR__ . '/../views/books/edit.php';
                                        }
                                    } else {
                                        $error = "❌ Faylni ko‘chirishda xatolik!";
                                        exit();
                                    }
                                } else {
                                    $error = "Fayl yuklanmadi!";
                                    exit();
                                }
                            } else {
                                $error = "Fayl hajmi 2MB dan oshmasligi kerak.";
                                exit();
                            }
                        } else {
                            $error = "Fayl turi ruxsat etilmagan.";
                            exit();
                        }

                    }
                } else {
                    $book = $result['result'];
                    require __DIR__ . '/../views/books/edit.php';
                }
            } else {
                $error = "Bu kitob haqida batafsil ma'lumot topilmadi";
                require __DIR__ . '/../views/books/show.php';
            }
        } else {
            header('Location: index.php?route=book/index');
        }
    }

    public function delete()
    {
        if (isAdmin()) {
            $id = (int) htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
            $result = $this->bookModel->delete($id);

            if ($result['success']) {
                header('Location: index.php?route=book/index');
                exit;
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/books/show.php';
            }
        } else {
            header('Location: index.php?route=book/index');
        }
    }

    public function search()
    {
        try {
            $search = htmlspecialchars($_POST['search'], ENT_QUOTES, 'UTF-8');

            if (empty($search)) {
                $error = 'Qidiruv so\'zi bo\'lishi kerak';
                return ['success' => false, 'message' => $error];
            }

            $result = $this->bookModel->search($search);

            if ($result['success']) {
                $searchResult = $result['result'];
                require __DIR__ . '/../views/books/search.php';
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/books/search.php';
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e];
        }
    }
}