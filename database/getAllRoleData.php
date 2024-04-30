<?php

// Start the session
session_start();

// Include database connection
require_once 'database.php';

try {
    // Get the menuId from the request
    $menuId = isset($_POST['menuId']) ? $_POST['menuId'] : null;

    // Check permissions
    if (checkPermissions($menuId)) {
        // Fetch all roles
        $stmt = $pdo->query("SELECT * FROM roles");
        $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return JSON response with roles data
        echo json_encode(['data' => $roles]);
    } else {
        // If permissions are denied, return view with message
        echo "Permission denied";
    }
} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

function checkPermissions($menuId)
{
    global $pdo;

    // Get the user ID from the session
    $userId = $_SESSION['id'];

    // Prepare and execute SQL query to fetch role ID
    $stmt = $pdo->prepare("SELECT role_id FROM user_role WHERE user_id = ?");
    $stmt->execute([$userId]);
    $roleId = $stmt->fetchColumn();

    // Check if a permission exists for the role and the specified menu ID
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM permissions WHERE role_id = ? AND menu_id = ? AND `read` = 'yes'");
    $stmt->execute([$roleId, $menuId]);
    $count = $stmt->fetchColumn();

    return $count > 0;
}
