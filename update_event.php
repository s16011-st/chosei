<?php
//model.php内の関数を使えるようにする（modelで値を加工する）
	include './model.php';

	$event_id = randomId();	//ランダムな16進数を生成する自作関数（1）
	echo $event_id."<br>";

	echo $_POST['event_name']."<br>";
	echo $_POST['dates']."<br>";
	echo $_POST['comment']."<br>";

	$dates = textToArray( $_POST['dates'] );	//改行ごとに配列に格納する自作関数（2）
	var_dump( $dates );

	$comment = textToArray( $_POST['comment'] );
	var_dump( $comment );
	echo $comment[1]."<br>";
	echo count( $comment );	//配列の数
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
