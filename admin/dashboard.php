<?php
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Admin Panel - ShopEasy</span>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</nav>
<div class="container mt-4">
    <h3>Welcome, <?php echo $_SESSION['admin']; ?></h3>
    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <a href="add_product.php" class="btn btn-primary w-100 p-3">Add Product</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="orders.php" class="btn btn-success w-100 p-3">View Orders</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="../index.php" class="btn btn-secondary w-100 p-3" target="_blank">View Site</a>
        </div>
    </div>
</div>
</body>
</html>