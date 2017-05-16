<?php
	require_once( './model.php' );
	$e_id = $_GET['e_id'];
	$proc = $_GET['proc'];

	switch ( $e_id ) {
//e_idが指定されていなければ、日程調整ページ作成画面へ
		case "":
			header( "Location: ./schedule/newEvent/" );
			break;
		default:
//登録されていれば最新情報を取得
		if( $e_data = getEventData( $e_id ) ) {
			$day_time = getEventDaytime( $e_id );
			$p_sum = countParticipant( $e_id );
			$p_tsugo = getParticipantTsugo( $e_id );
//日程調整ページトップ画面表示
			switch ( $proc ) {
				case '0':
					include( "./Cv.php" );
					break;
//都合入力画面表示
				case '1':
					include( "./Dv.php" );
					break;
//登録してトップ画面へ戻る
				case '2':
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
				//都合をDBに登録
					for( $i=0; $i<count($day_time); $i++ ) {
						entryLastPidConvenience(
							$tsugo[$i]['s_id'], $tsugo[$i]['p_id'], $tsugo[$i]['tsugo']
						);
					}
				//更新情報を取得
					$e_data = getEventData( $e_id );
					$day_time = getEventDaytime( $e_id );
					$p_sum = countParticipant( $e_id );
					$p_tsugo = getParticipantTsugo( $e_id );
				//トップページに戻る
					include( "./Cv.php" );
					break;
//選択した参加者の都合を取得して編集画面へ
				case '3':
					$p_id = $_GET['p_id'];
					//その参加者の登録情報・都合を取得
					if( $p_t_tsugo = getTheParticipantTsugo( $e_id, $p_id ) ) {
						include( "./Ev.php" );
					//p_idをいじって都合取得できなかったらエラーページに飛ばす
					} else {
						header( "Location: ./Hv.php" );
					}
					break;
//その参加者の情報を更新
				case '4':
					$p_id = $_GET['p_id'];
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
				//更新情報を取得
					$e_data = getEventData( $e_id );
					$day_time = getEventDaytime( $e_id );
					$p_sum = countParticipant( $e_id );
					$p_tsugo = getParticipantTsugo( $e_id );
				//トップページに戻る
					include( "./Cv.php" );
					break;
//その参加者の都合を削除
				case '5':
					$p_id = $_GET['p_id'];
					deleteParticipantTsugo( $p_id );
				//削除後の情報を取得
					$e_data = getEventData( $e_id );
					$day_time = getEventDaytime( $e_id );
					$p_sum = countParticipant( $e_id );
					$p_tsugo = getParticipantTsugo( $e_id );
				//トップページに戻る
					include( "./Cv.php" );
					break;
//日程調整ページの編集画面へ遷移
				case '6':
					if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) {
						header( "Location: ./schedule/editEvent/index.php?e_id=".$e_id );
					}
					break;
//procが指定されたもの以外ならばエラーページへ
				default:
					header( "Location: ./Hv.php" );
					break;
			}
//登録されてなければエラーページ表示
		} else {
			header( "Location: ./Hv.php" );
		}
		break;
	}
	exit();
?>
