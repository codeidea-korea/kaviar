<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
//----------------------------------------------------------
// SMS 문자전송 시작
//----------------------------------------------------------

$sms_contents = $default['de_sms_cont1'];
$sms_contents = str_replace("{이름}", $mb_name, $sms_contents);
$sms_contents = str_replace("{회원아이디}", $mb_id, $sms_contents);
$sms_contents = str_replace("{회사명}", $default['de_admin_company_name'], $sms_contents);

// 핸드폰번호에서 숫자만 취한다
$receive_number = preg_replace("/[^0-9]/", "", $mb_hp);  // 수신자번호 (회원님의 핸드폰번호)


if ($w == "" && $default['de_sms_use1'] && $receive_number)
{
	if($config['cf_sms_use'] == 'aligo'){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

		$msg = $sms_contents;
		
		
		//알림톡발송
		//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
		$kresult = kakao_alim("TS_0375", $receive_number, $mb_name, "", "", "", $mb_id, "", "", "");
			
		if($kresult != 'Y'){
			//$receive_number = '01099060789'; // 테스트변수 강제 입력
			//내용,받는사람번호,보낸사람번호,SMS or LMS,제목
			aligo_sms_call($msg, $receive_number, $send_number, "", "", "");
		}


	}else if ($config['cf_sms_use'] == 'icode'){
		
		$send_number = preg_replace("/[^0-9]/", "", $default['de_admin_company_tel']); // 발신자번호

		if($config['cf_sms_type'] == 'LMS') {
            include_once(G5_LIB_PATH.'/icode.lms.lib.php');

            $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

            // SMS 모듈 클래스 생성
            if($port_setting !== false) {
                $SMS = new LMS;
                $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

                $strDest     = array();
                $strDest[]   = $receive_number;
                $strCallBack = $send_number;
                $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
                $strSubject  = '';
                $strURL      = '';
                $strData     = iconv_euckr($sms_contents);
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
            $SMS->Add($receive_number, $send_number, $config['cf_icode_id'], iconv_euckr(stripslashes($sms_contents)), "");
            $SMS->Send();
            $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
        }

	}else if ($config['cf_sms_use'] == 'naver'){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_naver_sender']); // 발신자번호

		$msg = $sms_contents;
		//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분  네이버는 sms/lms 필수
		naver_sms_call($msg, $receive_number, $send_number, "SMS", "", "");
    
	}
}

//----------------------------------------------------------
// SMS 문자전송 끝
//----------------------------------------------------------;