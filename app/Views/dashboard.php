
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Dashboard</title>

    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="container dashboard-container">

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div>
            <p class="dashboard-label">POINT OF SALE SYSTEM</p>
            <h1>Dashboard</h1>
            <p class="welcome-text">
                Welcome back,
                <strong><?= esc(session()->get('staff_name')) ?></strong>!
            </p>
        </div>

        <form action="<?= site_url('logout') ?>"
              method="post"
              class="logout-form">
            <?= csrf_field() ?>
            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>
    </div>

    <!-- Management Sections -->
    <h2>Management Sections</h2>

    <div class="dashboard-grid">

        <a href="<?= site_url('users') ?>"
           class="dashboard-card staff-card">
            <h3>Staff Management</h3>
            <p>Add, edit, delete, and manage staff accounts.</p>
            <span>Manage Staff &rarr;</span>
        </a>

        <a href="<?= site_url('customers') ?>"
           class="dashboard-card customer-card">
            <h3>Customer Management</h3>
            <p>View and manage customer records.</p>
            <span>Manage Customers &rarr;</span>
        </a>

        <a href="<?= site_url('products') ?>"
           class="dashboard-card product-card">
            <h3>Product Management</h3>
            <p>Add, edit, archive, and manage products.</p>
            <span>Manage Products &rarr;</span>
        </a>

        <a href="<?= site_url('sales/record') ?>"
           class="dashboard-card sales-card">
            <h3>Record Sale</h3>
            <p>Process customer purchases and update product inventory.</p>
            <span>Record New Sale &rarr;</span>
        </a>

        <a href="<?= site_url('sales/history') ?>"
           class="dashboard-card history-card">
            <h3>Sales History</h3>
            <p>View past transactions, quantities, and total sales.</p>
            <span>View Sales History &rarr;</span>
        </a>

    </div>

</div>

</body>
</html>
