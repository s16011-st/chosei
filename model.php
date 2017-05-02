<?php

//（A）ランダムな変数を生成する2通りの方法
function randomId(){
	$bytes = openssl_random_pseudo_bytes( 8, $cstrong );
	$hex = bin2hex( $bytes );	//ランダムなバイナリコードを16進数に変換
	return $hex;
}
function randomId2(){
	$md5 = md5( date( "YmdD His" ) );	//日時からハッシュ値を生成
	$str = substr( $md5, 0, 10 );
	echo $str;
}

//（A）テキストを配列に変える
function textToArray( $text ) {
	$cr = array("\r\n", "\r");   // 改行コード置換用配列
	$text = trim($text);         // 文頭文末の空白を削除
	$text = str_replace($cr, "\n", $text);  // 改行コードを統一
	$array = explode("\n", $text);
	return $array;
}

//(A)新規日程調整ページ作成
function organizeEvent( $e_id, $organizer_id, $e_name, $e_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'INSERT INTO t_event VALUES( ?, ?, ?, ? )';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssss', $e_id, $organizer_id, $e_name, $e_comment );
	if( $stmt->execute() ) {
		$result = "OK!";
	} else {
		$result = "ERROR！";
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(A→B)新規日にち候補登録
function organizeDayTime( $e_id, $day_time ){
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'INSERT INTO t_schedule( e_id, day_time ) VALUES( ?, ? )';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ss', $e_id, $day_time );
	if( $stmt->execute() ) {
		$result = "日程調整ページ作成完了<br>イベントIDは".$e_id."<br>";
	} else {
		$result = "ERROR";
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(C→D,CDE→F)登録されているイベント情報を渡す
function getEventData( $e_id ) {
 	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'SELECT * FROM t_event WHERE e_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(C→D,CDE→F)登録されているイベントの日にち情報を渡す
function getEventDaytime( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'SELECT * FROM t_schedule WHERE e_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(D-F将来的にはCも)出欠都合の集計
function countParticipant( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT x.day_time,
		count( y.tsugo=2 or null ) as "maru",
		count( y.tsugo=1 or null ) as "sankaku",
		count( y.tsugo=0 or null ) as "batsu"
	FROM t_schedule x LEFT OUTER JOIN t_tsugo y
	ON x.s_id = y.s_id
	WHERE x.e_id = ?
	GROUP BY x.day_time';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(allFunction)ステートメントオブジェクトから連想配列で値を取り出す
function fetch_all(& $stmt) {
	$hits = array();
	$params = array();
	$meta = $stmt->result_metadata();
	while( $field = $meta->fetch_field() ) {
		$params[] = &$row[ $field->name ];
	}
	call_user_func_array( array( $stmt, 'bind_result' ), $params );
	while( $stmt->fetch() ) {
		$c = array();
		foreach( $row as $key => $val ) {
			$c[ $key ] = $val;
		}
		$hits[] = $c;
	}
	return $hits;
}

function getResv( $year, $month, $day, $departure, $arrival ) {
    $mysqli = new mysqli( 'localhost', 'reservation', 'kickickic', 'flight_db' );
    $sql = '
	SELECT
		flight_master.flight_id,flight_master.flight_name,flight_master.time,
		count( ( year=? and month=? and day=?
			and flight_reservation.seat_class=0 ) or null ) as business,
		count( ( year=? and month=? and day=?
    		and flight_reservation.seat_class=1 ) or null ) as economy
	FROM
		flight_master inner join flight_reservation on
		flight_master.flight_id = flight_reservation.flight_id
	WHERE
		departure_place=? and arrival_place=?
	GROUP BY flight_master.flight_name';

	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'iiiiiiss',
		$year, $month, $day, $year, $month, $day, $departure, $arrival );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}


function putResv( $year,$month, $day, $customer_id, $flight_id, $seat_class ) {
    $mysqli = new mysqli( 'localhost', 'reservation', 'kickickic', 'flight_db' );
    $sql = '
	INSERT INTO	flight_reservation(
		year, month, day, customer_id, flight_id, seat_class )
	VALUES( ?, ?, ?, ?, ?, ? ) ';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'iiiiii',
		$year, $month, $day, $customer_id, $flight_id, $seat_class );
	if( $stmt->execute() ) {
		$result = "予約完了しました";
	} else {
		$result = "ERROR";
	}
	return $result;
	$stmt->close();
	$mysqli->close();
}

function registMem( $customer_id, $password, $customer_name ) {
    $mysqli = new mysqli( 'localhost', 'reservation', 'kickickic', 'flight_db' );
    $sql = '
    INSERT INTO customer_master VALUES( ?, ?, ? ) ';
    $stmt = $mysqli->prepare( $sql );
    $stmt->bind_param( 'iss', $customer_id, $password, $customer_name );
    if( $stmt->execute() ) {
        $result = "顧客登録完了";
    } else {
        $result = "登録エラー";
    }
    return $result;
    $stmt->close();
    $mysqli->close();

}

?>
