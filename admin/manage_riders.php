<?php include 'navbar.php'; ?>
<?php
include '../db_connect.php';

// Handle deletion of a rider
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM users WHERE id = '$delete_id' AND role = 'Rider'");
    header("Location: manage_riders.php"); // Redirect after deletion
}

// Handle updating a rider's details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_rider'])) {
    $rider_id = $_POST['rider_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $conn->query("UPDATE users SET name = '$name', phone = '$phone', address = '$address' WHERE id = '$rider_id' AND role = 'Rider'");
    header("Location: manage_riders.php"); // Redirect after update
}

// Fetch all riders
$riders = $conn->query("SELECT * FROM users WHERE role = 'Rider'");

// Fetch assigned orders with item names and status
$orders = $conn->query("
    SELECT o.id AS order_id, 
           o.customer_id, 
           u.name AS customer_name, 
           GROUP_CONCAT(li.name) AS item_names, 
           ra.status, 
           r.name AS rider_name
    FROM orders o
    LEFT JOIN users u ON o.customer_id = u.id
    LEFT JOIN order_items oi ON o.id = oi.order_id
    LEFT JOIN laundry_items li ON oi.laundry_item_id = li.id
    LEFT JOIN rider_assignments ra ON o.id = ra.order_id
    LEFT JOIN users r ON ra.rider_id = r.id
    GROUP BY o.id
");
?>

<link rel="stylesheet" href="admin.css">

<h2>Manage Riders</h2>

<div class="container">
    <table class="table">
        <tr><th>ID</th><th>Name</th><th>Phone</th><th>Address</th><th>Actions</th></tr>
        <?php while ($row = $riders->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
                <!-- Delete button -->
                <a href="?delete_id=<?php echo $row['id']; ?>" class="btn-danger">🗑 Remove</a>
                <!-- Update button -->
                <button class="btn-warning" onclick="openUpdateForm(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['phone']; ?>', '<?php echo $row['address']; ?>')">✎ Update</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Update Rider Form (Hidden by default) -->
<div id="updateForm" class="update-form">
    <h3>Update Rider Details</h3>
    <form method="post">
        <input type="hidden" name="rider_id" id="update-rider-id">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="update-name" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" id="update-phone" required>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="update-address" required>
        </div>
        <button type="submit" name="update_rider" class="btn-primary">Update Rider</button>
        <button type="button" class="btn-secondary" onclick="closeUpdateForm()">Cancel</button>
    </form>
</div>

<h2>Order Status</h2>
<div class="container">
    <table class="table">
        <tr><th>Order ID</th><th>Customer Name</th><th>Ordered Items</th><th>Assigned Rider</th><th>Status</th></tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['item_names']; ?></td>
            <td><?php echo $row['rider_name']; ?></td>
            <td><?php echo $row['status']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<script>
    // Function to open the update form and populate it with the rider's details
    function openUpdateForm(id, name, phone, address) {
        document.getElementById('update-rider-id').value = id;
        document.getElementById('update-name').value = name;
        document.getElementById('update-phone').value = phone;
        document.getElementById('update-address').value = address;
        document.getElementById('updateForm').style.display = 'block';
    }

    // Function to close the update form
    function closeUpdateForm() {
        document.getElementById('updateForm').style.display = 'none';
    }
</script>

<style>
    /* Basic Styling for the Update Form */
    .update-form {
        display: none;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .form-group input {
        padding: 10px;
        width: 100%;
        margin-bottom: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .btn-primary {
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-danger, .btn-warning, .btn-secondary {
        padding: 5px 10px;
        text-decoration: none;
        border-radius: 5px;
        color: white;
        cursor: pointer;
    }

    .btn-danger {
        background-color: #f44336; /* Red */
    }

    .btn-warning {
        background-color: #ff9800; /* Orange */
    }

    .btn-secondary {
        background-color: #ccc;
    }

    .table a {
        margin: 0 5px;
    }
</style>
