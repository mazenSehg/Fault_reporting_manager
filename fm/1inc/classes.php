<?php 
// if accessed directly than exit
if (!defined('ABSPATH')) exit;

if( !class_exists('User') ):
	require_once( ABSPATH . CONTENT . '/class/class.user.php');
endif;

$User = new User();

if( !class_exists('Profile') ):
	require_once( ABSPATH . CONTENT . '/class/class.profile.php');
endif;

$Profile = new Profile();

if( !class_exists('Settings') ):
	require_once( ABSPATH . CONTENT . '/class/class.settings.php');
endif;

$Settings = new Settings();

if( !class_exists('Centre') ):
	require_once( ABSPATH . CONTENT . '/class/class.centre.php');
endif;

$Centre = new Centre();

if( !class_exists('Equipment') ):
	require_once( ABSPATH . CONTENT . '/class/class.equipment.php');
endif;

$Equipment = new Equipment();

if( !class_exists('Fault') ):
	require_once( ABSPATH . CONTENT . '/class/class.fault.php');
endif;

$Fault = new Fault();

if( !class_exists('Header') ):
	require_once( ABSPATH . CONTENT . '/class/class.header.php');
endif;

$Header = new Header();

if( !class_exists('Footer') ):
	require_once( ABSPATH . CONTENT . '/class/class.footer.php');
endif;

$Footer = new Footer();
?>