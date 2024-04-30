<?php
session_start();

require_once 'database.php';

try {
    // Retrieve the id from the request
    $id = $_POST['roleId'];
    $role = $_POST['role'];
    $description = $_POST['description'];

    // Validate input
    if (empty($role) || empty($description)) {
        return json_encode(['success' => false, 'message' => 'Role and description are required.']);
    }

    if (empty($id)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO roles (role, description) VALUES (:role, :description)");
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        // Return response for insertion
        if ($stmt->rowCount() > 0) {
            return json_encode(['success' => true, 'message' => 'Role added successfully.']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to add role.']);
        }
    } else {
        // Update
        $stmt = $pdo->prepare("UPDATE roles SET role = :role, description = :description WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        // Return response for update
        if ($stmt->rowCount() > 0) {
            return json_encode(['success' => true, 'message' => 'Role updated successfully.']);
        } else {
            return json_encode(['success' => false, 'message' => 'Failed to update role.']);
        }
    }
} catch (PDOException $e) {
    // Handle the exception
    return json_encode(['success' => false, 'message' => $e->getMessage()]);
}
