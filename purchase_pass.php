<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/session.php';

requireLogin();

// Establish MySQLi connection
$mysqli = new mysqli($server, $username, $pass, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $from = $_POST['from'];
    $to = $_POST['to'];
    $fare = $_POST['fare']; // Get fare from the POST request

    // Get user ID from session
    $userId = $_SESSION['user_id'];

    // Call function to store pass data
    if (storePassData($userId, $from, $to, $fare, $mysqli)) {
        header("Location: print_ticket.php?from=$from&to=$to&fare=$fare");
    } else {
        echo 'Purchase failed.';
    }
}

// Close MySQLi connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Purchase Ticket</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/purchase.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            background-image: url("Images/purchase2.JPG");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
    <script>
        const fareMap = {
            'A': {'A': 0, 'B': 10, 'C': 10, 'D': 10, 'E': 15, 'G': 15, 'K': 20, 'M': 20},
            'B': {'A': 10, 'B': 0, 'C': 10, 'D': 10, 'E': 15, 'G': 15, 'K': 20, 'M': 20},
            'C': {'A': 10, 'B': 10, 'C': 0, 'D': 10, 'E': 10, 'G': 10, 'K': 15, 'M': 20},
            'D': {'A': 10, 'B': 10, 'C': 10, 'D': 0, 'E': 10, 'G': 10, 'K': 15, 'M': 20},
            'E': {'A': 15, 'B': 15, 'C': 10, 'D': 10, 'E': 0, 'G': 10, 'K': 10, 'M': 15},
            'G': {'A': 15, 'B': 15, 'C': 10, 'D': 10, 'E': 10, 'G': 0, 'K': 10,'M': 10},
            'K': {'A': 20, 'B': 20, 'C': 15, 'D': 15, 'E': 10, 'G': 10, 'K': 0,'M': 10},
            'M': {'A': 20, 'B': 20, 'C': 20, 'D': 20, 'E': 15, 'G': 10, 'K': 10,'M': 0},
        };

        function calculateFare() {
            const from = document.getElementById('from').value;
            const to = document.getElementById('to').value;
            const fare = fareMap[from][to];
            document.getElementById('fare').value = fare;
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('from').addEventListener('change', calculateFare);
            document.getElementById('to').addEventListener('change', calculateFare);
            calculateFare(); // Call initially to calculate fare on page load
        });
    </script>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Purchase Ticket</h2>
        <form method="POST" action="purchase_pass.php">
            <label for="from">From:</label>
            <select id="from" name="from" required>
                <option value="A">A Block</option>
                <option value="B">B Block</option>
                <option value="C">C Block</option>
                <option value="D">D Block</option>
                <option value="E">E Block</option>
                <option value="G">G Block</option>
                <option value="K">K Block</option>
                <option value="M">M Block</option>
            </select>
            <label for="to">To:</label>
            <select id="to" name="to" required>
                <option value="A">A Block</option>
                <option value="B">B Block</option>
                <option value="C">C Block</option>
                <option value="D">D Block</option>
                <option value="E">E Block</option>
                <option value="G">G Block</option>
                <option value="K">K Block</option>
                <option value="M">M Block</option>
            </select>
            <label for="fare">Fare:</label>
            <input type="text" id="fare" name="fare" readonly>
            <button type="submit">Purchase</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
