<?php
session_start();

function isAuthenticated()
{
    return $_SESSION['user_id'];
}

function isAdmin()
{
    return $_SESSION['user_id'] && $_SESSION['role'] == 'admin';
}

function requireUser()
{
    if (!isAuthenticated()) {
        echo "Tizimga kirishingiz kerak <br/>";
        echo "<a href='index.php?route=user/login'>Tizimga kirish<a/>";
        exit;
    }
}

function requireAdmin()
{
    if (!isAdmin()) {
        echo 'Faqat adminlarga ruxsat bor';
        exit;
    }
}