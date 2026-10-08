<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>
</head>
<body>
    <h1>Staff Login</h1>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <form action="<?= site_url('login') ?>" method="post">
        <?= csrf_field() ?>

        <label for="username">Username</label>
        <input id="username" name="username" required>

        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>

        <button type="submit">Log in</button>
    </form>
</body>
</html>