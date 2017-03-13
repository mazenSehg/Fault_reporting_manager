<?php
session_start();
require_once('load.php');

if(is_user_logged_in()):
	$uri = site_url().'/dashboard/';
else:
	$uri = site_url().'/login/';
endif;

header("location:".$uri);
die();
?>
