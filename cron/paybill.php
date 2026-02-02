<?php
include_once(dirname(__DIR__)."/common.php");
include_once(dirname(__DIR__)."/lib/my/sms.aligo.lib.php");
include_once(dirname(__DIR__)."/lib/my/sms.aligo.kakao.lib.php");

//무통장 입금요청
$timestamp = strtotime("-4 hour");
$f_hour = strtotime(date("Y-m-d H:i:s", $timestamp));

$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
$sms_content13 = $default['de_sms_cont13'];
$result = sql_query(" SELECT * FROM g5_shop_order WHERE od_status = '주문' and od_b_hp != '' and od_cnt = 0 and unix_timestamp(od_time) < ".$f_hour." " );

//echo " SELECT * FROM g5_shop_order WHERE od_status = '주문' and unix_timestamp(od_time) < ".$f_hour." ";

for ($i=0; $row=sql_fetch_array($result); $i++){
	
	
	$receive_numbers = $row['od_b_hp'];
	$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

	$sms_content13 = str_replace("{이름}", $row['od_name'], $sms_content13);
	$sms_content13 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content13);
	$sms_content13 = str_replace("{주문번호}", $row['od_id'], $sms_content13);
	
	$sum_price = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];	
	$sms_content13 = str_replace("{주문금액}", number_format($sum_price), $sms_content13);

//echo "2 : ".$row['od_hp']."<br>";
	//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
	
	//aligo_sms_call($sms_content13, $receive_number, $send_number, "", "", "");
	
	sql_query(" insert into `g5_smschk` set content = '".$sms_content13."' , receiver_number = '".$receive_number."', send_number = '".$send_number."', od_id = '".$row['od_id']."', regdate = '".date("Y-m-d H:i:s")."' " );
	
	//order_email_call('입금요청', $row['od_email'], $row['mb_id'], $row['od_id'], $row['od_name'], $row['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content13);

	//알림톡발송 주문완료
	$i_price= $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];
	kakao_alim("TS_0386", $receive_number, $row['od_name'], $row['od_id'], $i_price, "", "", "", "", "");
	
	$cnts = $row['od_cnt'] + 1;
	sql_query(" update `g5_shop_order` set od_cnt = ".$cnts." where od_id = '".$row['od_id']."' " );
	
	//echo "3 : ".$cnts."<br>";
	//echo "4 : update `g5_shop_order` set od_cnt = ".$cnts." where od_id = '".$row['od_id']."' <br>";
	
	sql_query(" insert into `sms_log` set od_id = '".$row['od_id']."' , od_name = '".$row['od_name']."', od_hp = '".$row['od_b_hp']."', od_receiver_number = '".$receive_number."', regdate = '".date("Y-m-d H:i:s")."' " );
	
	$receive_number = "";


}


?>