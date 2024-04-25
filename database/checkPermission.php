<?php
session_start();

require_once 'database.php';

// Extract menuId and action from the request
$menuId = $_POST['menuId'];
$action = $_POST['action'];

// Get the user ID from the session
$userId = $_SESSION['id'];

// Retrieve the user's role ID from the user_role pivot table
global $pdo;
$stmt = $pdo->prepare("SELECT role_id FROM user_role WHERE user_id = ?");
$stmt->execute([$userId]);
$userRole = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$userRole) {
    echo json_encode(['success' => false, 'message' => 'User role not found']);
    exit;
}

$roleId = $userRole['role_id'];

// Check if the user's role has the specified permission for the specified module
$stmt = $pdo->prepare("SELECT * FROM permissions WHERE role_id = ? AND menu_id = ?");
$stmt->execute([$roleId, $menuId]);
$permissions = $stmt->fetch(PDO::FETCH_ASSOC);

if ($permissions && $permissions[$action] === 'yes') {
    // User has permission
    echo json_encode(['success' => true]);
} else {
    // Permission denied
    echo json_encode(['success' => false]);
}
