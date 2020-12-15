<?php
$table = 'massive';
$primaryKey = 'id';
$columns = array(
	array( 'db' => 'id',         'dt' => 0 ),
	array( 'db' => 'firstname',  'dt' => 1 ),
	array( 'db' => 'surname',    'dt' => 2 ),
	array( 'db' => 'zip',        'dt' => 3 ),
	array( 'db' => 'country',    'dt' => 4 )
);
$sql_details = array(
	'user' => '',
	'pass' => '',
	'db'   => '',
	'host' => ''
);
require( '../../../../examples/server_side/scripts/ssp.class.php' );
echo json_encode(
	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
