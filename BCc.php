<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );

	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;
	$_SESSION['p_sum'] = $p_sum;

	header( "Location: ./Cv.php?e_id=".$e_id );
	exit();
?>
