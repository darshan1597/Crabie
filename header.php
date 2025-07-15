<?php
    include("dataBase.php");
?>    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Crabie | Stylish Jackets</title>
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<style>
    .nav-link.active{
        font-weight: bolder;
        text-decoration: underline;
    }
</style>
<body>

  <!-- Header -->
    <header class="navbar">
        <div class="logo">CRABIE</div>
        <nav class="nav">
            <a href="index.php" class="nav-link">Home</a>
            <a href="shop.php" class="nav-link">Shop</a>
            <a href="about.php" class="nav-link">About</a>
            <a href="contact.php" class="nav-link">Contact</a>
        </nav>
        <div class="cart-icon">
            <img src="./images/cart-icon.png" alt="Cart" />
        </div>
    </header>