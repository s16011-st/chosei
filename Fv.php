<?php
session_start();
$event_data = $_SESSION['event_data'];
$event_day_time = $_SESSION['event_day_time'];
setcookie("organizer", "tes", time()+60*5);
var_dump($event_data);
var_dump($event_day_time);
?>
<HTML>
<HEAD>
	<TITLE>日程調整ページ編集画面</TITLE>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
	<h1>日程調整ページ編集</h1>
	<p>クッキー（日程調整ページ作成者識別）：<br>
		<?php echo $_COOKIE['organizer']; ?><br>
	<p>イベント名：<br>
		<?php echo $event_data[0]["name"]; ?><br>
	<p>メモ：<br>
		<?php echo $event_data[0]["memo"]; ?><br>
	<p>現在の日にち候補（削除する場合は選択）：<br>
		<?php
			for( $i=0; $i<count($event_day_time); $i++) {
				echo $event_day_time[$i]["day_time"]."<br>";
			}
		?><br>

	<p>＜変更する項目＞<br>
	<FORM action="./Gc.php" method="post">
		イベント名：<br><input type="text" name="event_name" /><br><br>
		追加の日にち候補:<br><textarea name="dates"></textarea><br><br>
		コメント:<br><textarea name="comment"></textarea><br><br>
		<INPUT type="submit" value="変更">
	</FORM>
	<a href = "./Fc.php">データ再取得</a>

</BODY>
</HTML>
