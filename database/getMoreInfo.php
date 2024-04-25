<?php
session_start();

require_once 'database.php';

try {
    // Extract id from the request
    $id = $_POST['userId'];

    // Retrieve data from the database
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM additional_information WHERE credential_for_user_id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($data)) {
        http_response_code(404);
        echo json_encode(['error' => 'Additional Information is empty']);
        exit;
    }

    // Modify field_name values
    foreach ($data as &$item) {
        $item['field_name'] = formatFieldName($item['field_name']);
    }
    unset($item);

    echo json_encode(['data' => $data]);
} catch (Exception $e) {
    // Handle the exception
    echo json_encode(['error' => $e->getMessage()]);
}

function formatFieldName($fieldName)
{
    // Remove underscores, hyphens, and other symbols
    $formattedFieldName = str_replace(['_', '-'], ' ', $fieldName);

    // Separate words in camelCase
    $formattedFieldName = preg_replace('/(?<!^)([A-Z][a-z]|(?<=[a-z])[A-Z])/', ' $1', $formattedFieldName);

    // Capitalize the first letter of each word
    $formattedFieldName = ucwords($formattedFieldName);

    return $formattedFieldName;
}
