<?php
session_start();

include_once __DIR__ . '/../controllers/BookController.php';
include_once __DIR__ . '/../controllers/CategoryController.php';
include_once __DIR__ . '/../controllers/ReservationController.php';
include_once __DIR__ . '/../controllers/UserController.php';

$controller = $_GET['route'] ?? 'book/index';

list($controllerName, $action) = explode('/', $controller);

if ($controllerName == 'user') {
    $user = new UserController();
    if ($action == 'register') {
        $user->register();
    } elseif ($action == 'login') {
        $user->login();
    } elseif ($action == 'logout') {
        $user->logout();
    }
} elseif ($controllerName == 'book') {
    $books = new BookController();
    if ($action == 'index') {
        $books->index();
    } elseif ($action == 'create') {
        $books->create();
    } elseif ($action == 'show') {
        $books->show();
    }
} elseif ($controllerName == 'category') {
    $categories = new CategoryController();
    if ($action == 'index') {
        $categories->index();
    } elseif ($action == 'create') {
        $categories->create();
    } elseif ($action == 'edit') {
        $categories->edit();
    } elseif ($action == 'update' && isset($_GET['id'])) {
        $categories->update($_GET['id']);
    }
}
