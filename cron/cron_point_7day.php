<?php
	include_once(dirname(__DIR__)."/common.php");
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.lib.php');
	include_once(dirname(__DIR__).'/lib/my/sms.aligo.kakao.lib.php');

	//포인트 만료 7일전에 sms발송
	$now = date('Y-m-d H:i:s',time());
	$day_7ago = date('Y-m-d',strtotime($now."+7 day"));     // 3일전

	$sql = " select mb_id
                from {$g5['point_table']}
                where po_expired = '0'
                  and po_expire_date <> '9999-12-31'
                  and po_expire_date = '".$day_7ago."' ";
    $result = sql_query($sql);

	for ($i=0; $row=sql_fetch_array($result); $i++) {

		$sqls = " select sum(po_point - po_use_point) as sum_point
					from {$g5['point_table']}
					where po_expired = '0'
					  and po_expire_date <> '9999-12-31'
					  and po_expire_date = '".$day_7ago."'
					  and mb_id = '".$row['mb_id']."' ";
		$ccc = sql_fetch($sqls);
		
		$expire_point = $ccc['sum_point'];
	
		if($expire_point > 0 && $row['mb_id']) {
		
			$mb = get_member($row['mb_id']);

			$sms_content12 = $default['de_sms_cont12'];
			$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
			$receive_numbers = $mb['mb_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
			
			$sms_content12 = str_replace("{이름}", $mb['mb_name'], $sms_content12);
			$sms_content12 = str_replace("{소멸적립금}", $expire_point, $sms_content12);
			$sms_content12 = str_replace("{소멸예정일}", $day_7ago, $sms_content12);
		
			if($config['cf_sms_use'] == "aligo"){
				aligo_sms_call($sms_content12, $receive_number, $send_number, "", "", "");
			}
		
		}
	}


?>