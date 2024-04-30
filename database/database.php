<?php
// Database configuration
$dbHost = 'localhost'; // Change this to your database host
$dbName = 'tech_vault'; // Change this to your database name
$dbUsername = 'root'; // Change this to your database username
$dbPassword = ''; // Change this to your database password

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUsername, $dbPassword);

    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally, you can set other attributes such as character set
    $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");

} catch(PDOException $e) {
    // Display an error message if connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>
