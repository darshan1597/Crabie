<?php
    session_start();
    include("functions.php");

    $productId = $_GET['productId'] ?? '';
    
    $size = $_GET['size'] ?? '';
    $qty = $_GET['qty'] ?? 1;

    $decryptedProductId = convertData($productId, 'decrypt');

    // You can also validate these values here

    // Add to cart session
    $_SESSION['cart'][] = [
        'productId' => $decryptedProductId,
        'size' => $size,
        'qty' => (int)$qty
    ];

    // Redirect to cart page
    header("Location: cart.php");
    exit;
?>