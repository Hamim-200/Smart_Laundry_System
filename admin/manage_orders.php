<?php include 'navbar.php'; ?>
<?php
include '../db_connect.php';

// Handle deletion of an order
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM orders WHERE id = '$delete_id'");
    header("Location: manage_orders.php"); // Redirect after deletion
}

// Handle updating an order status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_order'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $conn->query("UPDATE orders SET status = '$status' WHERE id = '$order_id'");
    header("Location: manage_orders.php"); // Redirect after update
}

// Fetch orders with customer ids and names by joining orders, users, order_items, and laundry_items tables
$orders = $conn->query("SELECT 
                            orders.id AS order_id, 
                            orders.customer_id, 
                            orders.status, 
                            users.name AS customer_name, 
                            orders.deadline, 
                            GROUP_CONCAT(DISTINCT laundry_items.name ORDER BY laundry_items.name) AS order_items 
                        FROM orders 
                        JOIN users ON orders.customer_id = users.id
                        LEFT JOIN order_items ON orders.id = order_items.order_id
                        LEFT JOIN laundry_items ON order_items.laundry_item_id = laundry_items.id
                        GROUP BY orders.id");
?>

<link rel="stylesheet" href="admin.css">

<h2>Manage Orders</h2>

<div class="container">
    <table class="table">
        <tr><th>Order ID</th><th>Customer ID</th><th>Customer Name</th><th>Status</th><th>Order Items</th><th>Deadline</th><th>Actions</th></tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['customer_id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td>
                <span class="status-<?php echo strtolower($row['status']); ?>">
                    <?php echo $row['status']; ?>
                </span>
            </td>
            <td>
                <?php echo $row['order_items']; ?>
            </td>
            <td>
                <?php echo $row['deadline']; ?>
            </td>
            <td>
                <!-- Delete button -->
                <a href="?delete_id=<?php echo $row['order_id']; ?>" class="delete-btn">🗑 Delete</a>
                <!-- Update button -->
                <button class="btn-warning" onclick="openUpdateForm(<?php echo $row['order_id']; ?>, '<?php echo $row['status']; ?>')">✎ Update</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Update Order Form (Hidden by default) -->
<div id="updateForm" class="update-form">
    <h3>Update Order Status</h3>
    <form method="post">
        <input type="hidden" name="order_id" id="update-order-id">
        <div class="form-group">
            <label for="status">Order Status</label>
            <select name="status" id="update-status" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
                <option value="Canceled">Canceled</option>
            </select>
        </div>
        <button type="submit" name="update_order" class="btn-primary">Update Order</button>
        <button type="button" class="btn-secondary" onclick="closeUpdateForm()">Cancel</button>
    </form>
</div>

<script>
    // Function to open the update form and populate it with the order's details
    function openUpdateForm(id, status) {
        document.getElementById('update-order-id').value = id;
        document.getElementById('update-status').value = status;
        document.getElementById('updateForm').style.display = 'block';
    }

    // Function to close the update form
    function closeUpdateForm() {
        document.getElementById('updateForm').style.display = 'none';
    }
</script>
