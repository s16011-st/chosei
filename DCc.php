<?php
	include './model.php';
	$e_id = $_GET['e_id'];
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );

//参加者登録、登録直後のp_id取得、そのp_idについて都合登録
	pRegistration( $_POST['p_name'], $_POST['p_comment'], $_GET['e_id'] );
	$p_id = getLastPid();

//複雑に散らばった参加者の都合に関する値をリネームして配列にまとめる
	for( $i=0; $i<count($day_time); $i++ ) {
		$tsugo[$i] = array(
			's_id' => $day_time[$i]['s_id'],
			'p_id' => $p_id[0]['p_id'],
			'tsugo' => $_POST[ $day_time[$i]['s_id'] ]
		);
	}

	for( $i=0; $i<count($day_time); $i++ ) {
		entryLastPidConvenience(
			$tsugo[$i]['s_id'], $tsugo[$i]['p_id'], $tsugo[$i]['tsugo']
		);
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
