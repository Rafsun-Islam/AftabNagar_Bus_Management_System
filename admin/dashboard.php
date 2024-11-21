<?php
require_once '../includes/config.php';

// Fetch data
$totalUsers = $conn->query('SELECT COUNT(*) AS count FROM users')->fetch_assoc()['count'];
$totalBuses = $conn->query('SELECT COUNT(*) AS count FROM buses')->fetch_assoc()['count'];
$busesInMaintenance = $conn->query('SELECT COUNT(*) AS count FROM buses WHERE is_maintenance = 1')->fetch_assoc()['count'];
$totalRevenue = $conn->query('SELECT SUM(fare) AS total_revenue FROM passes')->fetch_assoc()['total_revenue'];

// Adding a new bus
$bus_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_bus'])) {
    $bus_name = $_POST['bus_name'];
    $start_station = $_POST['start_station'];
    $end_station = $_POST['end_station'];

    $stmt = $conn->prepare("INSERT INTO buses (bus_name, start_station, end_station) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $bus_name, $start_station, $end_station);
    
    if ($stmt->execute()) {
        $bus_message = "Bus added successfully!";
        $totalBuses = $conn->query('SELECT COUNT(*) AS count FROM buses')->fetch_assoc()['count'];
    } else {
        $bus_message = "Error adding bus: " . $stmt->error;
    }
    
    $stmt->close();
}

// Adding a bus to maintenance
$maintenance_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_maintenance'])) {
    $bus_id = $_POST['bus_id'];

    // Check if the bus exists
    $stmt = $conn->prepare("SELECT is_maintenance FROM buses WHERE id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        $maintenance_message = "Bus does not exist.";
    } elseif ($result['is_maintenance'] == 1) {
        $maintenance_message = "Bus is already in maintenance.";
    } else {
        $stmt = $conn->prepare("UPDATE buses SET is_maintenance = 1 WHERE id = ?");
        $stmt->bind_param("i", $bus_id);
        
        if ($stmt->execute()) {
            $maintenance_message = "Bus added to maintenance successfully!";
            $busesInMaintenance = $conn->query('SELECT COUNT(*) AS count FROM buses WHERE is_maintenance = 1')->fetch_assoc()['count'];
        } else {
            $maintenance_message = "Error adding bus to maintenance: " . $stmt->error;
        }
    }
    
    $stmt->close();
}

// Removing a bus from maintenance
$remove_maintenance_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_maintenance_bus'])) {
    $bus_id = $_POST['remove_maintenance_bus_id'];

    // Check if the bus exists
    $stmt = $conn->prepare("SELECT is_maintenance FROM buses WHERE id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        $remove_maintenance_message = "Bus does not exist.";
    } elseif ($result['is_maintenance'] == 0) {
        $remove_maintenance_message = "Bus is not in maintenance.";
    } else {
        $stmt = $conn->prepare("UPDATE buses SET is_maintenance = 0 WHERE id = ?");
        $stmt->bind_param("i", $bus_id);
        
        if ($stmt->execute()) {
            $remove_maintenance_message = "Bus removed from maintenance successfully!";
            $busesInMaintenance = $conn->query('SELECT COUNT(*) AS count FROM buses WHERE is_maintenance = 1')->fetch_assoc()['count'];
        } else {
            $remove_maintenance_message = "Error removing bus from maintenance: " . $stmt->error;
        }
    }
    
    $stmt->close();
}

// Removing a bus
$remove_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_bus'])) {
    $bus_id = $_POST['remove_bus_id'];

    // Check if the bus exists
    $stmt = $conn->prepare("SELECT id FROM buses WHERE id = ?");
    $stmt->bind_param("i", $bus_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    if (!$result) {
        $remove_message = "Bus does not exist.";
    } else {
        $stmt = $conn->prepare("DELETE FROM buses WHERE id = ?");
        $stmt->bind_param("i", $bus_id);
        
        if ($stmt->execute()) {
            $remove_message = "Bus removed successfully!";
            $totalBuses = $conn->query('SELECT COUNT(*) AS count FROM buses')->fetch_assoc()['count'];
            $busesInMaintenance = $conn->query('SELECT COUNT(*) AS count FROM buses WHERE is_maintenance = 1')->fetch_assoc()['count'];
        } else {
            $remove_message = "Error removing bus: " . $stmt->error;
        }
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
        }
        .sidebar {
            background-color: #28a745;
            padding: 20px;
            height: 100vh;
            color: white;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #218838;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>AfnBus</h2>
        <a href="dashboard.php">Dashboard</a>
        <a href="view_user.php">Users</a>
        <a href="view_buses.php">Buses</a>
        <a href="view_passes.php">Tickets</a>
        <a href="view_feedback.php">Feedback</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title"><?= $totalUsers ?> Total Users</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title"><?= $totalBuses ?> Total Buses</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h5 class="card-title"><?= $busesInMaintenance ?> Buses in Maintenance</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title"><?= $totalRevenue ?>৳ Total Revenue</h5>
                    </div>
                </div>
            </div>
        </div>
        <h2>Manage Buses</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Bus</h5>
                        <?php if ($bus_message): ?>
                            <div class="alert alert-info"><?= $bus_message ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="bus_name">Bus Name</label>
                                <input type="text" class="form-control" id="bus_name" name="bus_name" required>
                            </div>
                            <div class="form-group">
                                <label for="start_station">Start Station</label>
                                <input type="text" class="form-control" id="start_station" name="start_station" required>
                            </div>
                            <div class="form-group">
                                <label for="end_station">End Station</label>
                                <input type="text" class="form-control" id="end_station" name="end_station" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_bus">Add Bus</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add Bus to Maintenance</h5>
                        <?php if ($maintenance_message): ?>
                            <div class="alert alert-info"><?= $maintenance_message ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="bus_id">Bus ID</label>
                                <input type="number" class="form-control" id="bus_id" name="bus_id" required>
                            </div>
                            <button type="submit" class="btn btn-primary" name="add_maintenance">Add to Maintenance</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Remove Bus from Maintenance</h5>
                        <?php if ($remove_maintenance_message): ?>
                            <div class="alert alert-info"><?= $remove_maintenance_message ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="remove_maintenance_bus_id">Bus ID</label>
                                <input type="number" class="form-control" id="remove_maintenance_bus_id" name="remove_maintenance_bus_id" required>
                            </div>
                            <button type="submit" class="btn btn-danger" name="remove_maintenance_bus">Remove from Maintenance</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Remove Bus</h5>
                        <?php if ($remove_message): ?>
                            <div class="alert alert-info"><?= $remove_message ?></div>
                        <?php endif; ?>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="remove_bus_id">Bus ID</label>
                                <input type="number" class="form-control" id="remove_bus_id" name="remove_bus_id" required>
                            </div>
                            <button type="submit" class="btn btn-danger" name="remove_bus">Remove Bus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
