<?php
session_start();

require_once 'database.php';

// Extract entryId from the request
$id = $_POST['permissionId'];

// Retrieve the entry from the database
global $pdo;
$stmt = $pdo->prepare("SELECT * FROM permissions WHERE id = ?");
$stmt->execute([$id]);
$entry = $stmt->fetch(PDO::FETCH_ASSOC);

if ($entry) {
    echo json_encode(['data' => $entry]);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Entry not found']);
}