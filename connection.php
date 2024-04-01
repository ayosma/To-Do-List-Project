<?php
// Database connection parameters
$servername = "localhost";
$username = "zsirajo1";
$password = "zsirajo1";
$database = "zsirajo1";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create tasks table if not exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    task_name VARCHAR(255) NOT NULL,
    priority VARCHAR(50) NOT NULL,
    progress VARCHAR(50) NOT NULL

)";

// Create users table if not exists
$sql_create_users = "CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

// Execute queries to create tables
if ($conn->query($sql_create_table) === TRUE && $conn->query($sql_create_users) === TRUE) {
    echo "";
} else {
    echo "Error creating table: " . $conn->error;
}

?>
