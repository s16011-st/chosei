<?php session_start(); ?>
<html>
<head>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1>日程調整ページ作成結果</h1>

<?php echo $_SESSION['message']; ?>
<a href="<?php echo $_SESSION['url']; ?>">
	<?php echo $_SESSION['url']; ?>
</a><br><br><br>

<a href = "./Av.php">日程調整ページ作成画面に戻る</a>

</body>
</html>
