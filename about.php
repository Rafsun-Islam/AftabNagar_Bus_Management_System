<?php
// This is just a dummy value for demonstration purposes
$lorem_ipsum = "The Aftabnagar Bus Service Management System is a web-based application designed to streamline the ticket purchasing process for users and simplify bus management tasks for administrators. The system allows users to create accounts, login, and purchase tickets for their desired routes. Administrators have access to a dashboard where they can manage bus details, view statistics, and perform administrative tasks.";

// You can add more details about your project here

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Project</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            background-image: url('Images/about.JPG');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* Optional: Add background color with opacity to make text more readable */
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>About This Project</h2>
        <p><?php echo $lorem_ipsum; ?></p>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
