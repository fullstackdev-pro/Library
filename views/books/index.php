<?php include __DIR__ . '/../layouts/header.php' ?>

<?php if ($error): ?>
    <p><?= $error ?></p>
<?php else: ?>
    <?php foreach ($books as $book): ?>
        <div style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 5px;">
            <img src="/uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="Book Image">
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p>Author: <?= htmlspecialchars($book['author']) ?></p>
            <p class="line-clamp-3 overflow-hidden text-ellipsis"><?= htmlspecialchars($book['description']) ?></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>