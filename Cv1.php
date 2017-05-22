<?php
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
require_once( dirname(__FILE__)."/model/getValues.php" );
?>

<HTML>
<HEAD>
	<TITLE>日程調整ページトップ</TITLE>	
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

<BODY>
	<div class="container">
<?php if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) { ?>
	あなたが幹事のイベントです。
	<input type="button" onclick='location.href="./s.php?e_id=<?php echo $e_id; ?>&proc=6"' value="イベント編集" >
<?php } ?>

<br><br>回答者数：<?php echo $ninzu; ?>人
<h1><?php echo $e_data[0]["e_name"]; ?></h1>
<h3>イベントの詳細説明</h3>
	<?php echo $e_data[0]["e_comment"]; ?><br><br>
<h3>日にち候補</h3>
<table class="table">
	<tr>
		<th>都合</th>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<th>".$day_time[$i]["day_time"]."</th>";
		} ?>
	</tr>
	<tr>
		<td class="coltsugo">◯</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["◯"]."人</td>";
		}
		?>
	</tr>
	<tr>
		<td class="coltsugo">△</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["△"]."人</td>";
		}
		?>
	</tr>
	<tr>
		<td class="coltsugo">✕</td>
		<?php
		for( $i=0; $i<count($day_time); $i++ ){
			echo "<td>".$p_sum[$i]["✕"]."人</td>";
		}
		?>
	</tr>
</table><br>

<!--参加者の都合-->
<?php //if( $ninzu!==0 ){ ?>
	<table class="table">
		<tr>
			<th>参加者</th>
			<?php
			for( $i=0; $i<count($day_time); $i++ ){
				echo "<th>".$day_time[$i]["day_time"]."</th>";
			} ?>
			<th>コメント</th>
		</tr>
		<?php for( $i=0; $i<$ninzu*count($day_time); $i=$i+count($day_time) ) { ?>
		<tr>
<!-- 参加者の名前にe_idと参加者各々のp_idをつけて都合の編集画面に飛べるリンクを張る-->
			<td class = "colparticipant">
				<a href = "./s.php?e_id=<?php echo $e_data[0]["e_id"]; ?>
					&p_id=<?php echo $p_tsugo[$i]["p_id"]; ?>&proc=3" >
					<?php echo $p_tsugo[$i]["p_name"]; ?>
				</a>
			</td>
			<?php for( $j=$i; $j<$i+count($day_time); $j++){
				echo "<td>".$p_tsugo[$j]["tsugo"]."</td>";
			} ?>
			<td class="p_comment">
				<?php echo $p_tsugo[$i]["p_comment"]; ?>
			</td>
		</tr>
		<?php } ?>
	</table><br>
<?php// } ?><br>

<input type="button" onclick="location.href='./s.php?e_id=<?php echo $e_id; ?>&proc=1'" value="出欠を入力する" >
</div>
</body>
</html>
