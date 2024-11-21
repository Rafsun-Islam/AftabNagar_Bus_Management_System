<?php
require 'includes/config.php';
require 'includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $name = $_POST['name'];
    $phonenumber = $_POST['phonenumber'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];

    // Check if the password and confirm password match
    if ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username or email already exists
        if (usernameExists($username)) {
            $error = 'Username already exists.';
        } elseif (emailExists($email)) {
            $error = 'Email already exists.';
        } else {
            if (register($username, $password, $name, $phonenumber, $dob, $email)) {
                header('Location: login.php');
                exit();
            } else {
                $error = 'Registration failed.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="phonenumber">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" required>
            <label for="dob">Date of Birth:</label>
            <input type="date" id="dob" name="dob" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            
            <button type="submit">Register</button>
        </form>
        <p><a href="login.php">Back to Login</a></p> <!-- Back to Login link -->
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
