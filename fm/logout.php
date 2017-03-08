<?php
	session_start();
	//Load all functions
	require_once('load.php');

	remove_current_user();
	$uri = $_SERVER['HTTP_REFERER'];	
	header("location:".$uri);
	exit();
?>