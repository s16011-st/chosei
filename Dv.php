<?php
session_start();
$e_data = $_SESSION['e_data'];
$day_time = $_SESSION['day_time'];
$s_id = $day_time['s_id'];

/*
for( $i=0; $i<count($day_time); $i++ ) {
	$s_id[$i] = $day_time[$i]['s_id'];
}
*/
var_dump($s_id);
?>
<HTML>
<HEAD>
	<TITLE>日程調整ページ編集画面</TITLE>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
	<h1>出欠都合登録</h1>
	<h3>イベント名</h3>
		<?php echo $e_data[0]["e_name"]; ?><br>
	<h3>メモ</h3>
		<?php echo $e_data[0]["e_comment"]; ?><br><br>
	<h3>出欠を入力する</h3>
	<hr>
	<FORM action="./DCc.php?e_id=<?php echo $_GET['e_id']; ?>" method="post">
	<h3>表示名</h3>
		<input type="text" name="p_name" ><br>
	<h3>日にち候補</h3>
		<p><?php for( $i=0; $i<count($day_time); $i++) { ?>
			<input type="radio" name="<?php echo $s_id[$i] ?>" value="2"> ◯&nbsp;&nbsp;
			<input type="radio" name="<?php echo $s_id[$i] ?>" value="1"> △&nbsp;&nbsp;
			<input type="radio" name="<?php echo $s_id[$i] ?>" checked value="0"> ✕&nbsp;&nbsp;&nbsp;&nbsp;
		<?php echo $day_time[$i]["day_time"]."<br>"; } ?>
	<h3>コメント</h3>
		<textarea name="p_comment" ></textarea><br><br>
		<INPUT type="submit" value="出欠都合登録">
	</FORM>
$_POST[$_SESSION['day_time'][$i]['s_id']]
</BODY>
</HTML>
