<?php
	require_once( '../../model.php' );
	$e_id = $_GET['e_id'];
	$proc = $_GET['proc'];
	$e_data = getEventData( $e_id );
//ページ作成者だけにこのディレクトリの操作を許可する
	if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) {
		$day_time = getEventDaytime( $e_id );
		$p_sum = countParticipant( $e_id );
		$p_tsugo = getParticipantTsugo( $e_id );

		switch ( $proc ) {
			case '6':
				include( "./Fv.php" );
				break;
			case '7':
				$new_e_name = $_POST['new_e_name'];
				$new_e_comment = $_POST['new_e_comment'];
				$delete_s_id = $_POST['delete_s_id'];
				$new_day_time = textToArray( $_POST['new_dates'] );
			//イベント情報更新
				updateEvent( $e_id, $new_e_name, $new_e_comment );
			//候補日程の削除
				for( $i=0; $i<count($delete_s_id); $i++ ) {
					deleteDayTime( $delete_s_id[$i] );
				}
			//候補日程の追加があれば追加
				if( !empty($new_day_time) ) {
					for( $i=0; $i<count($new_day_time); $i++ ) {
						organizeDayTime( $e_id, $new_day_time[$i] );
					}
				}
				header( "Location: ../../s.php?e_id=$e_id&proc=0" );
				break;
			case '8':
				if( $result = deleteEvent( $e_id ) ) {
					header( "Location: ./delete/complete.php");
				} else {
					header( "Location: ./delete/error.php");
				}
				break;
		}
	} else {
		header( "Location: ../../Hv.php" );
	}
?>
