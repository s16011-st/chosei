<?php
	session_start();
	$e_data = $_SESSION['e_data'];
	$day_time = $_SESSION['day_time'];
	$e_id = $_GET['e_id'];

//参加者0のときは$p_sumの各値がNULLなので、0を格納?
//イマイチ納得言ってないので、バグのもと
	if( !($p_sum = $_SESSION['p_sum']) ) {
		$ninzu = 0;
		for( $i=0; $i<count($day_time); $i++ ) {
			$p_sum[$i]["◯"]=0;
			$p_sum[$i]["△"]=0;
			$p_sum[$i]["✕"]=0;
		}
	} else {
		$ninzu = $p_sum[0]["◯"] + $p_sum[0]["△"] + $p_sum[0]["✕"];
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

<input type="button" onclick="location.href='./CDc.php?e_id=<?php echo $_GET['e_id']; ?>'" value="出欠を入力する" >

</body>
</html>
