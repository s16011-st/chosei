<?php
//ステートメントオブジェクトから連想配列でごっそり値を取ってくる自作関数
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

function getList( $year, $month, $day, $flight_name ) {
 	$mysqli = new mysqli( 	'localhost', 'reservation', 'kickickic',
							'flight_db' );
	$sql = '
	SELECT
		flight_reservation.seat_class,
		flight_reservation.customer_id,
		customer_master.customer_name
	FROM
		flight_reservation,customer_master,flight_master
	WHERE
		flight_reservation.customer_id = customer_master.customer_id
		and flight_reservation.flight_id = flight_master.flight_id
		and year=? and month=? and day=?
		and flight_master.flight_name=? ';

	$stmt = $mysqli->prepare( $sql );
	$stmt->bind_param( 'iiis', $year, $month, $day, $flight_name );
	$stmt->execute();
	$result = fetch_all( $stmt );
	return $result;
	$stmt->close();
	$mysqli->close();
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
