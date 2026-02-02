<?php
include_once('common.php');


$result = sql_query(" select * from `g5_member` where mb_id like 'ka_%'");

for ($i=0; $row=sql_fetch_array($result); $i++) {
	$iden = explode("_",$row['mb_id']);
	
	if($iden[0] == "ka"){
		sql_query(" insert into `g5_member_social_profiles` set mb_id = '".$row['mb_id']."', provider = 'kakao', identifier = '".$iden[1]."', displayname= '".$row['mb_name']."', mp_register_day = '".$row['mb_datetime']."' " );
	
		echo $i." :: ".$row['mb_id']." :: ".$iden[1]." :: ".$iden[0]."<br>";
	}
}

?>