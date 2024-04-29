<?php

// Start the session
session_start();

// Include database connection
require_once 'database.php';

try {
    // Get the menuId from the request
    $menuId = isset($_POST['menuId']) ? $_POST['menuId'] : null;

    // Get the role ID from the URL parameter
    $roleId = $_POST['id'];

    // Check permissions
    if (checkPermissions($menuId)) {
        // Prepare and execute SQL query to fetch permissions associated with the given role ID
        $stmt = $pdo->prepare("SELECT permissions.*, menus.* FROM permissions JOIN menus ON permissions.menu_id = menus.id WHERE permissions.role_id = ?");
        $stmt->execute([$roleId]);
        $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($permissions)) {
            // If permissions are found, return them as JSON response
            echo json_encode(['data' => $permissions]);
        } else {
            // If no permissions are found, return a 404 error response
            http_response_code(404);
            echo json_encode(['error' => 'No permissions found for the given role ID']);
        }
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
