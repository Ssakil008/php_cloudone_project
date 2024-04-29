<?php
session_start();

require_once 'database.php';

try {
    // Extract menuId and id from the request
    $id = $_POST['id'];
    $menu_id = $_POST['menuId'];

    // Get the menu ID from the session
    $userId = $_SESSION['id'];

    // Retrieve the menu's role ID from the user_role pivot table
    global $pdo;
    $stmt = $pdo->prepare("SELECT role_id FROM user_role WHERE user_id = ?");
    $stmt->execute([$userId]);
    $user_role = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user_role) {
        echo json_encode(['success' => false, 'message' => 'Role id not found']);
    }

    $roleId = $user_role['role_id'];

    // Check if the menu's role has the 'delete' permission for the specified module
    $stmt = $pdo->prepare("SELECT `delete` FROM permissions WHERE role_id = ? AND menu_id = ?");
    $stmt->execute([$roleId, $menu_id]);
    $permissions = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($permissions && $permissions['delete'] === 'yes') {
        // menu has permission, proceed with deletion
        $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            echo json_encode(['success' => false, 'message' => 'Record not found']);
        }

        $stmt = $pdo->prepare("DELETE FROM menus WHERE id = ?");
        $stmt->execute([$id]);

        echo json_encode(['success' => true, 'message' => 'Data deleted successfully']);
    } else {
        // Permission denied
        echo json_encode(['success' => false, 'message' => 'Permission denied']);
    }
} catch (Exception $e) {
    // Handle the exception
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
