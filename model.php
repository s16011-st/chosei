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
// 2つ以上の3種類の改行を1つ1種類の改行に置換後、文頭文末の空白を削除
	$text = trim( preg_replace( "/(\r\n){2,}|\r{2,}|\n{2,}/", "\n", $text ) );
	$array = explode("\n", $text);	//改行区切りで配列に格納
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
//(C,D)出欠都合の集計
function countParticipant( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT x.day_time,
		count( y.tsugo=2 or null ) as "◯",
		count( y.tsugo=1 or null ) as "△",
		count( y.tsugo=0 or null ) as "✕"
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

//(C→D)そのイベントの参加者の都合を取得
function getParticipantTsugo( $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT
	z.p_id, z.p_name, x.day_time, y.tsugo, z.p_comment
	FROM
	( t_schedule x LEFT OUTER JOIN t_tsugo y USING(s_id))
	INNER JOIN t_participant z USING(p_id)
	WHERE x.e_id = ?
	ORDER BY z.p_id, x.day_time, y.tsugo';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 's', $e_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(D→C)参加者登録
function pRegistration( $p_name, $p_comment, $e_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = ' INSERT INTO t_participant( p_name, p_comment, e_id ) VALUES( ?, ?, ? )';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'sss', $p_name, $p_comment, $e_id );
	if( $stmt->execute() ) {
		$result = "参加者登録完了";
	} else {
		$result = "参加者登録エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}
//(D→C)今登録した参加者のp_id取得
function getLastPid() {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'SELECT p_id FROM t_participant ORDER BY p_id DESC LIMIT 1';
	$stmt = $mysqli->prepare( $sql );
//	$stmt->bind_param();
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}
//(D→C)いま登録した参加者の都合を登録
function entryLastPidConvenience( $s_id, $p_id, $tsugo ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = ' INSERT INTO t_tsugo( s_id, p_id, tsugo ) VALUES( ?, ?, ? )';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssi', $s_id, $p_id, $tsugo );
	if( $stmt->execute() ) {
		$result = "都合登録完了";
	} else {
		$result = "都合登録エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}

//(D→E)その参加者の都合を取得
function getTheParticipantTsugo( $e_id, $p_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = '
	SELECT
	z.p_id, z.p_name, x.day_time, y.tsugo, z.p_comment
	FROM
	( t_schedule x LEFT OUTER JOIN t_tsugo y USING(s_id))
	INNER JOIN t_participant z USING(p_id)
	WHERE x.e_id = ? and y.p_id = ?
	ORDER BY z.p_id, x.day_time, y.tsugo';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'si', $e_id, $p_id );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
}

//(E→C)参加者情報を削除
function deleteParticipant( $p_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'DELETE FROM t_participant WHERE p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'i', $p_id );
	if( $stmt->execute() ) {
		$result = "削除完了";
	} else {
		$result = "削除エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}
//(E→C)参加者都合を削除
function deleteTsugo( $p_id ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'DELETE FROM t_tsugo WHERE p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'i', $p_id );
	if( $stmt->execute() ) {
		$result = "削除完了";
	} else {
		$result = "削除エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}

//(E→C)その参加者の情報更新
function updateParticipant( $p_id, $p_name, $p_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_participant SET p_name = ?, p_comment = ? WHERE p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssi', $p_name, $p_comment, $p_id );
	if( $stmt->execute() ) {
		$result = "更新完了";
	} else {
		$result = "更新エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}
//(E→C)その参加者の都合更新
function updateTsugo( $s_id, $p_id, $tsugo ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_tsugo SET tsugo = ? WHERE s_id = ? and p_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'iii', $tsugo, $s_id, $p_id );
	if( $stmt->execute() ) {
		$result = "都合更新完了";
	} else {
		$result = "都合更新エラー！！！";
	}	return $result;
	$stmt->close();
	$mysqli->close();
}

//(F→C)イベント情報の更新
function updateEvent( $e_id, $new_e_name, $new_e_comment ) {
	$mysqli = new mysqli( 'localhost', 'bteam', 'kickobe', 'chosei_db' );
	$sql = 'UPDATE t_event SET e_name = ?, e_comment = ? WHERE e_id = ?';
	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'ssi', $e_name, $e_comment, $e_id );
	if( $stmt->execute() ) {
		$result = "更新完了";
	} else {
		$result = "更新エラー！！！";
	}	return $result;
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
