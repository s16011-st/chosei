<html><body>
<?php
var_dump( $_POST['event_name'] );
var_dump( $_POST['dates'] );
var_dump( $_POST['comment'] );

$text1 = $_POST['dates'];      // テキストエリアの値
$cr = array("\r\n", "\r");   // 改行コード置換用配列
$text1 = trim($text);         // 文頭文末の空白を削除
$text1 = str_replace($cr, "\n", $text1);  // 改行コードを統一
$lines1 = explode("\n", $text1);
var_dump( $lines1 );

$text = $_POST['dates'];      // テキストエリアの値
$cr = array("\r\n", "\r");   // 改行コード置換用配列
$text = trim($text);         // 文頭文末の空白を削除
$text = str_replace($cr, "\n", $text);  // 改行コードを統一
$lines = explode("\n", $text);
var_dump( $lines );
?>
</body></html>
<!--
	include './model.php';
    $result = getResv( 	$_POST['year'], $_POST['month'], $_POST['day'],
       					$_POST['departure'], $_POST['arrival'] );

    session_start();
    $_SESSION['result']     = $result;
    $_SESSION['year']		= $_POST['year'];
    $_SESSION['month']      = $_POST['month'];
    $_SESSION['day']        = $_POST['day'];
    $_SESSION['departure']	= $_POST['departure'];
    $_SESSION['arrival']	= $_POST['arrival'];

	header( 'location: ../view/view7.php' );
	exit();
	*/
-->
