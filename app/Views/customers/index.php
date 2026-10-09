<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="container">
    <h1>Customers</h1>

 

    <?php if (session()->getFlashdata('message')): ?>
        <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p><a href="<?= site_url('customers/new') ?>">Add customer</a></p>

    <table border="1" cellpadding="8">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= esc($customer['full_name']) ?></td>
                <td><?= esc($customer['email']) ?></td>
                <td><?= esc($customer['phone'] ?? '') ?></td>
                <td>
                    <a href="<?= site_url('customers/' . $customer['id'] . '/edit') ?>">Edit</a>

                    <form action="<?= site_url('customers/' . $customer['id'] . '/delete') ?>"
                        method="post" style="display: inline;">
                        <?= csrf_field() ?>
                        <button type="submit"
                                onclick="return confirm('Delete this customer?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <a href="<?= site_url('dashboard') ?>" class="back-button">
        ← Back to Dashboard
    </a>
    </div>
</body>
</html>