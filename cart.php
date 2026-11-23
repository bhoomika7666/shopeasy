<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">ShopEasy</a>
        <a href="index.php" class="btn btn-outline-light">Continue Shopping</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Your Cart</h2>
    <?php if(empty($_SESSION['cart'])){ ?>
        <p>Cart is empty. <a href="index.php">Shop now</a></p>
    <?php } else { 
        $total = 0;
    ?>
    <table class="table">
        <tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th><th>Action</th></tr>
        <?php foreach($_SESSION['cart'] as $id => $qty){ 
            $result = mysqli_query($conn, "SELECT * FROM products WHERE id=$id");
            $row = mysqli_fetch_assoc($result);
            $subtotal = $row['price'] * $qty;
            $total += $subtotal;
        ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td>₹<?php echo $row['price']; ?></td>
            <td><?php echo $qty; ?></td>
            <td>₹<?php echo $subtotal; ?></td>
            <td><a href="remove_from_cart.php?id=<?php echo $id; ?>" class="btn btn-danger btn-sm">Remove</a></td>
        </tr>
        <?php } ?>
        <tr><td colspan="3"><b>Total</b></td><td colspan="2"><b>₹<?php echo $total; ?></b></td></tr>
    </table>
    <a href="checkout.php" class="btn btn-success">Checkout</a>
    <?php } ?>
</div>
</body>
</html>