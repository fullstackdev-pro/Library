<?php include __DIR__ . '../../layouts/header.php' ?>

<div class="rounded h-full">
    <form action="index.php?route=user/register" method="POST"
        class="h-full grid grid-cols-1 gap-y-3 justify-items-center place-content-center">
        <p class="text-2xl font-bold">Tizimga kirish</p>
        <div>
            <label for="email">Email:</label>
            <br>
            <input type="email" name="email" id="email" class="border-[1px] rounded mt-1 px-2">
        </div>
        <div>
            <label for="password">Password:</label>
            <br>
            <input type="password" name="password" id="password" class="border-[1px] rounded mt-1 px-2">
        </div>
        <button type="submit"
            class="border-[1px] rounded px-[4.5rem] mt-4 py-[3px] cursor-pointer">Tizimga kirish</button>

    </form>
</div>

<?php include __DIR__ . '../../layouts/footer.php' ?>