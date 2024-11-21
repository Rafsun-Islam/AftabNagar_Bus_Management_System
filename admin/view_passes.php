<?php
require '../includes/config.php';
require '../includes/session.php';
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Passes</title>
    <link rel="stylesheet" href="table.css"> <!-- Link to the CSS file -->
</head>
<body>
    <h2>View Passes</h2>
    <table>
        <tr>
            <th>User ID</th>
            <th>From Block</th>
            <th>To Block</th>
            <th>Fare</th>
        </tr>
        <?php
            $query= "SELECT * FROM passes";

            $result = mysqli_query($conn, $query );

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['user_id']}</td>
                    <td>{$row['from_block']}</td>
                    <td>{$row['to_block']}</td>
                    <td>{$row['fare']}</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No passes found.</td></tr>";
        }

        mysqli_close($conn);
        
        ?>
    </table>
    <div class="centered">
        <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a> <!-- Link with the button style -->
    </div>
</body>
</html>
