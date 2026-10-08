<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer</title>
</head>
<body>
    <h1>Edit Customer</h1>

    <?php foreach (session()->getFlashdata('errors') ?? [] as $error): ?>
        <p style="color: red;"><?= esc($error) ?></p>
    <?php endforeach; ?>

    <form action="<?= site_url('customers/' . $customer['id'] . '/update') ?>" method="post">
        <?= csrf_field() ?>

        <label>Full name
            <input name="full_name"
                   value="<?= old('full_name', $customer['full_name']) ?>"
                   required>
        </label><br>

        <label>Email
            <input name="email" type="email"
                   value="<?= old('email', $customer['email']) ?>"
                   required>
        </label><br>

        <label>Phone
            <input name="phone"
                   value="<?= old('phone', $customer['phone'] ?? '') ?>">
        </label><br>

        <button type="submit">Save changes</button>
    </form>

    <p><a href="<?= site_url('customers') ?>">Back to customers</a></p>
</body>
</html>