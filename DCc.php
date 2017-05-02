<?php
	include './model.php';
	$e_data = getEventData( $_GET['e_id'] );
	$day_time = getEventDaytime( $_GET['e_id'] );
	$p_sum = countParticipant( $_GET['e_id'] );
	var_dump( $p_sum );
	var_dump( $_POST[$_SESSION['day_time']['s_id']] );

/*
	session_start();
	$_SESSION['e_data'] = $e_data;
	$_SESSION['day_time'] = $day_time;

	header( 'Location: ./Dv.php?e_id=<?php echo $_GET['e_id']; ?>' );
	exit();
?>
	session_start();
	$_SESSION['result'] = $result;
	header( 'Location: ./Dv.php' );
	exit();
*/
?>

<!--　材料置き場
//配列の中身を確認
	var_dump( 配列 );

//配列の数を返す
	count( 配列 );

//値をviewに渡す
	session_start();
	$_SESSION['result'] = $result;
	header( 'location: ./view.php' );
	exit();
-->
