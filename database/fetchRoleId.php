<?php
session_start(); // Start the session

// Include the database configuration file
require_once 'database.php';


try {
    // Prepare SQL statement to fetch role ID for 'User' role
    $stmt = $pdo->prepare("SELECT id FROM roles WHERE role = 'User'");
    $stmt->execute();
    $roleId = $stmt->fetchColumn();

    if ($roleId) {
        echo json_encode(['success' => true, 'roleId' => $roleId]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Role not found']);
    }
} catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
