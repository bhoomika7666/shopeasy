<?php
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Orders</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Admin Panel</a>
        <a href="dashboard.php" class="btn btn-outline-light">Back</a>
    </div>
</nav>
<div class="container mt-4">
    <h2>All Orders</h2>
    <table class="table table-bordered">
        <tr class="table-dark">
            <th>Order ID</th><th>Customer</th><th>Email</th><th>Phone</th><th>Total</th><th>Date</th><th>Items</th>
        </tr>
        <?php
        $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY order_date DESC");
        if(mysqli_num_rows($orders) == 0){
            echo "<tr><td colspan='7' class='text-center'>No orders yet</td></tr>";
        }
        while($order = mysqli_fetch_assoc($orders)){
        ?>
        <tr>
            <td>#<?php echo $order['id']; ?></td>
            <td><?php echo $order['customer_name']; ?></td>
            <td><?php echo $order['customer_email']; ?></td>
            <td><?php echo $order['customer_phone']; ?></td>
            <td>₹<?php echo $order['total_amount']; ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($order['order_date'])); ?></td>
            <td>
                <?php
                $items = mysqli_query($conn, "SELECT oi.*, p.name FROM order_items oi 
                                             JOIN products p ON oi.product_id = p.id 
                                             WHERE oi.order_id = ".$order['id']);
                while($item = mysqli_fetch_assoc($items)){
                    echo $item['name'] . " x" . $item['quantity'] . " = ₹" . ($item['price']*$item['quantity']) . "<br>";
                }
                ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>