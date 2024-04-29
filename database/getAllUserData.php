<?php

session_start(); // Start the session

require_once 'database.php';

// Define the SQL query using heredoc syntax
$table = <<<EOT
(SELECT users.*, roles.role FROM users JOIN user_role ON users.id = user_role.user_id JOIN roles ON user_role.role_id = roles.id) AS table1
EOT;

$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'username', 'dt' => 1),
    array('db' => 'email', 'dt' => 2),
    array('db' => 'mobile', 'dt' => 3),
    array('db' => 'role', 'dt' => 4),
);

$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'cloudone_project',
    'host' => 'localhost'
);

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
