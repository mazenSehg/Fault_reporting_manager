<?php
if($_SERVER['SERVER_ADDR'] == '10.161.146.74' || $_SERVER['SERVER_ADDR'] == '10.161.128.46') {
	$db_name = 'fault_management';
	$db_user = 'fault_user';
	$db_password = 'fault_user';
	$db_host = '10.161.128.46';
	$webpath = 'WebProjects/fault_reporting_php/nccpm_faultreporting_php/fm';
	if($_SERVER['SERVER_ADDR'] == '10.161.146.74' ) {
		$db_user = 'fault_user';
		$db_password = 'fault_user';
		$db_host = '10.161.128.194';
		$webpath = 'faults';
	}
	define('DB_NAME', $db_name);
	define('DB_USER', $db_user);
	define('DB_PASSWORD', $db_password);
	define('DB_HOST', $db_host);
	define( 'INC', 'inc' );
	define( 'CONTENT', 'content' );
	define('WEBPATH', $webpath);
} else {
	define('DB_NAME', 'fault-management');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');
	define( 'INC', 'inc' );
	define( 'CONTENT', 'content' );
	define('WEBPATH','fm');
}

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/*
DIDNT UPLOAD SO HAD TO DO THIS TO MAKE CHANGES SO SOURCETREE COULD RECOGNISE...
*/

?>
