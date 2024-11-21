<?php
require 'includes/config.php';
require 'includes/functions.php';
require 'includes/session.php';

requireLogin();

// Establish MySQLi connection
$mysqli = mysqli_connect($server, $username, $pass, $database);

// Check connection
if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user details from session or database
$userId = $_SESSION['user_id'];
$userDetails = getUserDetails($userId, $mysqli); // Pass $mysqli to the function

// Get ticket details from the URL parameters
$from = $_GET['from'];
$to = $_GET['to'];
$fare = $_GET['fare'];

function getUserDetails($userId, $mysqli)
{
    $userDetails = array();
    $stmt = mysqli_prepare($mysqli, "SELECT name, dob, phonenumber, email FROM users WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($mysqli));
    }
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $name, $dob, $phoneNumber, $email); // Adjust variable name to match column name
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    $userDetails['name'] = $name;
    $userDetails['dob'] = $dob;
    $userDetails['phone'] = $phoneNumber; // Use the correct variable name
    $userDetails['email'] = $email;
    return $userDetails;
}

$userDetails = getUserDetails($userId, $mysqli);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Print Ticket</title>
    <link rel="stylesheet" href="css/ticket.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>

        nav ul li a {
            color: black !important;
        }
        
        @media print {
            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .container button {
                visibility: hidden;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div style="display:flex">
            <div style="width:900px">
                <h2>Ticket Details</h2>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($userDetails['name']); ?></p>
                <p><strong>Date Of Birth:</strong> <?php echo htmlspecialchars($userDetails['dob']); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($userDetails['phone']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($userDetails['email']); ?></p>
                <p><strong>From:</strong> <?php echo htmlspecialchars($from); ?></p>
                <p><strong>To:</strong> <?php echo htmlspecialchars($to); ?></p>
                <p><strong>Fare:</strong> ৳<?php echo htmlspecialchars($fare); ?></p>
            </div>
            <div>
                <img src="Images/busLogo.png" alt="Bus Logo" style="width: 200px; height: auto;">
            </div>
        </div>
        <button onclick="window.print()">Print Ticket</button>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>