<?php
session_start();

require_once 'database.php';

try {
    // Start transaction
    $pdo->beginTransaction();

    // Separate predefined fields and dynamic fields
    $predefinedFields = $_POST['predefinedFields'];
    $dynamicFields = $_POST['fields'];

    // Check if user ID is provided for updating existing user data
    $userId = $predefinedFields['userId'];

    // Handle predefined fields (direct insert or update)
    if ($userId) {
        $stmt = $pdo->prepare("SELECT * FROM credential_for_users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update existing user data
            $updateFields = [];
            foreach ($predefinedFields as $key => $value) {
                if ($key !== 'userId') {
                    $updateFields[] = "$key = ?";
                }
            }
            $updateFieldsString = implode(', ', $updateFields);
            $stmt = $pdo->prepare("UPDATE credential_for_users SET $updateFieldsString WHERE id = ?");
            $stmt->execute(array_values($predefinedFields));
        }
    } else {
        // Insert new user data
        $fields = implode(', ', array_keys($predefinedFields));
        $placeholders = rtrim(str_repeat('?, ', count($predefinedFields)), ', ');
        $stmt = $pdo->prepare("INSERT INTO credential_for_users ($fields) VALUES ($placeholders)");
        $stmt->execute(array_values($predefinedFields));
        $userId = $pdo->lastInsertId();
    }

    // Insert dynamic field data
    if (!empty($dynamicFields)) {
        $fields = [];
        foreach ($dynamicFields as $field) {
            $fields[] = "credential_for_user_id, field_name, field_value";
            $fields[] = "?, ?, ?";
            $values[] = $userId;
            $values[] = $field['field_name'];
            $values[] = $field['field_value'];
        }
        $fieldsString = implode(', ', $fields);
        $placeholders = rtrim(str_repeat('?, ', count($dynamicFields) * 3), ', ');
        $stmt = $pdo->prepare("INSERT INTO additional_information ($fieldsString) VALUES ($placeholders)");
        $stmt->execute($values);
    }

    // Commit transaction
    $pdo->commit();

    echo json_encode(['success' => true, 'message' => 'Data stored successfully.']);
} catch (PDOException $e) {
    // Rollback transaction on exception
    $pdo->rollBack();

    // Check if the exception is due to unique constraint violation
    if (strpos($e->getMessage(), 'Integrity constraint violation') !== false) {
        // Extract the duplicate entry value from the error message
        preg_match("/Duplicate entry '(.+)' for key/", $e->getMessage(), $matches);
        $errorMessage = "Duplicate entry '{$matches[1]}'";
    } else {
        // For other types of exceptions, use the default error message
        $errorMessage = $e->getMessage();
    }

    echo json_encode(['success' => false, 'error' => $errorMessage]);
}
