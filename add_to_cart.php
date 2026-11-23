<?php
include 'db.php';
$id = $_GET['id'];

// Initialize cart if not exists
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = array();
}

// Add product to cart or increase quantity
if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]++;
} else {
    $_SESSION['cart'][$id] = 1;
}

header("Location: index.php");
?>