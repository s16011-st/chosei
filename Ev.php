<?php
//変数を取得するファイルの読み込み
$e_id = $_GET['e_id'];
require_once( dirname(__FILE__)."/model/getValues.php" );
session_start();
$p_t_tsugo = $_SESSION['p_t_tsugo'];
$p_id = $_GET['p_id'];
?>

<!doctype HTML>
<HTML lang="ja">
<HEAD>
	<?php readfile( dirname(__FILE__)."/src/header.html" ); ?>
	<LINK href="./src/style.css" rel="stylesheet" type="text/css">
	<TITLE>出欠都合新規入力</TITLE>
</HEAD>
<BODY>
	回答者数：<?php echo $ninzu; ?>人
	<h1><?php echo $e_data[0]["e_name"]; ?></h1>

<div class="float">
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
	<?php } ?><br>
</div>

<div class="float">
	<h3><?php echo $p_t_tsugo[0]["p_name"]; ?>さんの出欠を編集</h3>
	<hr>
	<FORM action="./s.php?e_id=<?php echo $e_id."&p_id=".$p_id; ?>&proc=4" method="post">
	<h3>表示名</h3>
	表示に使用する名前を入力してください。<br>
		<input type="text" name="p_name" value="<?php echo $p_t_tsugo[0]["p_name"]; ?>" required><br><br>
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
			<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
				<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" value=3 ></td>
			<?php } ?>
		</tr>
		<tr>
			<td class="coltsugo">△</td>
			<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
				<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" value=2 ></td>
			<?php } ?>
		</tr>
		<tr>
			<td class="coltsugo">✕</td>
			<?php for( $i=0; $i<count($day_time); $i++ ){ ?>
				<td><input type="radio" name="<?php echo $day_time[$i]['s_id']; ?>" checked value=1 ></td>
			<?php } ?>
		</tr>
	</table><br>
	<h3>コメント</h3>
		<textarea name="p_comment"><?php echo $p_t_tsugo[0]["p_comment"] ; ?></textarea><br><br>
		<INPUT type="submit" value="更新する">
	</FORM>
</div>

<div class="float">
	<input type="button" onclick='location.href="./s.php?e_id=<?php echo $e_id."&p_id=".$p_id; ?>&proc=5"' value=登録を削除 />
</div>

</BODY>
</HTML>
