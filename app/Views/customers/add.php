<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Customer</title>
</head>
<body>
    <h1>Add Customer</h1>

    <?php foreach (session()->getFlashdata('errors') ?? [] as $error): ?>
        <p style="color: red;"><?= esc($error) ?></p>
    <?php endforeach; ?>

    <form action="<?= site_url('customers') ?>" method="post">
        <?= csrf_field() ?>

        <label>Full name
            <input name="full_name" value="<?= esc(old('full_name')) ?>" required>
        </label><br>

        <label>Email
            <input name="email" type="email" value="<?= esc(old('email')) ?>" required>
        </label><br>

        <label>Phone
            <input name="phone" value="<?= esc(old('phone')) ?>">
        </label><br>

        <button type="submit">Save customer</button>
    </form>

    <p><a href="<?= site_url('customers') ?>">Back to customers</a></p>
</body>
</html>