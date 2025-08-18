<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-4">
        <?php foreach ($searchResult as $search): ?>
            <form action="index.php?route=book/show" method="POST"
                style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 5px">
                <input type="hidden" name="id" value="<?= (int) $search['id'] ?>">
                <button type="submit" class="text-left cursor-pointer">
                    <img class="w-full" src="/images/<?php echo htmlspecialchars($search['image']); ?>" alt="Book Image">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($search['title']) ?></h2>
                    <p class="text-lg font-medium">Muallif: <?= htmlspecialchars($search['author']) ?></p>
                    <p class="line-clamp-3 overflow-hidden text-ellipsis"><?= htmlspecialchars($search['description']) ?></p>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>