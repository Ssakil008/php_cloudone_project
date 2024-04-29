<?php
session_start(); // Start the session

$table = 'menus';

$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'name',  'dt' => 1),
    array('db' => 'link',   'dt' => 2),
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
