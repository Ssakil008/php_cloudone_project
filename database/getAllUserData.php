<?php

session_start(); // Start the session

require_once 'database.php';

// Define the SQL query to select from the view
$table = 'user_role_view';

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
    'db'   => 'tech_vault',
    'host' => 'localhost'
);

require('ssp.class.php');

echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
