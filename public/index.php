<?php
session_start();

include_once __DIR__ . '/../controllers/BookController.php';
include_once __DIR__ . '/../controllers/CategoryController.php';
include_once __DIR__ . '/../controllers/ReservationController.php';
include_once __DIR__ . '/../controllers/UserController.php';

$controller = $_GET['route'] ?? 'book/index';

list($controllerName, $action) = explode('/', $controller);
// var_dump($controllerName, $action);

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
    } elseif ($action == 'show') {
        $books->show();
    } elseif ($action == 'create') {
        $books->create();
    }
} elseif ($controllerName == 'category') {
    $categories = new CategoryController();
    if ($action == 'index') {
        $categories->index();
    }
}
