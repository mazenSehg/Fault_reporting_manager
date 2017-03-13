<?php
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

if ( file_exists( ABSPATH . 'config.php') )
	require_once( ABSPATH . 'config.php' );

if ( file_exists( ABSPATH . INC .  '/functions.php') )
	require_once( ABSPATH . INC . '/functions.php' );

//Initialize DB
require_db();

//Call the all constant
require_once( ABSPATH . INC . '/constant.php');

//Call the all global classes
require_once( ABSPATH . INC . '/classes.php');

?>
