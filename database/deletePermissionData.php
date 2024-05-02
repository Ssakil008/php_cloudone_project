<?php

try {
    session_start();

    require_once 'database.php';

    $id = $_POST['id'];
    $menu_id = $_POST['menuId'];
    $userId = $_SESSION['id'];

    $stmt = $pdo->prepare("SELECT role_id FROM user_role WHERE user_id = ?");
    $stmt->execute([$userId]);
    $userRole = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$userRole) {
        echo json_encode(['success' => false, 'message' => 'User role not found']);
        exit;
    }

    $roleId = $userRole['role_id'];

    // Check if the user's role has the 'delete' permission for the specified module
    $stmt = $pdo->prepare("SELECT `delete` FROM permissions WHERE role_id = ? AND menu_id = ?");
    $stmt->execute([$roleId, $menu_id]);
    $permissions = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($permissions && $permissions['delete'] === 'yes') {
        // User has permission, proceed with deletion
        $stmt = $pdo->prepare("SELECT * FROM permissions WHERE id = ?");
        $stmt->execute([$id]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$record) {
            echo json_encode(['success' => false, 'message' => 'Record not found']);
            exit;
        }

        $stmt = $pdo->prepare("DELETE FROM permissions WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['success' => true, 'message' => 'Data deleted successfully']);
    } else {
        // Permission denied
        echo json_encode(['success' => false, 'message' => 'Permission denied']);
    }
} catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
