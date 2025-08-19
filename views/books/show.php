<?php include __DIR__ . '/../layouts/header.php' ?>
<?php $token = generateCsrfToken() ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <!-- <?= var_dump($book) ?> -->

    <div class="mt-4">
        <?php if (isAdmin()): ?>
            <div class="flex justify-end">
                <form method="POST" action="index.php?route=book/edit">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                    <input type="hidden" name="id" id="id" value="<?= (int) $book['id'] ?>">
                    <button type=" submit" class="cursor-pointer">Tahrirlash</button>
                </form>
                <form method="POST" action="index.php?route=book/delete" class="ml-4"
                    onsubmit="return confirm('Rostdan ham o\'chirishni hohlaysizmi?');">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                    <input type="hidden" name="id" id="id" value="<?= (int) $book['id'] ?>">
                    <button type="submit" class="cursor-pointer">O'chirish</button>
                </form>
            </div>
        <?php elseif (isAuthenticated()): ?>
            <form class="text-right " action="index.php?route=reservation/create" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
                <input type="hidden" name="book_id" id="book_id" value="<?= (int) $book['id'] ?>">
                <button type="submit" class="cursor-pointer">Bron qilish</button>
            </form>
        <?php endif; ?>
        <img src="/images/<?= htmlspecialchars($book['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Book image"
            class="w-full md:w-[50%] lg:w-[30%] p-4 md:float-left">

        <p class="text-xl font-bold text-center">
            <?= htmlspecialchars($book['title'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <p class="text-lg font-medium mt-1  ">
            Muallif: <?= htmlspecialchars($book['author'], ENT_QUOTES, 'UTF-8') ?>
        </p>
        <p class="mt-3">
            <?= htmlspecialchars($book['description'], ENT_QUOTES, 'UTF-8') ?>
        </p>

    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>