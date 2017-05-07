<?php session_start();
$message = $_SESSION['message'];
$url = $_SESSION['url'];
$e_id = $_SESSION['e_id'];

?>
<html>
<head>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1>日程調整ページ作成結果</h1>

<?php
	echo $message."<br><br>";
	echo $url."<br>";
?>
<br>
<input type="button" onclick='location.href="./BCc.php?e_id=<?php echo $e_id; ?>"' value=イベントページを表示 />
<br><br><br><br>
<a href = "./Av.php">日程調整ページ作成画面に戻る</a>

</body>
</html>
