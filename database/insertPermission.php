<?php

// Start the session
session_start();

require_once 'database.php';

try {
    // Retrieve data from POST
    $roleId = $_POST['role_id'];
    $menuId = $_POST['menu'];
    $read = $_POST['read'] ?? 'no'; // Set default value if not provided
    $create = $_POST['create'] ?? 'no'; // Set default value if not provided
    $edit = $_POST['edit'] ?? 'no'; // Set default value if not provided
    $delete = $_POST['delete'] ?? 'no'; // Set default value if not provided
    $id = isset($_POST['permissionId']) ? $_POST['permissionId'] : null;

    // Validate data
    if (empty($roleId) || empty($menuId)) {
        echo json_encode(['success' => false, 'message' => 'Role ID and menu ID are required.']);
        exit;
    }

    if (empty($id)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO permissions (`role_id`, `menu_id`, `read`, `create`, `edit`, `delete`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $roleId);
        $stmt->bindParam(2, $menuId);
        $stmt->bindParam(3, $read);
        $stmt->bindParam(4, $create);
        $stmt->bindParam(5, $edit);
        $stmt->bindParam(6, $delete);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Permission added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add permission.']);
        }
    } else {
        // Update
        $stmt = $pdo->prepare("UPDATE permissions SET `role_id` = ?, `menu_id` = ?, `read` = ?, `create` = ?, `edit` = ?, `delete` = ? WHERE `id` = ?");
        $stmt->bindParam(1, $roleId);
        $stmt->bindParam(2, $menuId);
        $stmt->bindParam(3, $read);
        $stmt->bindParam(4, $create);
        $stmt->bindParam(5, $edit);
        $stmt->bindParam(6, $delete);
        $stmt->bindParam(7, $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Permission updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update permission.']);
        }
    }

  } catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
