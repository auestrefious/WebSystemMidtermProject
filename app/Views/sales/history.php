
<?php
/** @var array $sales */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales History - POS System</title>

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<div class="container sales-container">

    <h1>Sales History</h1>

    <!-- Sales History Table -->
    <div class="sales-table-wrapper">
        <table class="sales-table">
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
                        <td colspan="7">
                            No sales recorded yet.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($sales as $sale): ?>
                        <tr>
                            <td>
                                <?= esc($sale['id']) ?>
                            </td>

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
    </div>

    <hr>

    <!-- Navigation -->
    <div class="sales-navigation">

        <a href="<?= site_url('sales/record') ?>">
            Record Another Sale
        </a>

        <a href="<?= site_url('dashboard') ?>">
            Back to Dashboard
        </a>

    </div>

</div>

</body>
</html>
