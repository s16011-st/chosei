<html>
<head>
	<TITLE>イベント作成</TITLE>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</head>
<body>

<h1>イベントを作る</h1>
<FORM action="./ABc.php" method="post">
	<!-- 幾つか改行だけ入れた実質空白が、requiredのフィルターをくぐり抜ける -->
<div class="float">
	<h3>[step1]&nbsp;日にち候補</h3>
	<textarea name="dates" required ></textarea><br><br>
</div>
<div class="float">
	<h3>[step2]&nbsp;イベント名</h3>
	<input type="text" name="e_name" required ><br><br>
</div>
<div class="float">
	<h3>[step3]&nbsp;メモ</h3>
	<textarea name="e_comment"></textarea><br><br>
	<INPUT type="submit" value="イベントを作る">
</div>
</FORM>

</body>
</html>
