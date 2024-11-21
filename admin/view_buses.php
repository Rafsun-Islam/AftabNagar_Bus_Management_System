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
    <h2>View Buses</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Bus Name</th>
            <th>Start Station</th>
            <th>End Station</th>
            <th>Maintenance Status</th>
        </tr>
        <?php
        $sql = "SELECT * FROM buses";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['bus_name']}</td>
                    <td>{$row['start_station']}</td>
                    <td>{$row['end_station']}</td>
                    <td>" . ($row['is_maintenance'] ? 'In Maintenance' : 'Operational') . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No buses found.</td></tr>";
        }

        mysqli_close($conn);
        ?>
        
    </table>
    <div class="centered">
        <a href="dashboard.php" class="back-to-dashboard">Back to Dashboard</a> <!-- Link with the button style -->
    </div>
</body>
</html>
