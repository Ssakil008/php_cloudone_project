<?php
session_start();

require_once 'database.php';

try {
    // Retrieve the id from the request
    $id = $_POST['entryId'];

    // Check if id is empty to determine if it's an insert or update
    if (empty($id)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO credential_for_servers (credential_for, email, mobile, url, ip_address, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)");

        $stmt->execute([
            $_POST['credential_for'],
            $_POST['email'],
            $_POST['mobile'],
            $_POST['url'],
            $_POST['ip_address'],
            $_POST['username'],
            $_POST['password']
        ]);

        echo json_encode(['success' => true, 'message' => 'New entry added successfully.']);
    } else {
        // Update
        $stmt = $pdo->prepare("UPDATE credential_for_servers SET credential_for=?, email=?, mobile=?, url=?, ip_address=?, username=?, password=? WHERE id=?");

        $stmt->execute([
            $_POST['credential_for'],
            $_POST['email'],
            $_POST['mobile'],
            $_POST['url'],
            $_POST['ip_address'],
            $_POST['username'],
            $_POST['password'],
            $id
        ]);

        echo json_encode(['success' => true, 'message' => 'Entry updated successfully.']);
    }
} catch (Exception $e) {
    // Handle the exception
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
