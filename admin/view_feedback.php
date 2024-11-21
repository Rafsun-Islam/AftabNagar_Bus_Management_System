<?php
require '../includes/config.php';
require '../includes/session.php';
requireAdmin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Buses</title>
    <link rel="stylesheet" href="table.css"> <!-- Link to the CSS file -->
 
</head>
<body>
    <h2>View feedback</h2>
    <table>
        <tr>
            <th>id</th>
            <th>User id</th>
            <th>Name</th>
            <th>Feedback</th>
            <th>Date</th>
           
        </tr>
        <?php
        $sql = "SELECT * FROM feedback";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['user_id']}</td>
                    <td>{$row['user_full_name']}</td>
                    <td>{$row['feedback_text']}</td>
                    <td>{$row['date_submitted']}</td>
                   

                   
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No users found.</td></tr>";
        }

        mysqli_close($conn);
        ?>
        
    </table>
    <div class="centered">
        <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a> <!-- Link with the button style -->
    </div>
</body>
</html>
