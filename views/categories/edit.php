<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if (isAdmin()): ?>
    <?php if ($error): ?>
        <p><?= $error ?></p>
    <?php else: ?>
        <form action="index.php?route=category/update&id=<?= $category['id'] ?>" method="POST"
            class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center" enctype="multipart/form-data">
            <p class="text-2xl font-bold">Kategoriya tahrirlash</p>
            <div>
                <label for="category_name">Kategoriya nomi:</label>
                <br>
                <input type="text" name="category_name" id="category_name" class="border-[1px] rounded mt-1 px-2 py-[1px]"
                    value="<?= $category['name'] ?>">
            </div>
            <button type="submit" class="border-[1px] rounded px-[2.78rem] py-[3px] cursor-pointer">Kategoriya
                tahrirlash</button>
        </form>
    <?php endif; ?>
<?php else: ?>
    <?php requireAdmin() ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>