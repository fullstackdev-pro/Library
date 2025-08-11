<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<section class="h-full">
    <?php if (isAdmin()): ?>
        <form action="index.php?route=category/create" method="POST"
            class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center" enctype="multipart/form-data">
            <p class="text-2xl font-bold">Kategoriya qo'shish</p>
            <div>
                <label for="category_name">Kategoriya nomi:</label>
                <br>
                <input type="text" name="category_name" id="category_name" class="border-[1px] rounded mt-1 px-2 py-[1px]">
            </div>
            <button type="submit" class="border-[1px] rounded px-[4.68rem] py-[3px] cursor-pointer">Kitob
                qo'shish</button>
        </form>
    <?php else: ?>
        <?php requireAdmin() ?>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../layouts/footer.php' ?>