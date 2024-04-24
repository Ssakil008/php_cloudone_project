<?php
session_start(); // Start the session

// Include the database configuration file
require_once 'database.php';

$table = 'credential_for_servers';

$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'credential_for',  'dt' => 1),
    array('db' => 'email',   'dt' => 2),
    array('db' => 'mobile', 'dt' => 3,),
    array('db' => 'url', 'dt' => 3,),
    array('db' => 'ip_address', 'dt' => 3,),
    array('db' => 'username', 'dt' => 3,),
    array('db' => 'password', 'dt' => 3,),
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
?>

?>