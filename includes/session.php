<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
    
}

function isAdmin() {
    return isset($_SESSION['admin']) && $_SESSION['admin'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        error_log("User not logged in. Redirecting to login.php");
        header('Location: login.php');
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        error_log("User is not admin. Redirecting to ../login.php");
        header('Location: ../login.php');
        exit();
    }
}
?>
