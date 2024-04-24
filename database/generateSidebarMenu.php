<?php
// Start the session (assuming sessions are being used)
session_start();

// Include database configuration
require_once 'database.php';



// Retrieve the user ID from the session
$userId = $_SESSION['id'] ?? null;

// Check if user ID is available
if (!$userId) {
    // Handle the case where user is not authenticated
    echo json_encode(['sidebarMenu' => []]);
    exit; // Terminate script execution
}

// Prepare the SQL statement to retrieve user role
$stmt = $pdo->prepare("SELECT role_id FROM user_role WHERE user_id = ?");
$stmt->execute([$userId]);
$userRole = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if user role is found
if (!$userRole) {
    // Handle the case where user role is not found
    echo json_encode(['sidebarMenu' => []]);
    exit; // Terminate script execution
}

// Prepare the SQL statement to retrieve permissions associated with the role
$stmt = $pdo->prepare("SELECT menu_id FROM permissions WHERE role_id = ?");
$stmt->execute([$userRole['role_id']]);
$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sidebarMenu = [];

// Iterate over each permission and retrieve menu name and link
foreach ($permissions as $permission) {
    // Prepare the SQL statement to retrieve menu details
    $stmt = $pdo->prepare("SELECT id, name, link FROM menus WHERE id = ?");
    $stmt->execute([$permission['menu_id']]);
    $menu = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($menu) {
        // If menu exists, add its details to the sidebar menu
        $sidebarMenu[] = [
            'id' => $menu['id'],
            'name' => $menu['name'],
            'link' => $menu['link'],
        ];
    }
}

// Return the sidebar menu as JSON response
echo json_encode(['sidebarMenu' => $sidebarMenu]);
?>
