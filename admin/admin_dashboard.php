<?php include 'navbar.php'; ?>
<?php include '../db_connect.php'; ?>

<?php
// Fetch total earnings
$sql_earnings = "SELECT SUM(total_price) AS total_earnings FROM orders";
$result_earnings = $conn->query($sql_earnings);
$total_earnings = 0;
if ($result_earnings->num_rows > 0) {
    $row = $result_earnings->fetch_assoc();
    $total_earnings = $row['total_earnings'];
}

// Fetch total orders
$sql_orders = "SELECT COUNT(*) AS total_orders FROM orders";
$result_orders = $conn->query($sql_orders);
$total_orders = 0;
if ($result_orders->num_rows > 0) {
    $row = $result_orders->fetch_assoc();
    $total_orders = $row['total_orders'];
}

// Fetch total customers
$sql_customers = "SELECT COUNT(*) AS total_customers FROM users WHERE role = 'Customer'";
$result_customers = $conn->query($sql_customers);
$total_customers = 0;
if ($result_customers->num_rows > 0) {
    $row = $result_customers->fetch_assoc();
    $total_customers = $row['total_customers'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-card">
            <i class="fas fa-dollar-sign"></i>
            <h3>Total Earnings</h3>
            <p>৳ <?php echo number_format($total_earnings, 2); ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-shopping-bag"></i>
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>
        <div class="dashboard-card">
            <i class="fas fa-users"></i>
            <h3>Total Customers</h3>
            <p><?php echo $total_customers; ?></p>
        </div>
    </div>

    <!-- <div class="admin-sections">
        <div class="section-card">
            <a href="manage_items.php">
                <i class="fas fa-tshirt"></i>
                <h4>Manage Items</h4>
            </a>
        </div>
        <div class="section-card">
            <a href="manage_locations.php">
                <i class="fas fa-map-marker-alt"></i>
                <h4>Manage Locations</h4>
            </a>
        </div>
        <div class="section-card">
            <a href="manage_orders.php">
                <i class="fas fa-clipboard-list"></i>
                <h4>Manage Orders</h4>
            </a>
        </div>
        <div class="section-card">
            <a href="manage_riders.php">
                <i class="fas fa-motorcycle"></i>
                <h4>Manage Riders</h4>
            </a>
        </div>
        <div class="section-card">
            <a href="manage_transactions.php">
                <i class="fas fa-receipt"></i>
                <h4>Manage Transactions</h4>
            </a>
        </div>
    </div> -->
</body>
</html> 

<style>
    .dashboard-container {
        display: flex;
        justify-content: space-around;
        padding: 20px;
    }
    
    .dashboard-card {
        background: white;
        padding: 20px;
        text-align: center;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        width: 30%;
    }
    
    .dashboard-card i {
        font-size: 40px;
        color: #007bff;
    }
    
    .admin-sections {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        padding: 20px;
    }
    
    .section-card {
        width: 18%;
        text-align: center;
        background: white;
        padding: 15px;
        margin: 10px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    
    .section-card a {
        text-decoration: none;
        color: black;
        display: block;
    }
    
    .section-card i {
        font-size: 35px;
        color: #007bff;
    }
</style>
