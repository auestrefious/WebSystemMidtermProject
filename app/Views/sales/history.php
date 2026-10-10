<?php
/** @var array $sales */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History - POS System</title>
</head>
<body>

<h1>Sales History</h1>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Sale ID</th>
            <th>Product</th>
            <th>Customer</th>
            <th>Staff Member</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Date</th>
        </tr>
    </thead>

    <tbody>
        <?php if (empty($sales)): ?>
            <tr>
                <td colspan="7">No sales recorded yet.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($sales as $sale): ?>
                <tr>
                    <td><?= esc($sale['id']) ?></td>

                    <td>
                        <?= esc($sale['product_name']) ?>
                    </td>

                    <td>
                        <?= esc($sale['customer_name'] ?? 'Walk-in Customer') ?>
                    </td>

                    <td>
                        <?= esc($sale['staff_name']) ?>
                    </td>

                    <td>
                        <?= esc($sale['quantity']) ?>
                    </td>

                    <td>
                        PHP <?= number_format($sale['total_price'], 2) ?>
                    </td>

                    <td>
                        <?= esc($sale['created_at']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<br>

<a href="<?= site_url('sales/record') ?>">
    Record Another Sale
</a>

<br><br>

<a href="<?= site_url('dashboard') ?>">
    Back to Dashboard
</a>

</body>
</html>
