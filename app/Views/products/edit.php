<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
    <h1>Edit Product</h1>

    <?php foreach (session()->getFlashdata('errors') ?? [] as $error): ?>
        <p style="color: red;"><?= esc($error) ?></p>
    <?php endforeach; ?>

    <?php if ($product['image']): ?>
        <p>Current image:</p>
        <img src="<?= base_url('uploads/products/' . $product['image']) ?>"
             alt="<?= esc($product['name']) ?>" width="120" height="120">
    <?php endif; ?>

    <form action="<?= site_url('products/' . $product['id'] . '/update') ?>"
          method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Name
            <input name="name" maxlength="100"
                   value="<?= old('name', $product['name']) ?>" required>
        </label><br>

        <label>Price
            <input name="price" type="number" min="0" step="0.01"
                   value="<?= old('price', $product['price']) ?>" required>
        </label><br>

        <label>Stock quantity
            <input name="stock_quantity" type="number" min="0" step="1"
                   value="<?= old('stock_quantity', $product['stock_quantity']) ?>"
                   required>
        </label><br>

        <label>Replace image (optional)
            <input name="image" type="file" accept="image/jpeg,image/png">
        </label><br>

        <button type="submit">Save changes</button>
    </form>

    <p><a href="<?= site_url('products') ?>">Back to products</a></p>
</body>
</html>