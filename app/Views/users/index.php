<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Management</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="container">

    <h1>Staff Management</h1>

    <p>
        Logged in as:
        <?= esc(session()->get('staff_name')) ?>
    </p>

    <a href="<?= site_url('dashboard') ?>">Dashboard</a> |
    <a href="<?= site_url('users/new') ?>">Add Staff Member</a>

    <form
        action="<?= site_url('logout') ?>"
        method="post"
        style="display: inline;"
    >
        <?= csrf_field() ?>
        <button type="submit">Logout</button>
    </form>

    <?php if (session()->getFlashdata('message')): ?>
        <p style="color: green;">
            <?= esc(session()->getFlashdata('message')) ?>
        </p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;">
            <?= esc(session()->getFlashdata('error')) ?>
        </p>
    <?php endif; ?>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>ID</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php if (!empty($user['avatar'])): ?>
                            <img
                                src="<?= base_url('uploads/avatars/' . esc($user['avatar'])) ?>"
                                width="70"
                                height="70"
                                style="object-fit: cover; border-radius: 50%;"
                            >
                        <?php else: ?>
                            No avatar
                        <?php endif; ?>
                    </td>

                    <td><?= esc($user['id']) ?></td>
                    <td><?= esc($user['username']) ?></td>
                    <td><?= esc($user['full_name']) ?></td>
                    <td><?= esc($user['created_at']) ?></td>

                    <td>
                        <a href="<?= site_url('users/' . $user['id'] . '/edit') ?>">
                            Edit
                        </a>

                        <form
                            action="<?= site_url('users/' . $user['id'] . '/delete') ?>"
                            method="post"
                            style="display: inline;"
                            onsubmit="return confirm('Delete this staff member?');"
                        >
                            <?= csrf_field() ?>
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <a href="<?= site_url('dashboard') ?>" class="back-button">
        ← Back to Dashboard
    </a>
    </div>
</body>
</html>