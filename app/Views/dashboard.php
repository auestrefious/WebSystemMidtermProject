
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>POS Dashboard</title>

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<div class="container dashboard-container">

    <div class="dashboard-header">
        <div>
            <p class="dashboard-label">POINT OF SALE SYSTEM</p>
            <h1>Dashboard</h1>
            <p class="welcome-text">
                Welcome back,
                <strong><?= esc(session()->get('staff_name')) ?></strong>!
            </p>
        </div>

        <form
            action="<?= site_url('logout') ?>"
            method="post"
            class="logout-form"
        >
            <?= csrf_field() ?>
            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>
    </div>

    <hr>

    <h2>Management Sections</h2>

    <div class="dashboard-grid">

        <!-- Staff Management -->
        <a href="<?= site_url('users') ?>" class="dashboard-card staff-card">
            <br>
            <h3>Staff Management</h3>
            <p>Add, edit, delete, and manage staff accounts.</p>
            <br>
            <br>
            <br>
            <span>Manage Staff →</span>
        </a>

        <!-- Customer Management -->
        <a href="<?= site_url('customers') ?>" class="dashboard-card customer-card">
            <br>
            <h3>Customer Management</h3>
            <p>View and manage customer records.</p>
            <br>
            <br>
            <br>
            <span>Manage Customers →</span>
        </a>

        <!-- Product Management -->
        <a href="<?= site_url('products') ?>" class="dashboard-card product-card">
            <br>
            <h3>Product Management</h3>
            <p>Add, edit, archive, and manage products.</p>
            <br>
            <br>
            <br>
            <span>Manage Products →</span>
        </a>

        <!-- Record Sale -->
        <a href="<?= site_url('sales/record') ?>" class="dashboard-card sales-card">
            <br>
            <h3>Record Sale</h3>
            <p>Process customer purchases and automatically update product inventory.</p>
            <br>
            <br>
            <br>
            <span>Record New Sale →</span>
        </a>

        <!-- Sales History -->
        <a href="<?= site_url('sales/history') ?>" class="dashboard-card history-card">
            <br>
            <h3>Sales History</h3>
            <p>View past transactions, sold products, quantities, and total sales.</p>
            <br>
            <br>
            <br>
            <span>View Sales History →</span>
        </a>

    </div>

</div>

</body>
</html>
