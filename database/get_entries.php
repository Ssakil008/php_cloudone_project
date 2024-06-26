<?php
session_start(); // Start the session

$table = 'credential_for_servers';

$primaryKey = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'credential_for',  'dt' => 1),
    array('db' => 'email',   'dt' => 2),
    array('db' => 'mobile', 'dt' => 3,),
    array('db' => 'url', 'dt' => 4,),
    array('db' => 'ip_address', 'dt' => 5,),
    array('db' => 'username', 'dt' => 6,),
    array('db' => 'password', 'dt' => 7,),
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
