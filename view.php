<?php
	session_start();
	$result = $_SESSION['result'];
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<HTML>
<HEAD>
    <TITLE>page7</TITLE>
	<LINK href="../css/style.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY>

    <h1>予約状況</h1>
    <h3>日付：	<?php echo $_SESSION['year'] ?>年
				<?php echo $_SESSION['month'] ?>月
				<?php echo $_SESSION['day'] ?>日</h3>
    <h3>出発地：<?php echo $_SESSION['departure'] ; ?></h3>
	<h3>到着地：<?php echo $_SESSION['arrival']; ?></h3>

	<table>
		<col width=120><col width=120><col width=180><col width=180>
        <tr><th>便名</th><th>出発時刻</th>
		<th>ビジネスクラス</th>	<th>エコノミークラス</th></tr>
<?php
	for( $i=0; $i<count( $result ); $i++ ){
		if ( $result[$i]["business"]==0 ) { 		$tempbus='○';
		} else if ( $result[$i]["business"]==1 ) {	$tempbus='△';
										} else { 	$tempbus='×'; }
		if ( $result[$i]["economy"]<6 ) { 			$tempeco='○';
		} else if ( $result[$i]["economy"]<10 ) { 	$tempeco='△';
										} else { 	$tempeco='×'; }
?>
        <tr>
            <td><?php echo $result[$i]["flight_name"]; ?></td>
            <td><?php echo $result[$i]["time"]; ?> </td>
            <td><?php echo $tempbus; ?> </td>
            <td><?php echo $tempeco; ?> </td>
        </tr>

<?php  } ?>
    </table>
	<p>○：空席あり　　△：残りわずか　　×：満席　　　　
	<a href='../page7.php'> → 検索画面に戻る</a><br>

	<h2><a href='../member/page7_2.php'>ログインして予約する</a></h2>
</BODY>
</HTML>
