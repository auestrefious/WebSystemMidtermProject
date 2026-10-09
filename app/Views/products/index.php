<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <div class="container">
    <h1>Products</h1>

    <?php if (session()->getFlashdata('message')): ?>
    <p><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif; ?>

    <p><a href="<?= site_url('products/new') ?>">Add product</a></p>

    <?php if (!$products): ?>
        <p>No products yet.</p>
    <?php else: ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($products as $product): ?>
                <tr>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
                                 alt="<?= esc($product['name']) ?>"
                                 width="80" height="80">
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>
                    <td><?= esc($product['name']) ?></td>
                    <td>₱<?= number_format((float) $product['price'], 2) ?></td>
                    <td><?= esc($product['stock_quantity']) ?></td>
                    <td>
                        <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>">Edit</a>

                        <form action="<?= site_url('products/' . $product['id'] . '/archive') ?>"
                            method="post" style="display: inline;">
                            <?= csrf_field() ?>
                            <button type="submit"
                                    onclick="return confirm('Archive this product?')">
                                Archive
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    <br>
    <a href="<?= site_url('dashboard') ?>" class="back-button">
        ← Back to Dashboard
    </a>
    </div>
</body>
</html>