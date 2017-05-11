<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$result = deleteEvent( $e_id );

	session_start();
	$_SESSION['result'] = $result;
	header( "Location: ./Gv.php");
	exit();
?>
