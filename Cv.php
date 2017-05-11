<?php
	session_start();
	$e_id = $_GET['e_id'];
	$e_data = $_SESSION['e_data'];
	if( $e_id !== $e_data[0]['e_id'] ) {
		header( 'Location: ./Hv.php' );
	}
	$day_time = $_SESSION['day_time'];
	$p_sum = $_SESSION['p_sum'];
	$p_tsugo = $_SESSION['p_tsugo'];
	$ninzu = $p_sum[0]["◯"] + $p_sum[0]["△"] + $p_sum[0]["✕"];
//登録者なしのときは値がない（NULL）ので、0を格納する
	if( !$ninzu ){
		$ninzu = 0;

//出欠都合を 2 →◯, 1 →△, 0 →✕ に変換
	} else {
		for( $i=0; $i<$ninzu*count($day_time); $i++){
			if( (int)$p_tsugo[$i]["tsugo"] === 2 ) {
				$p_tsugo[$i]["tsugo"] = "◯";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 1 ) {
				$p_tsugo[$i]["tsugo"] = "△";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 0 ) {
				$p_tsugo[$i]["tsugo"] = "✕";
			}
		}
	}
?>

<HTML>
<HEAD>
	<TITLE>日程調整ページトップ</TITLE>
	<LINK href="./style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>
<?php if( $_COOKIE[$e_id] === $e_data[0]["organizer_id"] ) { ?>
	あなたが幹事のイベントです。
	<input type="button" onclick="location.href='./CFc.php?e_id=<?php echo $_GET['e_id']; ?>'" value="イベント編集" >
<?php } ?>

<br><br>回答者数：<?php echo $ninzu; ?>人
<h1><?php echo $e_data[0]["e_name"]; ?></h1>
<h3>イベントの詳細説明</h3>
	<?php echo $e_data[0]["e_comment"]; ?><br><br>
<h3>日にち候補</h3>
<table>
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
<?php if( $ninzu!=0 ){ ?>
	<table>
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
<!-- 参加者の名前にe_idと参加者各々のp_idをつけて./CEc.phpに飛べるリンクを張る-->
			<td class = "colparticipant">
				<a href = "./DEc.php?e_id=<?php echo $e_data[0]["e_id"]; ?>
					&p_id=<?php echo $p_tsugo[$i]["p_id"]; ?>" >
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
<?php } ?><br>

<input type="button" onclick="location.href='./CDc.php?e_id=<?php echo $_GET['e_id']; ?>'" value="出欠を入力する" >

</body>
</html>
