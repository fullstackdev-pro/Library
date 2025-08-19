<?php
error_reporting(E_ALL);
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

session_start();

include_once __DIR__ . '/../controllers/BookController.php';
include_once __DIR__ . '/../controllers/CategoryController.php';
include_once __DIR__ . '/../controllers/ReservationController.php';
include_once __DIR__ . '/../controllers/UserController.php';

// route parametrlari (?route=book/index)
$controller = $_GET['route'] ?? 'book/index';

// Marshrutlarni belgilaymiz
$routes = [
    // Book routes
    'book/index' => [BookController::class, 'index'],
    'book/create' => [BookController::class, 'create'],
    'book/show' => [BookController::class, 'show'],
    'book/edit' => [BookController::class, 'edit'],
    'book/update' => [BookController::class, 'update'],
    'book/delete' => [BookController::class, 'delete'],
    'book/search' => [BookController::class, 'search'],

    // Category routes
    'category/index' => [CategoryController::class, 'index'],
    'category/create' => [CategoryController::class, 'create'],
    'category/edit' => [CategoryController::class, 'edit'],
    'category/update' => [CategoryController::class, 'update'],

    // User routes
    'user/register' => [UserController::class, 'register'],
    'user/login' => [UserController::class, 'login'],
    'user/logout' => [UserController::class, 'logout'],

    // Reservation routes (keyin to‘ldirasiz)
    'reservation/index' => [ReservationController::class, 'index'],
    'reservation/create' => [ReservationController::class, 'create'],
];

// Router ishlashi
if (isset($routes[$controller])) {
    [$class, $method] = $routes[$controller];

    if (class_exists($class) && method_exists($class, $method)) {
        (new $class())->$method();
    } else {
        http_response_code(500);
        echo "Xato: {$class} yoki metod {$method} topilmadi!";
    }
} else {
    http_response_code(404);
    echo "Sahifa topilmadi!";
}
