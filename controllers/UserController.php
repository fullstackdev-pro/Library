<?php
session_start();
include_once __DIR__ . '/../models/UserModel.php';

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_name = htmlspecialchars($_POST['username']) ?? '';
            $email = htmlspecialchars($_POST['email']) ?? '';
            $password = htmlspecialchars($_POST['password']) ?? '';

            if (empty($user_name) || empty($email) || empty($password)) {
                $error = "Barcha ma'lumotlar bo'lishi kerak";
                require __DIR__ . '/../views/users/register.php';
                return;
            }

            $result = $this->userModel->register($user_name, $email, $password);
            if ($result['success']) {
                header('Location: index.php?route=user/login');
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/users/register.php';
            }
        } else {
            require __DIR__ . '/../views/users/register.php';
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD' == 'POST']) {
            $email = htmlspecialchars($_POST['email']) ?? '';
            $password = htmlspecialchars($_POST['password']) ?? '';

            if (empty($email) || empty($password)) {
                $error = "Barcha ma'lumotlar bo'lishi kerak";
                require __DIR__ . '/../views/users/login.php';
                return;
            }

            $result = $this->userModel->login($email, $password);
            if ($result['success']) {
                $_SESSION['user_id'] = $result['result']['id'];
                $_SESSION['role'] = $result['result']['role'];
                header('Location: index.php?route=user/login');
                exit;
            } else {
                $error = $result['message'];
                require __DIR__ . '/../views/users/login.php';
            }
        } else {
            require __DIR__ . '/../views/users/login.php';
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?route=user/login");
        exit;
    }
}
