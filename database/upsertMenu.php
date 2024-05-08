<?php
session_start();

require_once 'database.php';

try {
    // Access the PDO object from database.php
    global $pdo;

    // Assign variables
    $menuId = isset($_POST['menuId']) ? $_POST['menuId'] : null;
    $name = $_POST['name'];
    $link = $_POST['link'];

    // Prepare SQL statement
    if (empty($menuId)) {
        // Insertion
        $stmt = $pdo->prepare("INSERT INTO menus (name, link) VALUES (:name, :link)");
        $stmt->execute([':name' => $name, ':link' => $link]);
        $lastInsertId = $pdo->lastInsertId();

        // Insert permissions
        $stmt_perm = $pdo->prepare("INSERT INTO permissions (`role_id`, `menu_id`, `read`, `create`, `edit`, `delete`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_perm->execute([1, $lastInsertId, 'yes', 'yes', 'yes', 'yes']);
    } else {
        // Update
        $stmt = $pdo->prepare("UPDATE menus SET name = :name, link = :link WHERE id = :menuId");
        $stmt->execute([':name' => $name, ':link' => $link, ':menuId' => $menuId]);
    }

    $rowCount = $stmt->rowCount();

    if ($rowCount === 0) {
        echo json_encode(['success' => false, 'message' => 'Menu Id not found']);
        exit; // Terminate script execution
    }

    echo json_encode(['success' => true, 'message' => 'Menu ' . ($menuId ? 'updated' : 'added') . ' successfully']);
} catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
} catch (PDOException $e) {
    // Handle the exception
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
