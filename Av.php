<!doctype HTML>
<html>
<head>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- Internet Explorer 8 以前のバージョンのための対策 -->

	<!-- 旧Av.phpです -->
	<TITLE>イベント作成</TITLE>
	<!--LINK href="./src/style.css" rel="stylesheet" type="text/css"-->
</head>

<body>

	<!--jQueryのインストール-->
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<!--カレンダーのデザイン設定-->
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/redmond/jquery-ui.css" >
	<!--datepickerの設定-->
	<script src="./src/datepicker.js"></script>
	<script src="./src/datepicker-ja.js"></script>

<h1>イベントを作る</h1>
<div class="container-fluid">
	::before
<FORM action="./schedule/newEvent/create.php" method="post">
<div id="datepicker" class="col-md-4">
	<h3>[step1]&nbsp;日にち候補</h3>
	<textarea id="date_val" name="dates" required></textarea>
</div>
<div class="col-md-4">
	<h3>[step2]&nbsp;イベント名</h3>
	<input type="text" name="e_name" required ><br><br>
</div>
<div class="col-md-4">
	<h3>[step3]&nbsp;メモ</h3>
	<textarea name="e_comment"></textarea><br><br>
	<INPUT type="submit" value="イベントを作る">
</div>
</FORM>
	::after
</div>
</body>
</html>
