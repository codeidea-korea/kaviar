<?php
$sub_menu = '400800';
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, "w");

check_admin_token();

$_POST = array_map('trim', $_POST);

$check_sanitize_keys = array(
'cp_subject',       // 쿠폰이름
'cp_method',        // 쿠폰종류
'cp_target',        // 적용상품
'mb_id',            // 회원아이디
'cp_start',         // 사용시작일
'cp_end',           // 사용종료일
'cp_type',          // 쿠폰타입
'cp_price',         // 할인금액
'cp_type',          // 할인금액타입
'cp_trunc',         // 절사금액
'cp_minimum',       // 최소주문금액
'cp_maximum',       // 최대할인금액
'chk_all_mb'        // 전체회원 체크
);

foreach( $check_sanitize_keys as $key ){
    $$key = $_POST[$key] = isset($_POST[$key]) ? strip_tags(clean_xss_attributes($_POST[$key])) : '';
}

if(!$_POST['cp_subject'])
    alert('쿠폰이름을 입력해 주십시오.');

if($_POST['cp_method'] == 0 && !$_POST['cp_target'])
    alert('적용상품을 입력해 주십시오.');


if($_POST['cp_method'] == 1 && !$_POST['cp_target'])
    alert('적용분류를 입력해 주십시오.');


if($_POST['ctype'] == 1){
	if(!$_POST['mb_id'] && !$_POST['chk_all_mb'] && !$_POST['all_mb2'] && !$_POST['chk_all_mb3'] && !$_POST['all_mb4'] && !$_POST['chk_all_mb5']&& !$_POST['all_mb6'] && !$_POST['chk_all_mb7']&& !$_POST['all_mb8'])
    alert('회원아이디를 입력해 주십시오.');
}else if($_POST['ctype'] == 2){
	if(!$_FILES['mb_mcoupon']['tmp_name']){
		if($_POST['cp_ctype'] != 2){
			alert("엑셀을 등록해주세요.");
		}
	}
}


if(!$_POST['cp_start'] || !$_POST['cp_end'])
    alert('사용 시작일과 종료일을 입력해 주십시오.');

if($_POST['cp_start'] > $_POST['cp_end'])
    alert('사용 시작일은 종료일 이전으로 입력해 주십시오.');

if($_POST['cp_end'] < G5_TIME_YMD)
    alert('종료일은 오늘('.G5_TIME_YMD.')이후로 입력해 주십시오.');

if(!$_POST['cp_price']) {
    if($_POST['cp_type'])
        alert('할인비율을 입력해 주십시오.');
    else
        alert('할인금액을 입력해 주십시오.');
}

if( (int) $_POST['cp_price'] < 0 ){
    alert('할인금액 또는 할인비율은 음수를 입력할수 없습니다.');
}

if($_POST['cp_type'] && ($_POST['cp_price'] < 1 || $_POST['cp_price'] > 101))
    alert('할인비율을 1과 100사이 값으로 입력해 주십시오.');

if($_POST['cp_method'] == 0) {
    $sql = " select count(*) as cnt from {$g5['g5_shop_item_table']} where it_id = '$cp_target' and it_nocoupon = '0' ";
    $row = sql_fetch($sql);
    if(!$row['cnt'])
        alert('입력하신 상품코드는 존재하지 않는 코드이거나 쿠폰적용안함으로 설정된 상품입니다.');
} else if($_POST['cp_method'] == 1) {
    $sql = " select count(*) as cnt from {$g5['g5_shop_category_table']} where ca_id = '$cp_target' and ca_nocoupon = '0' ";
    $row = sql_fetch($sql);
    if(!$row['cnt'])
        alert('입력하신 분류코드는 존재하지 않는 분류코드이거나 쿠폰적용안함으로 설정된 분류입니다.');
}

if($w == '') {
	
	if($_POST['ctype']==1){
		$mb_id;
		if($_POST['chk_all_mb']) {
			$mb_id = '전체회원';
		}else if($_POST['all_mb2'] || $_POST['all_mb3'] || $_POST['all_mb4'] || $_POST['all_mb5'] || $_POST['all_mb6'] || $_POST['all_mb7'] || $_POST['all_mb8']) {

			if($_POST['all_mb2'])	$chk_mb[] .= '캐비아|2';
			if($_POST['all_mb3'])	$chk_mb[] .= '실버|3';
			if($_POST['all_mb4'])	$chk_mb[] .= '골드|4';
			if($_POST['all_mb5'])	$chk_mb[] .= '프리미엄|5';
			if($_POST['all_mb6'])	$chk_mb[] .= '임직원|6';
			if($_POST['all_mb7'])	$chk_mb[] .= '큐커플랜|7';
			if($_POST['all_mb8'])	$chk_mb[] .= 'QVIP|8';

		

			for($m=0; $m < count($chk_mb); $m++){
				$cc = explode("|", $chk_mb[$m]);
				if($m==0){
					$mb_id = $cc[0];
					$mb_grade = $cc[1];
				}else{
					$mb_id = $mb_id.",".$cc[0];
					$mb_grade = $mb_grade.",".$cc[1];
				}
			}	 

		} else {
			$sql = " select mb_id from {$g5['member_table']} where mb_id = '{$_POST['mb_id']}' and mb_leave_date = '' and mb_intercept_date = '' ";
			$row = sql_fetch($sql);
			if(!$row['mb_id'])
				alert('입력하신 회원아이디는 존재하지 않거나 탈퇴 또는 차단된 회원아이디입니다.');

			$mb_id = $_POST['mb_id'];
		}
		$cp_ctype = 1;
	}else if($_POST['ctype'] == 2) {//엑셀업로드

		$cp_ctype = 2;
		if(isset($_FILES['mb_mcoupon']['tmp_name']) && $_FILES['mb_mcoupon']['tmp_name']) {
			$file = $_FILES['mb_mcoupon']['tmp_name'];

			include_once(G5_LIB_PATH.'/PHPExcel/IOFactory.php');

			$objPHPExcel = PHPExcel_IOFactory::load($file);
			$sheet = $objPHPExcel->getSheet(0);

			$num_rows = $sheet->getHighestRow();
			$highestColumn = $sheet->getHighestColumn();

			$fail_mb_id = array();
			$cmember;
			// $i 사용시 ordermail.inc.php의 $i 때문에 무한루프에 빠짐
			for ($k = 2; $k <= $num_rows; $k++) {
				
				$rowData = $sheet->rangeToArray('A' . $k . ':' . $highestColumn . $k,
														NULL,
														TRUE,
														FALSE);

				if($rowData[0][0] != ''){
					
					$member_id = isset($rowData[0][0]) ? addslashes($rowData[0][0]) : '';

					// 주문정보
					$mb = sql_fetch(" select * from `g5_member` where mb_id = '$member_id' ");
					
					if (!$mb) {
						$fail_count++;
						$fail_mb_id[] = $member_id;
						continue;
					}else{
						$succ_mb_id[] = $member_id;
					}
				}
				
			}
			
		}
		$uniqueArray = array_unique($succ_mb_id);
		$uniqueCmember = array_values($uniqueArray);

		for ($u=0; $u < count($uniqueCmember); $u++) {
			if(!$mb_id){
				$mb_id = $uniqueCmember[$u];
			}else{
				$mb_id = $mb_id.",".$uniqueCmember[$u];
			}
		}
	}


    $j = 0;
    do {
        $cp_id = get_coupon_id();

        $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
        $row3 = sql_fetch($sql3);

        if(!$row3['cnt'])
            break;
        else {
            if($j > 20)
                die('Coupon ID Error');
        }

        $j++;

    } while(1);

    $sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
                ( cp_id, cp_subject, cp_method, cp_target, mb_id, mb_grade, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime, cp_ctype )
            VALUES
                ( '$cp_id', '$cp_subject', '$cp_method', '$cp_target', '$mb_id', '$mb_grade', '$cp_start', '$cp_end', '$cp_type', '$cp_price', '$cp_trunc', '$cp_minimum', '$cp_maximum', '".G5_TIME_YMDHIS."', '$cp_ctype' ) ";

    sql_query($sql);

} else if($w == 'u') {

    $sql = " select * from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
    $cp = sql_fetch($sql);

    if(!$cp['cp_id'])
        alert('쿠폰정보가 존재하지 않습니다.', './couponlist.php');

    if($_POST['chk_all_mb']) {
        $mb_id = '전체회원';
    }
	//alert($mb_id);
	if($_POST['all_mb2'] || $_POST['all_mb3'] || $_POST['all_mb4'] || $_POST['all_mb5'] || $_POST['all_mb6'] || $_POST['all_mb7'] || $_POST['all_mb8']) {

		if($_POST['all_mb2'])	$chk_mb[] .= '캐비아|2';
		if($_POST['all_mb3'])	$chk_mb[] .= '실버|3';
		if($_POST['all_mb4'])	$chk_mb[] .= '골드|4';
		if($_POST['all_mb5'])	$chk_mb[] .= '프리미엄|5';
		if($_POST['all_mb6'])	$chk_mb[] .= '임직원|6';
		if($_POST['all_mb7'])	$chk_mb[] .= '큐커플랜|7';
		if($_POST['all_mb8'])	$chk_mb[] .= 'QVIP|8';

    

		for($m=0; $m < count($chk_mb); $m++){
			$cc = explode("|", $chk_mb[$m]);
			if($m==0){
				$mb_id = $cc[0];
				$mb_grade = $cc[1];
			}else{
				$mb_id = $mb_id.",".$cc[0];
				$mb_grade = $mb_grade.",".$cc[1];
			}
		}
	}

	//print_r($chk_mb);
	//echo $mb_id." / ".$mb_grade;

	

    $sql = " update {$g5['g5_shop_coupon_table']}
                set cp_subject  = '$cp_subject',
                    cp_method   = '$cp_method',
                    cp_target   = '$cp_target',
                    mb_id       = '$mb_id',
					mb_grade    = '$mb_grade',
                    cp_start    = '$cp_start',
                    cp_end      = '$cp_end',
                    cp_type     = '$cp_type',
                    cp_price    = '$cp_price',
                    cp_trunc    = '$cp_trunc',
                    cp_maximum  = '$cp_maximum',
                    cp_minimum  = '$cp_minimum'
                where cp_id = '$cp_id' ";
    sql_query($sql);
}

// 쿠폰생성알림 발송
/*
if($w == '' && ($_POST['cp_sms_send'] || $_POST['cp_email_send'])) {
    include_once(G5_LIB_PATH.'/mailer.lib.php');

    $sms_count = 0;
    $arr_send_list = array();
    $sms_messages = array();

    if($_POST['chk_all_mb']) {
        $sql = " select mb_id, mb_name, mb_hp, mb_email, mb_mailling, mb_sms
                    from {$g5['member_table']}
                    where mb_leave_date = ''
                      and mb_intercept_date = ''
                      and ( mb_mailling = '1' or mb_sms = '1' )
                      and mb_id <> '{$config['cf_admin']}' ";
    } else {
        $sql = " select mb_id, mb_name, mb_hp, mb_email, mb_mailling, mb_sms
                    from {$g5['member_table']}
                    where mb_id = '$mb_id' ";
    }

    $result = sql_query($sql);

    for($i=0; $row = sql_fetch_array($result); $i++) {
        $arr_send_list[] = $row;
    }

    $count = count($arr_send_list);

    for($i=0; $i<$count; $i++) {
        if(!$arr_send_list[$i]['mb_id'])
            continue;

        // SMS
        if($config['cf_sms_use'] == 'icode' && $_POST['cp_sms_send'] && $arr_send_list[$i]['mb_hp'] && $arr_send_list[$i]['mb_sms']) {
            $sms_contents = $cp_subject.' 쿠폰이 '.get_text($arr_send_list[$i]['mb_name']).'님께 발행됐습니다. 쿠폰만료 : '.$cp_end.' '.str_replace('http://', '', G5_URL);

            if($sms_contents) {
                $receive_number = preg_replace("/[^0-9]/", "", $arr_send_list[$i]['mb_hp']);   // 수신자번호
                $send_number = preg_replace("/[^0-9]/", "", $default['de_admin_company_tel']); // 발신자번호

                if($receive_number)
                    $sms_messages[] = array('recv' => $receive_number, 'send' => $send_number, 'cont' => $sms_contents);
            }
        }

        // E-MAIL
        if($config['cf_email_use'] && $_POST['cp_email_send'] && $arr_send_list[$i]['mb_email'] && $arr_send_list[$i]['mb_mailling']) {
            $mb_name = get_text($arr_send_list[$i]['mb_name']);
            switch($cp_method) {
                case 2:
                    $coupon_method = '결제금액할인';
                    break;
                case 3:
                    $coupon_method = '배송비할인';
                    break;
                default:
                    $coupon_method = '개별상품할인';
                    break;
            }
            $contents = '쿠폰명 : '.$cp_subject.'<br>';
            $contents .= '적용대상 : '.$coupon_method.'<br>';
            $contents .= '쿠폰만료 : '.$cp_end;

            $title = $config['cf_title'].' - 쿠폰발행알림 메일';
            $email = $arr_send_list[$i]['mb_email'];

            ob_start();
            include G5_SHOP_PATH.'/mail/couponmail.mail.php';
            $content = ob_get_contents();
            ob_end_clean();

            mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $email, $title, $content, 1);
        }
    }

    // SMS발송
    $sms_count = count($sms_messages);
    if($sms_count > 0) {
        if($config['cf_sms_type'] == 'LMS') {
            include_once(G5_LIB_PATH.'/icode.lms.lib.php');

            $port_setting = get_icode_port_type($config['cf_icode_id'], $config['cf_icode_pw']);

            // SMS 모듈 클래스 생성
            if($port_setting !== false) {
                $SMS = new LMS;
                $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $port_setting);

                for($s=0; $s<$sms_count; $s++) {
                    $strDest     = array();
                    $strDest[]   = $sms_messages[$s]['recv'];
                    $strCallBack = $sms_messages[$s]['send'];
                    $strCaller   = iconv_euckr(trim($default['de_admin_company_name']));
                    $strSubject  = '';
                    $strURL      = '';
                    $strData     = iconv_euckr($sms_messages[$s]['cont']);
                    $strDate     = '';
                    $nCount      = count($strDest);

                    $res = $SMS->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

                    $SMS->Send();
                    $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
                }
            }
        } else {
            include_once(G5_LIB_PATH.'/icode.sms.lib.php');

            $SMS = new SMS; // SMS 연결
            $SMS->SMS_con($config['cf_icode_server_ip'], $config['cf_icode_id'], $config['cf_icode_pw'], $config['cf_icode_server_port']);

            for($s=0; $s<$sms_count; $s++) {
                $recv_number = $sms_messages[$s]['recv'];
                $send_number = $sms_messages[$s]['send'];
                $sms_content = iconv_euckr($sms_messages[$s]['cont']);

                $SMS->Add($recv_number, $send_number, $config['cf_icode_id'], $sms_content, "");
            }

            $SMS->Send();
            $SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
        }
    }
}
*/
goto_url('./couponlist.php');