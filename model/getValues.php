<?php
//直接アクセスさせない
if( array_shift( get_included_files() ) === __FILE__ ) {
	die( 'エラー：　正しいURLを指定してください。' );
}

require_once( dirname(__FILE__)."/model.php" );
if( $e_data = getEventData( $e_id ) ) {
	$day_time = getEventDaytime( $e_id );
	$p_sum = countParticipant( $e_id );
	$p_tsugo = getParticipantTsugo( $e_id );

	$ninzu = $p_sum[0]["◯"] + $p_sum[0]["△"] + $p_sum[0]["✕"];
	//登録者なしのときは値がない（NULL）ので、0を格納する
	if( !$ninzu ){
		$ninzu = 0;

	//出欠都合を 3 →◯, 2 →△, 1 →✕, 0 →""に変換
	} else {
		for( $i=0; $i<$ninzu*count($day_time); $i++){
			if( (int)$p_tsugo[$i]["tsugo"] === 3 ) {
				$p_tsugo[$i]["tsugo"] = "◯";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 2 ) {
				$p_tsugo[$i]["tsugo"] = "△";
			} else if( (int)$p_tsugo[$i]["tsugo"] === 1 ) {
				$p_tsugo[$i]["tsugo"] = "✕";
			} else if( $p_tsugo[$i]["tsugo"] == null ) {
				$p_tsugo[$i]["tsugo"] = "";
			}
		}
	}
} else {
	header( "Location: ./Hv.php" );
}

?>
