<?php
session_start();

require_once 'database.php';

try {
    // Extract entryId from the request
    $id = $_POST['userId'];

    // Retrieve the entry from the database
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM user_role_view WHERE id = ?");
    $stmt->execute([$id]);
    $entry = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($entry) {
        echo json_encode(['data' => $entry]);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Entry not found']);
    }
} catch (PDOException $e) {
    // Handle the exception
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
