<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>
    <h1>Add Product</h1>

    <?php foreach (session()->getFlashdata('errors') ?? [] as $error): ?>
        <p style="color: red;"><?= esc($error) ?></p>
    <?php endforeach; ?>

    <form action="<?= site_url('products') ?>"
          method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <label>Name
            <input name="name" maxlength="100"
                   value="<?= old('name') ?>" required>
        </label><br>

        <label>Price
            <input name="price" type="number" min="0" step="0.01"
                   value="<?= old('price') ?>" required>
        </label><br>

        <label>Stock quantity
            <input name="stock_quantity" type="number" min="0" step="1"
                   value="<?= old('stock_quantity') ?>" required>
        </label><br>

        <label>Product image (JPG or PNG, up to 2 MB)
            <input name="image" type="file"
                   accept="image/jpeg,image/png" required>
        </label><br>

        <button type="submit">Save product</button>
    </form>

    <p><a href="<?= site_url('products') ?>">Back to products</a></p>
</body>
</html>