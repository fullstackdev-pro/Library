<?php include __DIR__ . '/../layouts/header.php' ?>
<?php require_once __DIR__ . '/../../middlewares/auth.php' ?>

<?php if (isAuthenticated()): ?>
    <?php if ($error): ?>
        <p><?= $error ?></p>
    <?php endif; ?>
<?php else: ?>
    <?php requireUser() ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php' ?>