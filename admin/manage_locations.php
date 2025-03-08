<?php 
include 'navbar.php'; 
include '../db_connect.php'; 

// Handle Add Location
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_location'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $conn->query("INSERT INTO laundry_locations (name, address, phone) VALUES ('$name', '$address', '$phone')");
}

// Handle Update Location
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_location'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $conn->query("UPDATE laundry_locations SET name = '$name', address = '$address', phone = '$phone' WHERE id = '$id'");
}

// Handle Delete Location
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $conn->query("DELETE FROM laundry_locations WHERE id = '$delete_id'");
    header("Location: manage_locations.php"); // Redirect after deletion
}

$locations = $conn->query("SELECT * FROM laundry_locations");
?>


<h2>Manage Laundry Locations</h2>
<link rel="stylesheet" href="admin.css">

<div class="container">

    <!-- Add Location Form -->
    <form method="post" class="form-container">
        <div class="form-group">
            <input type="text" name="name" placeholder="Laundry Name" required>
        </div>
        <div class="form-group">
            <input type="text" name="address" placeholder="Address" required>
        </div>
        <div class="form-group">
            <input type="text" name="phone" placeholder="Phone Number" required>
        </div>
        <button type="submit" name="add_location" class="btn-primary">Add Location</button>
    </form>

    <!-- Location List -->
    <h3>Location List</h3>
    <table class="table">
        <tr>
            <th>Laundry Name</th>
            <th>Address</th>
            <th>Phone Number</th>
            <th>Actions</th>
            <th>Update</th>
        </tr>
        <?php while ($row = $locations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['phone']; ?></td>
            <td><a href="?delete_id=<?php echo $row['id']; ?>" class="btn-danger">🗑 Delete</a></td>
            <td><button class="btn-warning" onclick="openUpdateForm(<?php echo $row['id']; ?>, '<?php echo $row['name']; ?>', '<?php echo $row['address']; ?>', '<?php echo $row['phone']; ?>')">✎ Update</button></td>
        </tr>
        <?php } ?>
    </table>

    <!-- Update Location Form (Hidden by default) -->
    <div id="updateForm" class="update-form">
        <h3>Update Location</h3>
        <form method="post">
            <input type="hidden" name="id" id="update-id">
            <div class="form-group">
                <input type="text" name="name" id="update-name" placeholder="Laundry Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="address" id="update-address" placeholder="Address" required>
            </div>
            <div class="form-group">
                <input type="text" name="phone" id="update-phone" placeholder="Phone Number" required>
            </div>
            <button type="submit" name="update_location" class="btn-primary">Update Location</button>
            <button type="button" class="btn-secondary" onclick="closeUpdateForm()">Cancel</button>
        </form>
    </div>
</div>

<script>
    // Open the update form and populate it with data
    function openUpdateForm(id, name, address, phone) {
        document.getElementById('update-id').value = id;
        document.getElementById('update-name').value = name;
        document.getElementById('update-address').value = address;
        document.getElementById('update-phone').value = phone;
        document.getElementById('updateForm').style.display = 'block';
    }

    // Close the update form
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