<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>POS Dashboard</title>
</head>
<body>
    <h1>Welcome, <?= esc(session()->get('staff_name')) ?>!</h1>

    <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit">Log out</button>
    </form>
</body>
</html>