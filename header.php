<?php
    include("dataBase.php");
    include("functions.php");
    
    $cartCount = 0;

    if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $cartCount += $item['qty'];
        }
    }
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
    .cart-icon {
        position: relative;
        display: inline-block;
    }

    .cart-link {
        display: inline-block;
        position: relative;
    }

    .cart-img {
        width: 40px;
        height: auto;
    }

    .cart-badge {
        position: absolute;
        bottom: 0;
        right: 0;
        transform: translate(50%, 50%);
        background-color: #ccc; /* grey background */
        color: black;
        border-radius: 50%;
        padding: 4px 7px;
        font-size: 12px;
        min-width: 20px;
        height: 20px;
        line-height: 12px;
        text-align: center;
        font-weight: bold;
        box-shadow: 0 0 2px rgba(0,0,0,0.3);
    }
    .right{
        display: flex;
        gap: 10px;
    }
    .login{
        background-color: black;
        padding: 10px 20px;
        color: white;
        border-radius: 8px;
        transition: transform 0.3s ease
    }
    .login:hover{
        transform: scale(1.05);
    }
    .account {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }
    .dropdown {
        display: none;
        position: absolute;
        right: 0;
        top: 45px;
        background-color: white;
        min-width: 160px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        z-index: 1000;
    }

    .dropdown a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        border-bottom: 1px solid #eee;
    }

    .dropdown a:last-child {
        border-bottom: none;
    }

    .dropdown a:hover {
        background-color: #f1f1f1;
        border-radius: 8px;
    }
</style>
<body>

  <!-- Header -->
    <header class="navbar">
        <a href="index"><div class="logo">CRABIE</div></a>
        <nav class="nav">
            <a href="index" class="nav-link">Home</a>
            <a href="shop" class="nav-link">Shop</a>
            <a href="about" class="nav-link">About</a>
            <a href="contact" class="nav-link">Contact</a>
        </nav>
       
        <div class="right">
             <?php
            if(!isUser()){
        ?>
                <div class="login">
                    <a href="register">
                        Login/SignUp
                    </a>
                </div>
        <?php
            }
            else{
        ?>
                <div class="account" onclick="toggleDropdown()">
                    <img src="account.png" alt="Account" class="cart-img" style="width: 38px" />
                    <div id="accountDropdown" class="dropdown">
                        <a href="account-details">Account Details</a>
                        <a href="order-history">Order History</a>
                        <a href="logout">Logout</a>
                    </div>
                </div>
        <?php
            }
        ?>
            <div class="cart-icon">
                <a href="cart" class="cart-link">
                    <img src="cart-icon.png" alt="Cart" class="cart-img" />
                    <?php if ($cartCount > 0){ ?>
                        <span class="cart-badge"><?= $cartCount ?></span>
                    <?php } ?>
                </a>
            </div>
        </div>
    </header>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("accountDropdown");
            dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
        }

        document.addEventListener("click", function (event) {
            var dropdown = document.getElementById("accountDropdown");
            var account = document.querySelector(".account");
            if (!account.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
    </script>