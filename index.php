<?php
require_once 'includes/session.php';
requireLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aftab Nagar Bus Management System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            background-image: url('Images/indexx.JPG');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #0056b3;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
    <img src="Images/busLogo.png" alt="Bus Logo" style="width: 200px; height: auto;">
        <h2>Welcome to Aftab Nagar Bus Management System</h2>
        <p>Here you can buy your ticket efficiently and effortlessly.</p>
        <p>To purchase a new bus ticket, click on the "Purchase" option in the navigation bar or use the button below.</p>
        <a href="purchase_pass.php" class="btn">Purchase</a>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
