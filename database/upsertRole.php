<?php
session_start();

require_once 'database.php';

try {
    // Retrieve the id from the request
    $id = isset($_POST['roleId']) ? $_POST['roleId'] : null;
    $role = $_POST['role'];
    $description = $_POST['description'];

    // Validate input
    if (empty($role) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Role and description are required.']);
    }

    if (empty($id)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO roles (role, description) VALUES (:role, :description)");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Role added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add role.']);
        }
    } else {
        // Update
        $stmt = $pdo->prepare("UPDATE roles SET role = :role, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true, 'message' => 'Role updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update role.']);
        }
    }
} catch (PDOException $e) {
    // Handle the exception
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
