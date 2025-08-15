<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-4">
        <?php foreach ($books as $book): ?>
            <form action="index.php?route=book/show" method="POST"
                style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 5px">
                <input type="hidden" name="id" value="<?= (int) $book['id'] ?>">
                <button type="submit" class="text-left cursor-pointer">
                    <img class="h-[15.7rem] w-full" src="/images/<?php echo htmlspecialchars($book['image']); ?>"
                        alt="Book Image">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($book['title']) ?></h2>
                    <p class="text-lg font-medium">Muallif: <?= htmlspecialchars($book['author']) ?></p>
                    <p class="line-clamp-3 overflow-hidden text-ellipsis"><?= htmlspecialchars($book['description']) ?></p>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>