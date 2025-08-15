<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <title>Library</title>
</head>

<body class="relative h-screen mx-4">

    <header class="absolute top-0 h-12 w-full">
        <div class="flex justify-between items-center h-full text-lg">
            <div>
                <a href="index.php?route=book/index">Bosh sahifa</a>
            </div>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] == 'user'): ?>
                    <div>
                        <a href="index.php?route=reservation/index">Bronlar</a>
                        <a href="index.php?route=user/logout" class="ml-6">Tizimdan chiqish</a>
                    </div>
                <?php elseif ($_SESSION['role'] == 'admin'): ?>
                    <div>
                        <a href="index.php?route=book/create">Kitob qo'shish</a>
                        <a href="index.php?route=category/index" class="ml-6">Kategoriyalar</a>
                        <a href="index.php?route=user/logout" class="ml-6">Tizimdan chiqish</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div>
                    <a href="index.php?route=user/login">Login</a>
                    <a href="index.php?route=user/register" class="ml-6">Registratsiya</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="h-[calc(100%-6rem)] w-full absolute top-12 flex flex-col overflow-y-auto">
        <section class="h-full">