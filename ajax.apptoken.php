<?php
include_once('common.php');

$mb_id = $_POST['mb_id'] ? $_POST['mb_id'] : $member['mb_id'];
$device_token = $_POST['device_token'] ? $_POST['device_token'] : '';

if($mb_id){
	$mbs = sql_fetch("select * from g5_member where mb_id = '".$mb_id."' ");

	//토큰값이 없을경우
	if($mbs['mb_mobile_token'] == ''){
		
		sql_query("update g5_member set mb_mobile_token = '".$device_token."' where mb_id = '".$mb_id."' ");
	
	}else{
		//토큰값이 다른경우 업데이트
		if($device_token != $mbs['mb_mobile_token']){

			sql_query("update g5_member set mb_mobile_token = '".$device_token."' where mb_id = '".$mb_id."' ");
		}
	}

}

?>