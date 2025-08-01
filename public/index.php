<?php
session_start();

include_once __DIR__ . '../../controllers/BookController.php';
include_once __DIR__ . '../../controllers/CategoryController.php';
include_once __DIR__ . '../../controllers/ReservationController.php';
include_once __DIR__ . '../../controllers/UserController.php';

$controller = $_GET['route'] ?? 'books/index';
list($controllerName, $action) = explode('/', $controller);
// var_dump($controllerName, $action);

if ($controllerName == 'users') {
    $user = new userController();
    if ($action == 'register') {
        $user->register();
    } elseif ($action == 'login') {
        $user->login();
    } elseif ($action == 'logout') {
        $user->logout();
    }
} elseif ($controller == 'books') {
    // $books = new bookController();
    // if ($action == 'index') {
    //     $books->index();
    // }
}
