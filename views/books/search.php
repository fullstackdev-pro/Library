<?php include __DIR__ . '/../layouts/header.php' ?>
<?php $token = generateCsrfToken() ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 3xl:grid-cols-5 gap-4">
        <?php foreach ($searchResult as $search): ?>
            <form action="index.php?route=book/show" method="POST"
                style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 5px">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">

                <input type="hidden" name="id" value="<?= (int) $search['id'] ?>">
                <button type="submit" class="text-left cursor-pointer">
                    <img class="w-full" src="/images/<?php echo htmlspecialchars($search['image'], ENT_QUOTES, 'UTF-8'); ?>"
                        alt="Book Image">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($search['title'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="text-lg font-medium">Muallif: <?= htmlspecialchars($search['author'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="line-clamp-3 overflow-hidden text-ellipsis">
                        <?= htmlspecialchars($search['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                </button>
            </form>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>