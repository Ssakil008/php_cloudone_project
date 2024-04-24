<?php
session_start(); // Start the session

// Clear all session variables
$_SESSION = [];

// Destroy the session
session_destroy();

// Optionally, regenerate the session ID to prevent session fixation attacks
session_regenerate_id(true);

// Return a JSON response indicating success
echo json_encode(['success' => true]);
?>
