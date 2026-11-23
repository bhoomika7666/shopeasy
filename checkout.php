<?php 
include 'db.php'; 

if(empty($_SESSION['cart'])){
    header("Location: cart.php");
    exit();
}

// Calculate total
$total = 0;
foreach($_SESSION['cart'] as $id => $qty){
    $result = mysqli_query($conn, "SELECT price FROM products WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
    $total += $row['price'] * $qty;
}

if(isset($_POST['place_order'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
$payment_mode=$_POST['payment_mode'];
    
    // Insert into orders table
    $sql = "INSERT INTO orders (customer_name, customer_email, customer_phone, customer_address, total_amount,payment_mode) 
            VALUES ('$name', '$email', '$phone', '$address', '$total','$payment_mode')";
    
    if(mysqli_query($conn, $sql)){
        $order_id = mysqli_insert_id($conn);
        
        // Insert each item into order_items
        foreach($_SESSION['cart'] as $id => $qty){
            $result = mysqli_query($conn, "SELECT price FROM products WHERE id=$id");
            $row = mysqli_fetch_assoc($result);
            $price = $row['price'];
            mysqli_query($conn, "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                VALUES ('$order_id', '$id', '$qty', '$price')");
            
            // Reduce stock
            mysqli_query($conn, "UPDATE products SET stock = stock - $qty WHERE id=$id");
        }
        
        unset($_SESSION['cart']); // Empty cart
        $success = "Order placed successfully! Your Order ID is #$order_id";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">ShopEasy</a>
        <a href="cart.php" class="btn btn-outline-light">Back to Cart</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Checkout</h2>
    <h4>Order Total: ₹<?php echo $total; ?></h4>
    
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success <a href='index.php'>Continue Shopping</a></div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    
    <?php if(!isset($success)){ ?>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Phone</label>
                <input type="tel"
name="phone"
placeholder="10-digit mobile number"
required
maxlength="10"
pattern="[6-9][0-9]{9}"
inputmode="numeric"
title="enter 10 digit indian mobile number">
            </div>
            <div class="col-md-12 mb-3">
                <label>Address</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
            </div>
        </div>
<div class="mb-3">
    <label><strong>Payment Method:</strong></label><br>
    <input type="radio" name="payment_mode" value="COD" checked required> COD<br>
    <input type="radio" name="payment_mode" value="UPI" required> UPI<br>
    <input type="radio" name="payment_mode" value="Card" required> Card<br>
</div>
        <button type="submit" name="place_order" class="btn btn-success btn-lg">Place Order</button>
    </form>
    <?php } ?>
</div>
</body>
</html>