<?php
$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password is empty
$dbname = "referral";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the 'is_admin' column exists
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'is_admin'");
if ($result->num_rows == 0) {
    die("Error: 'is_admin' column does not exist in 'users' table. Please run the setup_database.php script first.<br>");
}

// Insert an admin user
$admin_email = "admin@example.com";
$admin_username = "admin";
$admin_first_name = "Sarah";
$admin_last_name = "Dominguez";
$admin_password = password_hash("123", PASSWORD_DEFAULT); // Hash the password
$admin_is_admin = TRUE;

$sql = "INSERT INTO users (email, username, first_name, last_name, password, is_admin) VALUES ('$admin_email', '$admin_username', '$admin_first_name', '$admin_last_name', '$admin_password', $admin_is_admin)";
if ($conn->query($sql) === TRUE) {
    echo "Admin user created successfully<br>";
} else {
    echo "Error creating admin user: " . $conn->error . "<br>";
}

$conn->close();
?>