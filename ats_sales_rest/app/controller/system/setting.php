<?php 

date_default_timezone_set('UTC');

//Database
Flight::register('dbMain', 'PDO', array('mysql:host=184.107.179.178;dbname=ats_sales','admin','admin'), function($dbMain){
	$dbMain->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbMain->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
});

Flight::register('dbData', 'PDO', array('mysql:host=184.107.179.178;dbname=app_data_2016','admin','admin'), function($dbData){
	$dbData->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbData->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
});


//Api
$keys = array(
	'49xSgp6MDZFV3wb2' => 'Testing',
	'CjXSJrGje33Njj4G' => 'Reserve'
);

//Api Version
Flight::set('api_key', $keys);
Flight::set('api_version', 'v1');


?>	
