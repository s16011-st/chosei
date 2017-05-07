<?php
	include './model.php';
	$e_id = randomId();
	$organizer_id = randomId();
	$e_name = $_POST['e_name'];
	$e_comment = $_POST['e_comment'];
	$day_time = textToArray( $_POST['dates'] );
	setcookie( $e_id, $organizer_id, time()+10800 );
	var_dump($day_time);

	if( $e_name ) {
		if(
			organizeEvent( $e_id, $organizer_id, $e_name, $e_comment )
		) {
			$message = "日程調整ページ作成完了！　URLは ⇩";
			$url = "./BCc.php?e_id=".$e_id;
			for( $i=0; $i<count($day_time); $i++ ) {
				organizeDayTime( $e_id, $day_time[$i] );
			}
		}
	} else if( $day_time == "" ) {
		$message = 'えらー。イベント名か日付が空白です。';
		$url = '';
	}

	session_start();
	$_SESSION['message'] = $message;
	$_SESSION['url'] = $url;
	$_SESSION['e_id'] = $e_id;
	header( 'Location: ./Bv.php' );
	exit();

?>
