<?php
//model.php内の関数を使えるようにする（modelで値を加工する）
	include './model.php';
	$event_data = getEventData( st2 );
	$event_day_time = getEventDaytime( st2 );

	session_start();
	$_SESSION['event_data'] = $event_data;
	$_SESSION['event_day_time'] = $event_day_time;

	header( 'Location: ./Fv.php' );
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
