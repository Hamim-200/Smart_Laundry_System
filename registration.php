<?php
// Include database connection
require 'db_connect.php';

// Initialize error or success message
$message = "";

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $sql = "INSERT INTO users (role, name, phone, address, email, password) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $role, $name, $phone, $address, $email, $hashed_password);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Now!</title>
    <link rel="shortcut icon" href="assets/images/login_favicon.png" type="image/x-icon" />

    <!-- ICONS (FONT AWESOME) -->
    <script src="https://kit.fontawesome.com/1535749e06.js" crossorigin="anonymous"></script>

    <!-- CSS ADDED -->
    <link rel="stylesheet" href="css/registration.css" />
    <link rel="stylesheet" href="css/responsive.css" />
</head>

<body>
    <div class="wrapper">
        <div class="inner">
            <form action="" method="POST">
                <h3>Registration Form</h3>

                <!-- Display message -->
                <?php if (!empty($message)): ?>
                    <p style="color: red; font-weight: bold;"><?= $message; ?></p>
                <?php endif; ?>

                <div class="form-wrapper select-wrapper">
                    <select class="form-control" name="role" required>
                        <option value="" disabled selected>Register as a?</option>
                        <option value="Customer">Customer</option>
                        <option value="Rider">Rider</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="form-wrapper">
                    <input type="text" name="name" placeholder="Name" class="form-control" required>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="form-wrapper">
                    <input type="text" name="phone" placeholder="Phone" class="form-control" required>
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="form-wrapper">
                    <input type="text" name="address" placeholder="Address" class="form-control" required>
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="form-wrapper">
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="form-wrapper">
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div class="form-wrapper">
                    <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                <button type="submit">Register <i class="fa-solid fa-arrow-right-long"></i></button> <br>
                <label class="log_section">Already have an account? <a href="login.php"><u> Click Here </u></a></label>
            </form>
        </div>
    </div>
</body>

</html>
