<?php
// Include database connection
require 'db_connect.php';

session_start();
$message = "";

// Handling login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT id, role, name, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $role, $name, $hashed_password);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Store session variables
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;

            // Redirect based on role
            if ($role === "Admin") {
                header("Location: admin/admin_dashboard.php");
            } elseif ($role === "Customer") {
                header("Location: customer/customer_dashboard.php");
            } elseif ($role === "Rider") {
                header("Location: rider/rider_dashboard.php");
            } else {
                header("Location: index.html"); // Fallback
            }
            exit();
        } else {
            $message = "Invalid email or password!";
        }
    } else {
        $message = "No user found with this email!";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LOGIN</title>

    <!-- FAVICON -->
    <link rel="shortcut icon" href="assets/images/login_favicon.png" type="image/x-icon" />

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <!-- FONT AWESOME ICONS -->
    <script src="https://kit.fontawesome.com/1535749e06.js" crossorigin="anonymous"></script>

    <!-- CSS STYLES -->
    <link rel="stylesheet" href="css/login.css" />
    <link rel="stylesheet" href="css/responsive.css" />
</head>

<body>
    <main class="main_container">
        <section class="form_section">
            <h2 class="form_heading">Login</h2>

            <!-- Display error message -->
            <?php if (!empty($message)): ?>
                <p style="color: red; font-weight: bold; text-align: center;"><?= $message; ?></p>
            <?php endif; ?>

            <form class="main_form" method="POST">
                <div class="input_field">
                    <input class="user_email" type="email" name="email" placeholder="Email Address" required>
                </div>
                <div class="input_field">
                    <input class="user_password" type="password" name="password" placeholder="Password" required>
                </div>
                <div class="input_field">
                    <button class="submit-btn" type="submit">LOGIN</button>
                </div>
                <label class="reg_section">Don't have an account? <br> <a href="registration.php"><u> Click Here </u></a></label>
            </form>
        </section>
    </main>
</body>

</html>
