<?php include 'navbar.php'; ?>
<?php
include '../db_connect.php'; 

// Handle form submission to add a new item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $conn->query("INSERT INTO laundry_items (name, price) VALUES ('$name', '$price')");
}

// Handle deletion of an item
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM laundry_items WHERE id = '$delete_id'");
    header("Location: manage_items.php"); // Redirect to avoid re-submit on refresh
}

// Handle updating an item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_item'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];

    $conn->query("UPDATE laundry_items SET name = '$name', price = '$price' WHERE id = '$id'");
    header("Location: manage_items.php"); // Redirect after update
}

// Fetch items sorted by name in alphabetical order
$items = $conn->query("SELECT * FROM laundry_items ORDER BY name ASC");
?>

<link rel="stylesheet" href="admin.css">

<h2>Manage Laundry Items</h2>

<div class="container">
    <!-- Add Item Form -->
    <form method="post">
        <div class="form-group">
            <input type="text" name="name" placeholder="Item Name" required>
        </div>
        <div class="form-group">
            <input type="number" name="price" placeholder="Price" required>
        </div>
        <button type="submit" name="add_item" class="btn-primary">Add Item</button>
    </form>

    <h3>Item List</h3>
    <table class="table">
        <tr><th>Name</th><th>Price</th><th>Action</th><th>Update</th></tr>
        <?php while ($row = $items->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td>৳ <?php echo $row['price']; ?></td>
            <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn-danger">🗑 Delete</a></td>
            <td>
                <button class="btn-warning" onclick="openUpdateForm(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">✎ Update</button>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<!-- Update Item Form (Hidden by default) -->
<div id="updateForm" class="update-form">
    <h3>Update Item</h3>
    <form method="post">
        <div class="form-group">
            <input type="hidden" name="id" id="update-id">
            <input type="text" name="name" id="update-name" placeholder="Item Name" required>
        </div>
        <div class="form-group">
            <input type="number" name="price" id="update-price" placeholder="Price" required>
        </div>
        <button type="submit" name="update_item" class="btn-primary">Update Item</button>
        <button type="button" class="btn-secondary" onclick="closeUpdateForm()">Cancel</button>
    </form>
</div>

<script>
    // Function to open the update form and populate it with the item's details
    function openUpdateForm(id, name, price) {
        document.getElementById('update-id').value = id;
        document.getElementById('update-name').value = name;
        document.getElementById('update-price').value = price;
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
