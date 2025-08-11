<?php include __DIR__ . '../../layouts/header.php' ?>

<div class="h-full">
    <?php if ($error): ?>
        <p>
            <?php echo $error ?>
        </p>
    <?php endif; ?>
    <form action="index.php?route=user/register" method="POST"
        class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center">
        <p class="text-2xl font-bold">Ro'yxatdan o'tish</p>
        <div>
            <label for="username">Username:</label>
            <br>
            <input type="text" name="username" id="username" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <div>
            <label for="email">Email:</label>
            <br>
            <input type="email" name="email" id="email" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <div>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password" class="border-[1px] rounded mt-1 px-2 py-[1px]">
        </div>
        <button type="submit"
            class="border-[1px] rounded px-[4.68rem] mt-4 py-[3px] cursor-pointer">Registratsiya</button>
    </form>
</div>

<?php include __DIR__ . '../../layouts/footer.php' ?>