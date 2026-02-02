<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.kakao.lib.php');

	//입력된 값에 따라 자동배송처리
	$now = date('Y-m-d H:i:s',time());
	$chk_day = $now."-".$config['cf_auto_done']." day";
	$day_3ago = date('Y-m-d',strtotime($chk_day));     // 3일후

	$result = sql_query(" select * from `g5_shop_order` where od_status = '배송' AND od_invoice_time < '".$day_3ago."' ");


	for ($i=0; $row=sql_fetch_array($result); $i++) {
		

		$sql = " update {$g5['g5_shop_order_table']} set od_status = '완료' where od_id = '".$row['od_id']."' and od_status = '배송' ";
		sql_query($sql, true);

		$sql = " update {$g5['g5_shop_cart_table']} set ct_status = '완료' where od_id = '".$row['od_id']."' and ct_status = '배송' ";
		sql_query($sql, true);

		$od_total_price = $row['od_cart_price'] + $row['od_send_cost'] + $row['od_send_cost2'];


		$sms_content11 = $default['de_sms_cont11'];

		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

		$sms_content11 = str_replace("{이름}", $row['od_name'], $sms_content11);
		$sms_content11 = str_replace("{회원아이디}", $row['mb_id'], $sms_content11);
		$sms_content11 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content11);
		$sms_content11 = str_replace("{주문번호}", $row['od_id'], $sms_content11);
		$sms_content11 = str_replace("{주문금액}", number_format($row['od_total_price']."원"), $sms_content11);
		$sms_content11 = str_replace("{주문일자}", $row['od_time'], $sms_content11);
		/*
		if($config['cf_sms_use'] == "aligo"){
			
			$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

			//알림톡발송
			$kresult = kakao_alim("TS_0385", $row['od_hp'], $row['od_name'], $row['od_id'], "", "", "", "", "", "");
				
			if($kresult != 'Y'){
				aligo_sms_call($sms_content11, $receive_number, $send_number, "", "", "");
			}

			order_email_call('배송완료', $row['od_email'], $row['mb_id'], $row['od_id'], $row['od_name'], $row['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content11);

		}else if($config['cf_sms_use'] == "naver"){
		

		}*/


		//취소시 등급조절하기  //준섭
		$order_grade_price = $od_total_price; 	//주문한금액 $_POST['od_total_price']
		$order_grade_mdid = $row['mb_id'];			//구매자 아이디
		
		//주문완료된 금액 확인하기
		$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
		//현재등급 가져오기
		$mb_grades = sql_fetch(" select mb_grade,mb_first_coupon from `g5_member` where mb_id = '".$order_grade_mdid."' ");
		//등급으로 제한금액 가져오기
		//echo "<br><br>mb_grades :: ".$mb_grades['mb_grade']."<br><br>";
		$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");

		
		//총구매금액
		$tot_price_g = $result_price['od_price'];

		if($tot_price_g < $grade_limit['g_reward_start']){//종료금액보다 크면 등급상승

			$sql_members = " update `g5_member` set mb_grade = mb_grade - 1 where mb_id = '".$order_grade_mdid."' ";
			//echo "<br><br>하락하락update :: ".$sql_members."<br><br>";
			sql_query($sql_members);

		}


		//첫 구매 감사 무료배송 쿠폰 
		if($mb_grades['mb_first_coupon'] == 'N') {

			$j = 0;
			$create_coupon = false;

			do {
				$cp_id = get_coupon_id();

				$sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
				$row3 = sql_fetch($sql3);

				if(!$row3['cnt']) {
					$create_coupon = true;
					break;
				} else {
					if($j > 20)
						break;
				}
			} while(1);

			if($create_coupon) {
				$cp_subject = '첫 구매 감사 무료배송 쿠폰';
				$cp_method = 3;
				$cp_target = '';
				$cp_start = G5_TIME_YMD;
				$cp_end = date("Y-m-d", (G5_SERVER_TIME + (86400 * 30)));
				$cp_type = 0;
				$cp_price = 4000;
				$cp_trunc = 1;
				$cp_minimum = 10000;
				$cp_maximum = 0;

				$sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
							( cp_id, cp_subject, cp_method, cp_target, mb_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
						VALUES
							( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."' ) ";

				$res = sql_query($sql, false);

				$sql_members = " update `g5_member` set mb_first_coupon = 'Y' where mb_id = '".$order_grade_mdid."' ";
				sql_query($sql_members);

				if($res)
					set_session('ss_member_reg_coupon', 1);
			}
		}

	}

	
?>