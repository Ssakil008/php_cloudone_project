<?php
// Start session
session_start();

// Include the database configuration file
require_once 'database.php';

// Assuming $email and $password are obtained from the user input via POST request
$email = $_POST['email'];
$password = $_POST['password'];

try {
    // Prepare SQL statement to select user based on email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verify user's password
    if ($user && password_verify($password, $user['password'])) {
        $stmt = $pdo->prepare("SELECT * FROM user_role WHERE user_id = ?");
        $stmt->execute([$user['id']]);
        $role = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $pdo->prepare("SELECT * FROM permissions WHERE role_id = ?");
        $stmt->execute([$role['role_id']]);
        $permissions = $stmt->fetch(PDO::FETCH_ASSOC);

        // User authenticated successfully

        // Store user data in session
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['mobile'] = $user['mobile'];
        $_SESSION['permissions'] = $permissions;

        // Return success message
        echo json_encode(['success' => true, 'message' => 'User authenticated successfully']);
    } else {
        // User authentication failed
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
} catch (PDOException $e) {
    // Handle database connection errors or query errors
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
