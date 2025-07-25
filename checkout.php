<?php
    include("dataBase.php");

    if (!isset($_SESSION['user_id'])) {
        // Store redirect location
        $_SESSION['redirect_after_login'] = 'checkout.php';
        header("Location: login.php");
        exit;
    } 
    else {
        echo "hello";
    }
