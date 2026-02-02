<?php
$sub_menu = '400651';
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/fcm.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
check_demo();

if ($w == 'd')
    auth_check_menu($auth, $sub_menu, "d");
else
    auth_check_menu($auth, $sub_menu, "w");

check_admin_token();


$anss = sql_fetch(" select * from `g5_write_11_inquiry` where wr_id = '".$wr_id."'  ");

$ans = sql_fetch(" select wr_id from `g5_write_11_inquiry` where wr_parent = '".$wr_id."' and wr_is_comment = 1 and wr_comment = '1' ");

if ($w == "u")
{
	$wr_num = '-'.$wr_id;

	if($ans['wr_id']){

		

		$sql = " update `g5_write_11_inquiry`
					set wr_content = '$iq_answer'
				 where wr_id = '".$ans['wr_id']."' ";

		sql_query($sql, false);
		

	}else{

		$sql = " insert into `g5_write_11_inquiry`
					set wr_num  = '$wr_num',
						wr_parent = '$wr_id',
						wr_is_comment = '1',
						wr_comment = '1',
						wr_content = '$iq_answer',
						mb_id = '".$member['mb_id']."',
						wr_name = '".$member['mb_name']."',
						wr_email = '".$member['mb_email']."',
						wr_datetime = '".G5_TIME_YMDHIS."',
						wr_link_target = '_self' ";
		sql_query($sql, false);

		$sql = " update `g5_write_11_inquiry`
					set wr_comment = '1'
				 where wr_id = '".$wr_id."' ";

		sql_query($sql, false);
		
	}


		$sms_content9 = $default['de_sms_cont9'];
		$sms_content9 = str_replace("{이름}", $anss['wr_name'], $sms_content9);

		/* 2024-02-21 준섭 문자 메일 추가 */
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호 (보내는사람)
		$receive_number = preg_replace("/[^0-9]/", "", $anss['wr_hp']);   // 수신자번호(받는사람)

		aligo_sms_call($sms_content9, $receive_number, $send_number, "", "", "");
		

		qna_email_call('일대일문의답변', $anss['wr_email'], $anss['wr_name'], $default['de_admin_company_name'], "", "", "", "", "", $iq_answer);
    

	



    goto_url("./itemoneform.php?w=$w&amp;wr_id=$wr_id&amp;sca=$sca&amp;$qstr");
}
else {
    alert();
}