<?php
$sub_menu = '400660';
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

if ($w == "u")
{
    $sql = "update {$g5['g5_shop_item_qa_table']}
               set iq_subject = '$iq_subject',
                   iq_question = '$iq_question',
                   iq_answer = '$iq_answer'
             where iq_id = '$iq_id' ";
    sql_query($sql);

	if($iq_answer != ''){

		if(trim($iq_answer)) {
			$sql = " select a.iq_email, a.iq_hp, b.it_name, a.mb_id, a.iq_name
						from {$g5['g5_shop_item_qa_table']} a left join {$g5['g5_shop_item_table']} b on ( a.it_id = b.it_id )
						where a.iq_id = '$iq_id' ";
			$row = sql_fetch($sql);
			
			/* 2024-02-21 준섭 문자 메일 추가 */
			$sms_content9 = $default['de_sms_cont9'];

			$sms_content9 = str_replace("{이름}", $row['iq_name'], $sms_content9);


			if($config['cf_manager_hp_qna']){

				$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호 (보내는사람)
				$receive_number = preg_replace("/[^0-9]/", "", $row['iq_hp']);   // 수신자번호(받는사람)

	
				//알림톡발송
				//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
				$kresult = kakao_alim("TS_0383", $receive_number, $row['iq_name'], "", "", "", "", "", "", "");
					
				if($kresult != 'Y'){
					//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
					aligo_sms_call($sms_content9, $receive_number, $send_number, "", "", "");
				}

				qna_email_call('문의답변', $row['iq_email'], $row['iq_name'], $default['de_admin_company_name'], "", "", "", "", "", $sms_content9);


			}

			$mb_app_token = sql_fetch(" select mb_mobile_token from `g5_member` where mb_id = '".$row['mb_id']."' ");
			$push_token = $mb_app_token['mb_mobile_token'];
			$push_content = $config_apppush['app_push2'];

			if($push_token){
				fcm_send($push_token, $push_content);
			}

			
			

			// SMS 알림
			/*
			if($config['cf_sms_use'] == 'icode' && $row['iq_hp']) {
				$sms_content9 = get_text($row['it_name']).' 상품문의에 답변이 등록되었습니다.';
				$send_number = preg_replace('/[^0-9]/', '', $default['de_admin_company_tel']);
				$recv_number = preg_replace('/[^0-9]/', '', $row['iq_hp']);

				if($recv_number) {
					if($config['cf_sms_type'] == 'LMS') {
						include_once(G5_LIB_PATH.'/icode.lms.lib.php');

						$port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

						// SMS 모듈 클래스 생성
						if($port_setting !== false) {
							$SMS = new LMS;
							$SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

							$strDest     = array();
							$strDest[]   = $recv_number;
							$strCallBack = $send_number;
							$strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
							$strSubject  = '';
							$strURL      = '';
							$strData     = iconv_euckr($sms_content9);
							$strDate     = '';
							$nCount      = count($strDest);

							$res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

							$SMS->Send();
							$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
						}
					} else {
						include_once(G5_LIB_PATH.'/icode.sms.lib.php');

						$SMS = new SMS; // SMS 연결
						$SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);
						$SMS->Add($recv_number, $send_number, $config['cf_icode_id'], iconv_euckr(stripslashes($sms_content9)), "");
						$SMS->Send();
					}
				}
			}*/

			// 답변 이메일전송
			/*
			if(trim($row['iq_email'])) {
				include_once(G5_LIB_PATH.'/mailer.lib.php');

				$subject = $config['cf_title'].' '.$row['it_name'].' 상품문의 답변 알림 메일';
				$content = conv_content($iq_answer, 1);

				mailer($config['cf_title'], $config['cf_admin_email'], $row['iq_email'], $subject, $content, 1);
			}
			*/
		}
    }

    goto_url("./itemqaform.php?w=$w&amp;iq_id=$iq_id&amp;sca=$sca&amp;$qstr");
}
else {
    alert();
}