<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Staff Member</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

    <h1>Edit Staff Member</h1>

    <?php if (session()->getFlashdata('errors')): ?>
        <div style="color: red;">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($user['avatar'])): ?>
        <p>Current Avatar:</p>

        <img
            src="<?= base_url('uploads/avatars/' . esc($user['avatar'])) ?>"
            width="100"
            height="100"
            style="object-fit: cover; border-radius: 50%;"
        >
    <?php else: ?>
        <p>No avatar uploaded.</p>
    <?php endif; ?>

    <form
        action="<?= site_url('users/' . $user['id'] . '/update') ?>"
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
                value="<?= old('username', $user['username']) ?>"
                required
            >
        </p>

        <p>
            <label for="full_name">Full Name</label><br>
            <input
                type="text"
                id="full_name"
                name="full_name"
                value="<?= old('full_name', $user['full_name']) ?>"
                required
            >
        </p>

        <p>
            <label for="password">
                New Password
            </label><br>

            <input
                type="password"
                id="password"
                name="password"
            >

            <br>
            <small>
                Leave blank if you do not want to change the password.
            </small>
        </p>

        <p>
            <label for="avatar">Replace Avatar</label><br>
            <input
                type="file"
                id="avatar"
                name="avatar"
                accept="image/png,image/jpeg"
            >
        </p>

        <button type="submit">Update Staff Member</button>
        <a href="<?= site_url('users') ?>">Cancel</a>
    </form>

</body>
</html>