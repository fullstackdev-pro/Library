<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<section class="h-full">
    <?php if (isAdmin()): ?>
        <div>
            <div class="text-right">
                <a href="index.php?route=category/create">Kategoriya qo'shish +</a>
            </div>
        </div>
        <?php if ($error): ?>
            <p><?= $error ?></p>
        <?php else: ?>
            <?php foreach ($categories as $category): ?>
                <p><?= htmlspecialchars($category['name']) ?></p>

                <!-- Edit form -->
                <form action="index.php?route=category/edit" method="post">
                    <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                    <button type="submit">Tahrirlash</button>
                </form>

                <!-- Delete form -->
                <form action="index.php?route=category/delete" method="post"
                    onsubmit="return confirm('Rostdan ham o\'chirishni hohlaysizmi?');">
                    <input type="hidden" name="id" value="<?= (int) $category['id'] ?>">
                    <button type="submit" style="background-color: red; color: white;">O‘chirish</button>
                </form>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php else: ?>
        <?php requireAdmin() ?>
    <?php endif; ?>
</section>
<form action="" method="get"></form>
<?php include __DIR__ . '/../layouts/footer.php' ?>