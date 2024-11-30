<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS referral";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("referral");

// Create tables
$sql = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    facilitator_id INT NOT NULL,
    schedule DATETIME NOT NULL,
    result_id VARCHAR(255) NOT NULL,
    status ENUM('pending', 'on process', 'finished') DEFAULT 'pending',
    notification_status ENUM('unread', 'read') DEFAULT 'unread',
    user_notification_status ENUM('unread', 'read') DEFAULT 'unread',
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id)
);

CREATE TABLE IF NOT EXISTS referrals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    concerns TEXT,
    concern_details TEXT,
    actions_taken TEXT,
    recommendations TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    notification_status ENUM('unread', 'read') DEFAULT 'unread',
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id)
);

CREATE TABLE IF NOT EXISTS user_information (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    gender VARCHAR(50) NOT NULL,
    contact VARCHAR(50) NOT NULL,
    department VARCHAR(255) NOT NULL,
    designation VARCHAR(255) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    INDEX (user_id)
);

CREATE TABLE IF NOT EXISTS user_remarks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    referral_id INT NOT NULL,
    remarks TEXT NOT NULL,
    recommendations TEXT,
    follow_up TEXT,
    actions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (referral_id) REFERENCES referrals(id),
    INDEX (user_id),
    INDEX (referral_id)
);
";

if ($conn->multi_query($sql) === TRUE) {
    echo "Tables created successfully<br>";
    // Fetch all results from multi_query
    do {
        if ($result = $conn->store_result()) {
            $result->free();
        }
    } while ($conn->more_results() && $conn->next_result());
} else {
    echo "Error creating tables: " . $conn->error . "<br>";
}

$conn->close();
?>
