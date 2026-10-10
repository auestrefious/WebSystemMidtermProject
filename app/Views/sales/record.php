<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Record Sale - POS System</title>
</head>
<body>

<h1>Record New Sale</h1>

<!-- Success Message -->
<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;">
        <?= esc(session()->getFlashdata('success')) ?>
    </p>
<?php endif; ?>

<!-- Error Message -->
<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;">
        <?= esc(session()->getFlashdata('error')) ?>
    </p>
<?php endif; ?>

<!-- Record Sale Form -->
<form action="<?= site_url('sales/store') ?>" method="post">

    <?= csrf_field() ?>

    <!-- Product Selection -->
    <label for="product_id">Select Product:</label>

    <select name="product_id" id="product_id" required>
        <option value="">-- Select Product --</option>

        <?php foreach ($products as $product): ?>
            <option value="<?= esc($product['id']) ?>">
                <?= esc($product['name']) ?>
                - PHP <?= number_format($product['price'], 2) ?>
                (Stock: <?= esc($product['stock_quantity']) ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <!-- Customer Selection -->
    <label for="customer_id">Select Customer:</label>

    <select name="customer_id" id="customer_id">
        <option value="">Walk-in Customer</option>

        <?php foreach ($customers as $customer): ?>
            <option value="<?= esc($customer['id']) ?>">
                <?= esc($customer['full_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br><br>

    <!-- Quantity -->
    <label for="quantity">Quantity:</label>

    <input
        type="number"
        name="quantity"
        id="quantity"
        min="1"
        value="1"
        required
    >

    <br><br>

    <!-- Submit Button -->
    <button type="submit">
        Record Sale
    </button>

</form>

<hr>

<!-- Navigation -->
<p>
    <a href="<?= site_url('dashboard') ?>">
        Back to Dashboard
    </a>
</p>

<p>
    <a href="<?= site_url('sales/history') ?>">
        View Sales History
    </a>
</p>

</body>
</html>
