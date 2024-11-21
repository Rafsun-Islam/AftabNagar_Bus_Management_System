<?php

require_once 'includes/config.php';
require_once 'includes/functions.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $login_result = login($username, $password);

    if ($login_result === true) {
        // Redirect to index.php upon successful login
        header('Location: index.php');
        exit();
    } else {
        $error = $login_result;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            background-image: url('Images/Login.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Add background color with opacity to make text more readable */
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            margin: auto;
            margin-top: 100px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <p>New user? <a href="register.php">Sign up here</a></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
