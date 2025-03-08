<?php include 'navbar.php'; ?>
<?php
include '../db_connect.php'; 

// Total earnings query
$total_result = $conn->query("SELECT SUM(amount) AS total_earnings FROM payments WHERE payment_status = 'Completed'");
$total_earnings = $total_result->fetch_assoc()['total_earnings'] ?? 0;

// Transactions query with item names and correct status ordering
$transactions = $conn->query("SELECT p.*, u.name AS customer_name, 
                              GROUP_CONCAT(DISTINCT li.name) AS item_names 
                              FROM payments p 
                              JOIN users u ON p.customer_id = u.id 
                              LEFT JOIN order_items oi ON p.order_id = oi.order_id 
                              LEFT JOIN laundry_items li ON oi.laundry_item_id = li.id 
                              WHERE p.payment_status = 'Completed' 
                              GROUP BY p.order_id
                              ORDER BY p.transaction_date DESC");

// Reviews query with item names
$reviews = $conn->query("SELECT r.*, u.name AS customer_name, 
                         GROUP_CONCAT(DISTINCT li.name) AS item_names 
                         FROM reviews r 
                         JOIN users u ON r.customer_id = u.id 
                         LEFT JOIN order_items oi ON r.order_id = oi.order_id 
                         LEFT JOIN laundry_items li ON oi.laundry_item_id = li.id 
                         GROUP BY r.order_id
                         ORDER BY r.created_at DESC");
?>

<link rel="stylesheet" href="admin.css">

<h2>Admin Transactions</h2>
<div class="container">
    <p class="total-earnings">Total Earnings: <strong>৳ <?php echo number_format($total_earnings, 2); ?></strong></p>

    <table class="table">
        <tr><th>Order ID</th><th>Customer</th><th>Items</th><th>Amount</th><th>Payment Method</th><th>Status</th><th>Date</th></tr>
        <?php while ($row = $transactions->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['item_names']; ?></td>
            <td>৳ <?php echo number_format($row['amount'], 2); ?></td>
            <td><?php echo $row['payment_method']; ?></td>
            <td class="status-<?php echo strtolower($row['payment_status']); ?>">
                <?php echo $row['payment_status']; ?>
            </td>
            <td><?php echo $row['transaction_date']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<h2>Customer Reviews</h2>
<div class="container">
    <table class="table">
        <tr><th>Customer</th><th>Order ID</th><th>Items</th><th>Rating</th><th>Comment</th><th>Date</th></tr>
        <?php while ($row = $reviews->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['customer_name']; ?></td>
            <td><?php echo $row['order_id']; ?></td>
            <td><?php echo $row['item_names']; ?></td>
            <td><?php echo str_repeat("⭐", $row['rating']); ?></td>
            <td><?php echo $row['comment']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>
