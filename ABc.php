<?php
	include './model.php';
	$e_id = randomId();
	$organizer_id = randomId();
	$e_name = $_POST['e_name'];
	$e_comment = $_POST['e_comment'];
	$day_time = textToArray( $_POST['dates'] );

	if( $e_name ) {
		if(
			organizeEvent( $e_id, $organizer_id, $e_name, $e_comment )
		) {
			$message = "日程調整ページ作成完了！　URLは ⇩<br><br>";
			$url = "http://localhost/choseisan/BCc.php?e_id=".$e_id;
			for( $i=0; $i<count($day_time); $i++ ) {
				organizeDayTime( $e_id, $day_time[$i] );
			}
		}
	} else {
		$message = 'えらー。イベント名を入れたまい。';
		$url = '';
	}

	session_start();
	$_SESSION['message'] = $message;
	$_SESSION['url'] = $url;
	header( 'Location: ./Bv.php' );
	exit();
?>

<!--　材料置き場
//配列の中身を確認
	var_dump( 配列 );

//配列の数を返す
	count( 配列 );

//値をviewに渡す
	session_start();
	$_SESSION['url'] = $url;
	header( 'location: ./view.php' );
	exit();
-->
