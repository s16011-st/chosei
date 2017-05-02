<?php
	include './model.php';
	$e_data = getEventData( $_GET['e_id'] );
	$day_time = getEventDaytime( $_GET['e_id'] );

	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;

	header( "Location: ./Cv.php?e_id=".$_GET['e_id'] );
	exit();
?>


<!--　材料置き場
//配列の中身を確認
	var_dump( 配列 );

//配列の数を返す
	count( 配列 );

//値をviewに渡す
	session_start();
	$_SESSION['result'] = $result;
	header( 'location: ./view.php' );
	exit();
-->
