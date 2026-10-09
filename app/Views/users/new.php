<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Staff Member</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <h1>Add Staff Member</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form
        action="<?= site_url('users') ?>"
        method="post"
        enctype="multipart/form-data"
    >
        <?= csrf_field() ?>

        <p>
            <label for="username">Username</label><br>
            <input
                type="text"
                id="username"
                name="username"
                value="<?= old('username') ?>"
                required
            >
        </p>

        <p>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= old('full_name') ?>"
                required
            >
        </p>

        <p>
            <label for="password">Password</label><br>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </p>

        <p>
            <label for="avatar">Avatar</label><br>
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/png,image/jpeg"
            >
        </p>

        <button type="submit">Save Staff Member</button>
        <a href="<?= site_url('users') ?>">Cancel</a>
    </form>

</body>
</html>