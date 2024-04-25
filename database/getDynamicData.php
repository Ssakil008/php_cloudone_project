<?php
session_start(); // Start the session

// Include the database configuration file
require_once 'database.php';

$table = 'credential_for_users';

$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'name',  'dt' => 1),
    array('db' => 'email',   'dt' => 2),
    array('db' => 'mobile', 'dt' => 3),
    array('db' => 'password', 'dt' => 4),
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
