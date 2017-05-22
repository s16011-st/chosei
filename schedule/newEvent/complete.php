<?php
//旧Bvです
$e_id = $_GET['e_id'];
require_once( dirname(__FILE__)."/../../model/getValues.php" );
?>

<html>
<head>
	<TITLE>イベント作成完了</TITLE>
	<meta name="viewport" content="width=device-width,maximum-scale=1"/>
	<LINK href="../../src/style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1>日程調整ページ作成結果</h1>

<p>日程調整ページ作成完了！　URLは ⇩</p><br>
<p>https://(IPアドレス)/chosei/Cv.php?e_id=<?php echo $e_id; ?></p><br>
<input type="button" onclick='location.href="../../Cv.php?e_id=<?php echo $e_id; ?>"' value=イベントページを表示 />
<br><br><br><br>

<a href = "./Av.php">日程調整ページ作成画面に戻る</a>

</body>
</html>
