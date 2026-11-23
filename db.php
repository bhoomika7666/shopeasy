<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "shopeasy_db");
if (!$conn) {
    die("Connection failed");
}
?>