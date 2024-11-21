<?php

require_once 'config.php';


function login($username, $password) {
    global $conn;

    // Check if the username exists
    $query = $conn->prepare('SELECT id, password FROM users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $query->store_result();

    if ($query->num_rows == 0) {
        return 'Username does not exist.';
    } else {
        $query->bind_result($id, $hashed_password);
        $query->fetch();
        
        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Set session variables or other login procedures
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            return true;
        } else {
            return 'Incorrect password.';
        }
    }
}


function usernameExists($username) {
    global $conn;
    $query = $conn->prepare('SELECT * FROM users WHERE username = ?');
    $query->bind_param('s', $username);
    $query->execute();
    $query->store_result();
    return $query->num_rows > 0;
}

function emailExists($email) {
    global $conn;
    $query = $conn->prepare('SELECT * FROM users WHERE email = ?');
    $query->bind_param('s', $email);
    $query->execute();
    $query->store_result();
    return $query->num_rows > 0;
}

function register($username, $password, $name, $phonenumber, $dob, $email) {
    global $conn;

    // Check if the username or email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Username or email already exists
        return false;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert the new user into the database
    $stmt = $conn->prepare("INSERT INTO users (username, password, name, phonenumber, DOB, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $username, $hashed_password, $name, $phonenumber, $dob, $email);
    
    return $stmt->execute();
}


function storePassData($userId, $fromBlock, $toBlock, $fare, $mysqli) {
    $stmt = $mysqli->prepare('INSERT INTO passes (user_id, from_block, to_block, fare) VALUES (?, ?, ?, ?)');
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($mysqli->error));
    }

    $stmt->bind_param('isss', $userId, $fromBlock, $toBlock, $fare);
    if ($stmt->execute()) {
        $stmt->close();
        return true;
    } else {
        $stmt->close();
        return false;
    }
}

?>