<?php include __DIR__ . '/../layouts/header.php' ?>
<?php $token = generateCsrfToken() ?>


<?php if (isAdmin()): ?>
    <form action="index.php?route=book/create" method="POST"
        class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($token) ?>">
        <p class="text-2xl font-bold">Kitob qo'shish</p>
        <div>
            <label for="title">Kitob nomi:</label>
            <br>
            <input type="text" name="title" id="title" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <div>
            <label for="author">Muallif:</label>
            <br>
            <input type="text" name="author" id="author" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <div class="w-[250px]">
            <label for="category_id" class="">Kategoriya:</label>
            <br>
            <div class="w-full text-right mt-1">
                <?php if (empty($categories)): ?>
                    <p>Kategoriya topilmadi</p>
                <?php else: ?>
                    <select name="category_id" id="category_id" class="w-full cursor-pointer">
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>">
                                <?= htmlspecialchars($category['name'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif ?>
            </div>
        </div>
        <div>
            <label for="description">Kitob haqida:</label>
            <br>
            <input type="text" name="description" id="description" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <div class="w-[250px]">
            <label for="available">Mavjudmi:</label>
            <br>
            <div class="w-full text-right mt-1">
                <select name="available" id="available" class="cursor-pointer">
                    <option value="true">
                        Bor
                    </option>
                    <option value="false">
                        Yo'q
                    </option>
                </select>
            </div>
        </div>
        <div class="w-[250px]">
            <label>Kitob surati:</label>
            <br>
            <div class="text-right">
                <label for="photo" class="cursor-pointer">Surat tanlash</label>
            </div>
            <br>
            <input id="photo" name="photo" type="file" class="hidden">
        </div>
        <button type="submit" class="border-[1px] rounded px-[4.68rem] py-[3px] cursor-pointer">Kitob
            qo'shish</button>
    </form>
<?php else: ?>
    <?php requireAdmin() ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>