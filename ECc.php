<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$p_id = $_GET['p_id'];
	$proc = $_GET['proc'];
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );

//更新処理の場合
	if( $proc == 1 ) {
//その参加者の情報を更新
		updateParticipant( $p_id, $_POST['p_name'], $_POST['p_comment'] );

//複雑に散らばった参加者の都合に関する値をリネームして配列にまとめる
		for( $i=0; $i<count($day_time); $i++ ) {
			$tsugo[$i] = array(
				's_id' => $day_time[$i]['s_id'],
				'p_id' => $p_id,
				'tsugo' => $_POST[ $day_time[$i]['s_id'] ]
			);
		}
//その参加者の都合を更新
		for( $i=0; $i<count($day_time); $i++ ) {
			updateTsugo(
				$tsugo[$i]['s_id'], $tsugo[$i]['p_id'], $tsugo[$i]['tsugo']
			);
		}
//削除の場合
	} else if( $proc ==2 ){
		deleteParticipant( $p_id );
		deleteTsugo( $p_id );
	}


//更新情報を取得
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );

	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;
	$_SESSION['p_sum'] = $p_sum;

	header( "Location: ./Cv.php?e_id=".$_GET['e_id'] );
	exit();
?>
