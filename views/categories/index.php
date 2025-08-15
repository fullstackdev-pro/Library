<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if (isAdmin()): ?>
    <div>
        <div class="text-right text-lg">
            <a href="index.php?route=category/create">Kategoriya qo'shish <i class="bi bi-folder-plus"></i></a>
        </div>
    </div>
    <?php if ($error): ?>
        <p><?= $error ?></p>
    <?php else: ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-y-4">
            <?php foreach ($categories as $category): ?>
                <div class="mb-2">
                    <p class="text-2xl font-bold mb-1"><?= htmlspecialchars($category['name']) ?></p>
                    <div class="flex">
                        <!-- Edit form -->
                        <form action="index.php?route=category/edit" method="POST">
                            <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                            <button type="submit" class="rounded text-lg cursor-pointer">Tahrirlsh <i
                                    class="bi bi-pencil-square"></i></button>
                        </form>

                        <!-- Delete form -->
                        <form action="index.php?route=category/delete" method="POST"
                            onsubmit="return confirm('Rostdan ham o\'chirishni hohlaysizmi?');">
                            <input type="hidden" name="category_id" value="<?= (int) $category['id'] ?>">
                            <button type="submit" class="ml-4 px-2 rounded bg-red-500 text-white text-lg cursor-pointer">O‘chirish
                                <i class="bi bi-trash3-fill"></i></button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <?php requireAdmin() ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>