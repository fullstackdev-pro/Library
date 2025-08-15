<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <!-- <?= var_dump($book) ?> -->
    <div class="mt-4">
        <img src="/images/<?= htmlspecialchars($book['image']) ?>" alt="Book image"
            class="w-full md:w-[50%] lg:w-[30%] p-4 md:float-left">

        <p class="text-xl font-bold">
            <?= htmlspecialchars($book['title']) ?>
        </p>
        <p class="text-lg font-medium mt-1  ">
            Muallif: <?= htmlspecialchars($book['author']) ?>
        </p>
        <p class="mt-3">
            <?= htmlspecialchars($book['description']) ?>
        </p>

    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>