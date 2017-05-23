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
</table>
