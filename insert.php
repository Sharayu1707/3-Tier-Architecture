<?php
// ==============================
// RDS Database Configuration
// ==============================
$host     = "your-rds-endpoint.amazonaws.com";  // Example: mydb.xxxxxx.ap-south-1.rds.amazonaws.com
$port     = 3306;                               // Default MySQL port
$dbname   = "datadb";               // The DB you created in RDS
$username = "root";                // The master username from RDS
$password = "pass1234";                // The password you set

// ==============================
// Create Connection
// ==============================
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// ==============================
// Get Form Data (from POST)
// ==============================
$name  = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($name) || empty($email)) {
    die("⚠️ Name and Email are required!");
}

// Use prepared statement (safe from SQL Injection)
$stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $email);

if ($stmt->execute()) {
    echo "✅ New record created successfully. <br>";
    echo "<a href='form.html'>Go Back</a>";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>