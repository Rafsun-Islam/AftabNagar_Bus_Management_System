<?php
require 'includes/config.php';
require 'includes/session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $user_id = $_SESSION['user_id']; // Assuming user's ID is stored in the session
    $feedback_text = $_POST['feedback_text'];

    // Fetching user's name from the database using the session ID
    $stmt_name = $conn->prepare("SELECT name FROM users WHERE id = ?");
    
    if (!$stmt_name) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt_name->bind_param("i", $user_id);
    $stmt_name->execute();

    // Check if execution was successful
    if (!$stmt_name->execute()) {
        die("Error executing statement: " . $stmt_name->error);
    }

    $result = $stmt_name->get_result();
    $row = $result->fetch_assoc();
    $user_full_name = $row['name'];
    $stmt_name->close();

    // Inserting feedback into the database
    $stmt = $conn->prepare("INSERT INTO feedback (user_id, user_full_name, feedback_text) VALUES (?, ?, ?)");
    
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("iss", $user_id, $user_full_name, $feedback_text);

    if ($stmt->execute()) {
        $feedback_message = "Thank you for your feedback!";
        $feedback_class = "alert-success";
    } else {
        $feedback_message = "Error submitting feedback: " . $stmt->error;
        $feedback_class = "alert-danger";
    }

    $stmt->close();

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Feedback</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/feedback.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <style>
        body {
            background-image: url("Images/feedback.JPG");
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2 class="text-center">Submit Your Feedback</h2>
        <?php if (isset($feedback_message)): ?>
            <div class="alert <?= $feedback_class ?>"><?= $feedback_message ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="form-group">
                <label for="feedback_text">Your Feedback</label>
                <textarea class="form-control" id="feedback_text" name="feedback_text" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary btn-block" name="submit_feedback">Submit Feedback</button>
        </form>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
