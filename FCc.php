<?php
	include './model.php';
	$e_id = $_GET['e_id'];

if( $e_data = getEventData( $e_id ) ) {
	$new_e_name = $_POST['new_e_name'];
	$new_e_comment = $_POST['new_e_comment'];
	$delete_s_id = $_POST['delete_s_id'];
	$new_day_time = textToArray( $_POST['new_dates'] );
	var_dump($new_day_time);
	var_dump( empty($new_day_time) );


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


//更新後のイベントに関するデータを取得してCに移動
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );
	$p_tsugo = getParticipantTsugo( $e_id );

	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;
	$_SESSION['p_sum'] = $p_sum;
	$_SESSION['p_tsugo'] = $p_tsugo;
	$_SESSION['test'] = $test;
	header( "Location: ./Cv.php?e_id=".$e_id );
	exit();

//e_idが登録されていない場合、H)エラーページへ
} else {
	header( "Location: ./Hv.php" );
	exit();

}
?>
