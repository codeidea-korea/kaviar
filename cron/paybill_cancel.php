<?php
include_once(dirname(__DIR__)."/common.php");
include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
include_once(dirname(__DIR__)."/lib/my/sms.aligo.kakao.lib.php");

//무통장 자동취소
$timestamp = strtotime("-3 day");
$t_day = strtotime(date("Y-m-d H:i:s", $timestamp));

$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
$sms_content14 = $default['de_sms_cont14'];
$result = sql_query(" SELECT * FROM {$g5['g5_shop_order_table']} WHERE od_status = '주문' and od_settle_case in ('무통장', '가상계좌') and od_misu > 0 and od_receipt_price = 0 and unix_timestamp(od_time) < ".$t_day." " );
//$result = sql_query(" SELECT * FROM g5_shop_order WHERE od_status = '주문' " );

for ($i=0; $row=sql_fetch_array($result); $i++){

	$od_id = isset($row['od_id']) ? safe_replace_regex($row['od_id'], 'od_id') : '';

	// 장바구니 자료 취소
	sql_query(" update {$g5['g5_shop_cart_table']} set ct_status = '취소' where od_id = '$od_id' ");

	// 주문 취소
	$cancel_memo = ($row['od_settle_case'] == '가상계좌') ? "가상계좌 3일 경과 미입금 자동취소" : "무통장 3일 경과 자동취소";
	$cancel_price = $row['od_cart_price'];

	$sql = " update {$g5['g5_shop_order_table']}
				set od_send_cost = '0',
					od_send_cost2 = '0',
					od_receipt_price = '0',
					od_receipt_point = '0',
					od_misu = '0',
					od_cancel_price = '$cancel_price',
					od_cancel_type	= '$cancel_type',
					od_cart_coupon = '0',
					od_coupon = '0',
					od_send_coupon = '0',
					od_status = '취소',
					od_shop_memo = concat(od_shop_memo,\"\\n미입금 자동 취소 - ".G5_TIME_YMDHIS." (취소이유 : {$cancel_memo})\")
				where od_id = '$od_id' ";
	sql_query($sql);
	
	
	$sqls = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' ";
	$cresult = sql_query($sqls);
	for($k=0; $ct=sql_fetch_array($cresult); $k++) {
		// 재고를 이미 사용했다면 (재고에서 이미 뺐다면)
		$stock_use = $ct['ct_stock_use'];
		$ct_status = $ct['ct_status'];
		
		if ($ct['ct_stock_use'])
		{	
			
			if ($ct_status == '주문')
			{
				$stock_use = 0;
				// 재고에 다시 더한다.
				if($ct['io_id']) {
					$sql = " update {$g5['g5_shop_item_option_table']}
								set io_stock_qty = io_stock_qty + '{$ct['ct_qty']}'
								where it_id = '{$ct['it_id']}'
								  and io_id = '{$ct['io_id']}'
								  and io_type = '{$ct['io_type']}' ";
				} else {
					$sql = " update {$g5['g5_shop_item_table']}
								set it_stock_qty = it_stock_qty + '{$ct['ct_qty']}'
								where it_id = '{$ct['it_id']}' ";
				}

				sql_query($sql);
				
				$sql = " update {$g5['g5_shop_cart_table']}
							set ct_stock_use  = '$stock_use'
							where od_id = '$od_id'
							and ct_id  = '".$ct['ct_id']."' ";
				sql_query($sql);
			}
		}
		
	}
	
	
	// 주문취소 회원의 포인트를 되돌려 줌
	if ($row['od_receipt_point'] > 0)
		insert_point($row['mb_id'], $row['od_receipt_point'], "주문번호 $od_id 무통장 자동 취소");
	
	
	$sum_price = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];
	
	if ($row['mb_id']){
		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}else{
		$receive_numbers = $row['od_b_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}

	$sms_content14 = str_replace("{이름}", $row['od_name'], $sms_content14);
	$sms_content14 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content14);
	$sms_content14 = str_replace("{주문번호}", $row['od_id'], $sms_content14);
	$sms_content14 = str_replace("{주문금액}", number_format($sum_price), $sms_content14);
	
	$kresult = kakao_alim("TS_0387", $receive_number, $row['od_name'], $row['od_id'], "", "", "", "", "", "");
				
	if($kresult != 'Y'){
		//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
		aligo_sms_call($sms_content14, $receive_number, $send_number, "", "", "");
	}

	order_email_call('무통장자동취소', $row['od_email'], $row['mb_id'], $row['od_id'], $row['od_name'], $row['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content14);

}


?>
