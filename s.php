<html>
<head>
        <meta name="viewport" content="width=device-width,maximum-scale=1"/>
        <LINK href="./src/style.css" rel="stylesheet" type="text/css">
</head>
</html>


<?php
	require_once( './model.php' );
	$e_id = $_GET['e_id'];
	$proc = $_GET['proc'];

	switch ( $e_id ) {
//(→A(create.php)）e_idが指定されていなければ、日程調整ページ作成画面へ
		case "":
			header( "Location: ./schedule/newEvent/" );
			break;
		default:
//(共通)登録されていれば最新情報を取得
		if( $e_data = getEventData( $e_id ) ) {
			$day_time = getEventDaytime( $e_id );
			$p_sum = countParticipant( $e_id );
			$p_tsugo = getParticipantTsugo( $e_id );
//日程調整ページトップ画面表示
			switch ( $proc ) {
				case '0':
//					include( "./Cv.php" );
					goto Cv;
					break;
//都合入力画面表示
				case '1':
					include( "./Dv.php" );
					break;
//登録してトップ画面へ戻る
				case '2':
				//参加者の入力した都合情報をリネームして配列にまとめる
					for( $i=0; $i<count($day_time); $i++ ) {
						$tsugo[$i] = array(
							's_id' => $day_time[$i]['s_id'],
							'tsugo' => $_POST[ $day_time[$i]['s_id'] ]
						);
					}
					enterParticipantTsugo( $_POST['p_name'], $_POST['p_comment'], $e_id, $tsugo );
					goto Cv;
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
					goto Cv;
					break;
//その参加者の都合を削除
				case '5':
					$p_id = $_GET['p_id'];
					deleteParticipantTsugo( $p_id );
					goto Cv;
					break;
//日程調整ページの編集画面へ遷移
				case '6':
					if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) {
						header( "Location: ./schedule/editEvent/edit.php?e_id=".$e_id."&proc=6" );
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

Cv:
//更新情報を取得
	$e_data = getEventData( $e_id );
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );
	$p_tsugo = getParticipantTsugo( $e_id );
//トップページに戻る
	include( "./Cv.php" );
	exit();
?>
