<?php

/*
	include './model.php';
	$new_e_name = $_POST['new_e_name'];
	$new_e_comment = $_POST['new_e_comment'];
	$delete_s_id =
	for( $i=0)
	$new_day_time = textToArray( $_POST['new_dates'] );


	updateEvent( $e_id, $new_e_name, $new_e_comment )
	for( $i=0; $i<count($new_day_time); $i++ ) {
		deleteDayTime( $e_id, $new_day_time[$i] );
	}
		for( $i=0; $i<count($new_day_time); $i++ ) {
		organizeDayTime( $e_id, $new_day_time[$i] );
	}

	session_start();
	$_SESSION['message'] = $message;
	$_SESSION['url'] = $url;
	$_SESSION['e_id'] = $e_id;
	header( 'Location: ./Bv.php' );
	exit();

?>
<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );

アップデート処理の関数をモデルに書いて、ここで使う
順番が大事かと思う。


	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;
	$_SESSION['p_sum'] = $p_sum;

	header( "Location: ./Cv.php?e_id=".$e_id );
	exit();
*/
?>
