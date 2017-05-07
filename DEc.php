<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$p_id = $_GET['p_id'];

//イベント情報を取得
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );
	$p_tsugo = getParticipantTsugo( $e_id );

//その参加者の登録情報・都合を取得
	$p_t_tsugo = getTheParticipantTsugo( $e_id, $p_id );

	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;
	$_SESSION['p_sum'] = $p_sum;
	$_SESSION['p_tsugo'] = $p_tsugo;
	$_SESSION['p_t_tsugo'] = $p_t_tsugo;

	header( "Location: ./Ev.php?e_id=".$e_id."&p_id=".$p_id );
	exit();
?>
