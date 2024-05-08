<?php

require_once 'database.php';

try {
    // Access the PDO object from database.php
    global $pdo;

    // Validate request data
    $errors = validateRequest($_POST);

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit; // Terminate script execution
    }

    // Assign variables
    $userId = isset($_POST['userId']) ? $_POST['userId'] : null; // Check if 'userId' exists in $_POST
    $username = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = isset($_POST['password']) ? $_POST['password'] : null; // Check if 'password' exists in $_POST
    $roleId = $_POST['role'];

    // Hash the password if it is not null
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : null;

    // Prepare SQL statement
    if (empty($userId)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO users (username, email, mobile, password) VALUES (?, ?, ?, ?)");
    } else {
        // Update
        if ($password) {
            // Update password only if it is not null
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, mobile = ?, password = ? WHERE id = ?");
        } else {
            // Exclude password from the update statement
            $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, mobile = ? WHERE id = ?");
        }
        $stmt->bindParam(':userId', $userId);
    }

    // Bind parameters
    $stmt->bindParam(1, $username);
    $stmt->bindParam(2, $email);
    $stmt->bindParam(3, $mobile);
    if ($password) {
        $stmt->bindParam(4, $hashedPassword);
        $stmt->bindParam(5, $userId);
    } else {
        // If password is null, adjust the binding index accordingly
        $stmt->bindParam(4, $userId);
    }
    $stmt->execute();

    $lastInsertId = $pdo->lastInsertId();

    $rowCount = $stmt->rowCount();

    if ($rowCount === 0) {
        echo json_encode(['success' => false, 'message' => 'User Id not found']);
        exit; // Terminate script execution
    }

    // If userId exists, update the user_role record
    if (!empty($userId)) {
        $stmt = $pdo->prepare("UPDATE user_role SET role_id = ? WHERE user_id = ?");
        $stmt->bindParam(1, $roleId);
        $stmt->bindParam(2, $userId);
        $stmt->execute();
    } else {
        $stmt = $pdo->prepare("INSERT INTO user_role (user_id, role_id) VALUES (?, ?)");
        $stmt->bindParam(1, $lastInsertId);
        $stmt->bindParam(2, $roleId);
        $stmt->execute();
    }

    // echo success response
    echo json_encode(['success' => true, 'message' => 'User ' . ($userId ? 'updated' : 'added') . ' successfully']);
} catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

function validateRequest($postData)
{
    // Validate request data
    $errors = [];

    if (empty($postData['username'])) {
        $errors[] = 'Username is required';
    }

    if (empty($postData['email'])) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    }

    if (empty($postData['userId'])) {
        if (empty($postData['password'])) {
            $errors[] = 'Password is required';
        } elseif (strlen($postData['password']) < 8) {
            $errors[] = 'Password must be at least 8 characters long';
        }
    } elseif (!empty($postData['password']) && strlen($postData['password']) < 8) {
        $errors[] = 'Password must be at least 8 characters long';
    }

    if (empty($postData['role'])) {
        $errors[] = 'Role ID is required';
    }

    return $errors;
}
