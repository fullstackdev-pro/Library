<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if (isAdmin()): ?>
    <form action="index.php?route=book/update" method="POST"
        class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center" enctype="multipart/form-data">
        <p class="text-2xl font-bold">Kitob tahrirlash</p>

        <!-- Book name(title) -->
        <div>
            <label for="title">Kitob nomi:</label>
            <br>
            <input type="text" name="title" id="title" class="border-[1px] rounded mt-1 px-[0.9rem] py-[1px]"
                value="<?= htmlspecialchars($book['title']) ?>">
        </div>

        <!-- Book author -->
        <div>
            <label for="author">Muallif:</label>
            <br>
            <input type="text" name="author" id="author" class="border-[1px] rounded mt-1 px-[0.9rem] py-[1px]"
                value="<?= htmlspecialchars($book['author']) ?>">
        </div>

        <!-- Book category -->
        <div class="w-[262px]">
            <label for="category_id" class="">Kategoriya:</label>
            <br>
            <div class="w-full text-right mt-1">
                <?php if (empty($categories)): ?>
                    <p>Kategoriya topilmadi</p>
                <?php else: ?>
                    <select name="category_id" id="category_id" class="w-full cursor-pointer">
                        <?php foreach ($categories as $category): ?>
                            <!-- Option with logic which category selected default -->
                            <option value="<?= $category['id'] ?>" <?= ($book['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php endif ?>
            </div>
        </div>

        <!-- Book description -->
        <div>
            <label for="description">Kitob haqida:</label>
            <br>
            <textarea class="w-full h-32 px-[1.85rem] border rounded" name="description" id="description">
                                                                <?= htmlspecialchars($book['description']) ?>    
                                                                </textarea>
        </div>

        <!-- Book available -->
        <div class="w-[262px]">
            <label for="available">Mavjudmi:</label>
            <br>
            <div class="w-full text-right mt-1">
                <select name="available" id="available" class="cursor-pointer"
                    value="<?= htmlspecialchars($book['available']) ?>">
                    <option value="true">
                        Bor
                    </option>
                    <option value="false">
                        Yo'q
                    </option>
                </select>
            </div>
        </div>

        <!-- Book image -->
        <div class="w-[262px]">
            <label>Kitob surati:</label>
            <br>
            <div class="text-right">
                <label for="photo" class="cursor-pointer">Surat tanlash</label>
            </div>
            <br>
            <input id="photo" name="photo" type="file" class="hidden">
        </div>

        <!-- Old photo name for know changed image -->
        <input id="oldPhoto" name="oldPhoto" class="hidden" value="<?= htmlspecialchars($book['image']) ?>">

        <!-- Book id for get all book information -->
        <input id="id" name="id" class="hidden" value="<?= htmlspecialchars($book['id']) ?>">

        <!-- Submit button -->
        <button type="submit" class="border-[1px] rounded px-[4.5rem] py-[3px] cursor-pointer">Kitob
            tahrirlash</button>
    </form>
<?php else: ?>
    <?php requireAdmin() ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>