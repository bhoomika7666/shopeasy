<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>ShopEasy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">ShopEasy</a>
        <a href="cart.php" class="btn btn-outline-light">Cart 
            <?php echo isset($_SESSION['cart']) ? '(' . count($_SESSION['cart']) . ')' : '(0)'; ?>
        </a>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="mb-4">Our Products</h2>
    <div class="row">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM products");
        while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" style="height:200px; object-fit:cover;" >
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                    <p class="card-text"><?php echo $row['description']; ?></p>
                    <h4>₹<?php echo $row['price']; ?></h4>
                    <p>Stock: <?php echo $row['stock']; ?></p>
                    <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Add to Cart</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>
</body>
</html>