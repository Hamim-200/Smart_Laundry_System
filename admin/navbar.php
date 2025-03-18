<nav class="navbar">
    <div class="logo">
        <h2>Laundry Management System</h2>
    </div>
    <div class="nav-links">
        <a href="admin_dashboard.php"><i class="fas fa-home"></i> Home</a>
        <a href="manage_items.php"><i class="fas fa-tshirt"></i> Laundry Items</a>
        <a href="manage_locations.php"><i class="fas fa-map-marker-alt"></i> Locations</a>
        <a href="manage_orders.php"><i class="fas fa-shopping-bag"></i> Orders</a>
        <a href="manage_riders.php"><i class="fas fa-motorcycle"></i> Riders</a>
        <a href="manage_transactions.php"><i class="fas fa-dollar-sign"></i> Transactions</a>
        <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<style>
   
     .navbar {
        background: #007bff;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: white;
    }
    
    .navbar a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        font-size: 16px;
        margin: 0 5px;
    }
    
    .navbar a:hover {
        background: #343a40;
        border-radius: 5px;
    }
    
    .nav-links {
        display: flex;
    }

    .logout {
        background: red;
        border-radius: 5px;
    }
</style>