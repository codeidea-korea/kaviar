<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__)."/lib/my/fcm.lib.php");

	//완료 2일된 상품에대해서 후기 유도하기
	$now = date('Y-m-d H:i:s',time());
	$day_3ago = date('Y-m-d',strtotime($now."-3 day"));     // 3일전

	$result = sql_query("select * from `g5_shop_order` where od_status = '완료' and date(od_result_date) = '".$day_3ago."' ");

	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$result_cart = sql_fetch("select count(*) as cnt from `g5_shop_cart` where ct_status = '완료' and od_id = '".$row['od_id']."' ");
		
		if($result_cart['cnt'] > 0){

			$result_member = sql_fetch("select mb_mobile_token,mb_no from `g5_member` where mb_id = '".$row['mb_id']."' ");
			$push_token = $result_member['mb_mobile_token'];
			$push_content = $config_apppush['app_push4'];
			$push_content = str_replace("{적립금}", $default['de_item_use_review_p'], $push_content);

			if($push_token){

				fcm_send($push_token, $push_content);
				
				$sql_log = " insert `g5_member_push`
							set mb_no   = '".$result_member['mb_no']."',
								mb_id   = '".$row['mb_id']."',
								mb_message = '".$push_content."',
								mb_result = '',
								insertdate = '".G5_TIME_YMDHIS."' ";
				sql_query($sql_log);
			}

		}
	}
?>