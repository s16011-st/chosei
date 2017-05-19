<?php
//旧ABc.phpです
	require_once( '../../model.php' );
	$e_id = randomId();
	$organizer_id = randomId();
	$e_name = $_POST['e_name'];
	$e_comment = $_POST['e_comment'];
	$day_time = textToArray( $_POST['dates'] );
	setcookie( $e_id, $organizer_id, time()+10800, "/chosei/", FALSE );
	if( $e_name && !empty($day_time) ) {
		if(
			organizeEvent( $e_id, $organizer_id, $e_name, $e_comment )
		) {
			$message = "日程調整ページ作成完了！　URLは ⇩";
			$url = "https://(IPアドレス)/chosei/s.php?e_id=".$e_id;
			organizeDayTime( $e_id, $day_time );
		}
	} else {
		$message = 'えらー。イベント名か日付が空白です。';
		$url = '';
	}
	include( "./Bv.php" );
	exit();
?>
