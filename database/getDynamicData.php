<?php
session_start(); // Start the session

// Include the database configuration file
require_once 'database.php';

try {
    // Connect to the database using PDO (assuming $pdo is already initialized in database.php)
    $stmt = $pdo->prepare("SELECT * FROM credential_for_users");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Set the appropriate Content-Type header
    header('Content-Type: application/json');

    // Output the JSON response
    echo json_encode(['data' => $data]);
} catch (PDOException $e) {
    // Handle database connection or query errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
