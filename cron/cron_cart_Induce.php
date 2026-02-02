<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__)."/lib/my/fcm.lib.php");

	//3일동안 카트에 있는경우 푸쉬 발송
	$now = date('Y-m-d H:i:s',time());
	$day_3ago = date('Y-m-d',strtotime($now."-3 day"));     // 3일전

	$result = sql_query("select * from `g5_shop_cart` where ct_status = '쇼핑' and mb_id != '' and date(ct_time) = '".$day_3ago."' group by od_id ");


	for ($y=0; $row=sql_fetch_array($result); $y++) {
		
		$result_member = sql_fetch("select mb_mobile_token,mb_no from `g5_member` where mb_id = '".$row['mb_id']."' ");

		//배송시 PUSH발송 토큰 / 내용
		$sql = " select * from `g5_shop_cart` where od_id = '".$row['od_id']."' ";
		$od_cart = sql_query($sql);
		$product = "";
		$product_qty = 0;
		
		for ($i=0; $rowi=sql_fetch_array($od_cart); $i++){
			
			if($i == 0){
				$price = ($rowi['ct_price'] + $rowi['io_price']) * $rowi['ct_qty'];
				$product = $rowi['it_name']."(".$rowi['ct_option'].")";
			}else{
				$product_qty++;
			}
		}

		if($product_qty > 0){
			$product .= " 외 ".$product_qty."EA ";
		}

		$push_content = str_replace("{상품명}", $product, $config_apppush['app_push5']);
		$push_token = $result_member['mb_mobile_token'];

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
?>