<?php
include '../db.php';
if(!isset($_SESSION['admin'])){
    header("Location: login.php");
}

if(isset($_POST['add'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    
    // Handle image upload
    $image = $_FILES['image']['name'];
    $target = "../uploads/" . basename($image);
    
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        $sql = "INSERT INTO products (name, description, price, image, stock) 
                VALUES ('$name', '$desc', '$price', '$image', '$stock')";
        
        if(mysqli_query($conn, $sql)){
            $success = "Product added successfully!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Failed to upload image";
    }
}
?>
<!DOCTYPE html>
<html>
<head><title>Add Product</title>
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
    <h2>Add New Product</h2>
    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
    
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="desc" class="form-control" rows="3" required></textarea>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Price ₹</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Stock</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>
        <button type="submit" name="add" class="btn btn-primary">Add Product</button>
    </form>
</div>
</body>
</html>