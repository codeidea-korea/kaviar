<?php
$sub_menu = '400400';
include_once('./_common.php');
auth_check_menu($auth, $sub_menu, "w");
include_once(G5_LIB_PATH.'/my/fcm.lib.php');
check_admin_token();

$ct_chk_count = isset($_POST['ct_chk']) ? count($_POST['ct_chk']) : 0;
if(!$ct_chk_count)
    alert('처리할 자료를 하나 이상 선택해 주십시오.');

$status_normal = array('주문','입금','준비','배송','완료');
$status_cancel = array('취소','반품','품절');

if (in_array($_POST['ct_status'], $status_normal) || in_array($_POST['ct_status'], $status_cancel)) {
    ; // 통과
} else {
    alert('변경할 상태가 올바르지 않습니다.');
}

$search = isset($_REQUEST['search']) ? get_search_string($_REQUEST['search']) : '';
$sort1 = isset($_REQUEST['sort1']) ? clean_xss_tags($_REQUEST['sort1'], 1, 1) : '';
$sort2 = isset($_REQUEST['sort2']) ? clean_xss_tags($_REQUEST['sort2'], 1, 1) : '';
$sel_field = isset($_REQUEST['sel_field']) ? clean_xss_tags($_REQUEST['sel_field'], 1, 1) : '';

$mod_history = '';
$cnt = (isset($_POST['ct_id']) && is_array($_POST['ct_id'])) ? count($_POST['ct_id']) : 0;
$arr_it_id = array();
$arr_ct_id = array();
$cancel_cnt = 0;

for ($i=0; $i<$cnt; $i++)
{
	
    $k = isset($_POST['ct_chk'][$i]) ? (int) $_POST['ct_chk'][$i] : '';

    if($k === '') continue;

    $ct_id = isset($_POST['ct_id'][$k]) ? (int) $_POST['ct_id'][$k] : 0;
	
	if($ct_status == '취소' || $ct_status == '반품'){
		$cancel_cnt++;
		$arr_ct_id[] = $ct_id;
	}

    if(!$ct_id)
        continue;

    $sql = " select * from {$g5['g5_shop_cart_table']} where od_id = '$od_id' and ct_id  = '$ct_id' ";
    $ct = sql_fetch($sql);
    if(! (isset($ct['ct_id']) && $ct['ct_id']))
        continue;

    // 수량이 변경됐다면
    $ct_qty = isset($_POST['ct_qty'][$k]) ? (int) $_POST['ct_qty'][$k] : 0;
    if($ct['ct_qty'] != $ct_qty) {
        $diff_qty = $ct['ct_qty'] - $ct_qty;

        // 재고에 차이 반영.
        if($ct['ct_stock_use']) {
            if($ct['io_id']) {
                $sql = " update {$g5['g5_shop_item_option_table']}
                            set io_stock_qty = io_stock_qty + '$diff_qty'
                            where it_id = '{$ct['it_id']}'
                              and io_id = '{$ct['io_id']}'
                              and io_type = '{$ct['io_type']}' ";
            } else {
                $sql = " update {$g5['g5_shop_item_table']}
                            set it_stock_qty = it_stock_qty + '$diff_qty'
                            where it_id = '{$ct['it_id']}' ";
            }

            sql_query($sql);
        }

        // 수량변경
        $sql = " update {$g5['g5_shop_cart_table']}
                    set ct_qty = '$ct_qty'
                    where ct_id = '$ct_id'
                      and od_id = '$od_id' ";
        sql_query($sql);
        $mod_history .= G5_TIME_YMDHIS.' '.$ct['ct_option'].' 수량변경 '.$ct['ct_qty'].' -> '.$ct_qty."\n";
    }

    // 재고를 이미 사용했다면 (재고에서 이미 뺐다면)
    $stock_use = $ct['ct_stock_use'];
    if ($ct['ct_stock_use'])
    {
        if ($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절')
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
        }
    }
    else
    {
        // 재고 오류로 인한 수정
        if ($ct_status == '배송' || $ct_status == '완료')
        {
            $stock_use = 1;
            // 재고에서 뺀다.
            if($ct['io_id']) {
                $sql = " update {$g5['g5_shop_item_option_table']}
                            set io_stock_qty = io_stock_qty - '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}'
                              and io_id = '{$ct['io_id']}'
                              and io_type = '{$ct['io_type']}' ";
            } else {
                $sql = " update {$g5['g5_shop_item_table']}
                            set it_stock_qty = it_stock_qty - '{$ct['ct_qty']}'
                            where it_id = '{$ct['it_id']}' ";
            }

            sql_query($sql);
        }
        /* 주문 수정에서 "품절" 선택시 해당 상품 자동 품절 처리하기
        else if ($ct_status == '품절') {
            $stock_use = 1;
            // 재고에서 뺀다.
            $sql =" update {$g5['g5_shop_item_table']} set it_stock_qty = 0 where it_id = '{$ct['it_id']}' ";
            sql_query($sql);
        } */
    }

    $point_use = $ct['ct_point_use'];
    // 회원이면서 포인트가 0보다 크면
    // 이미 포인트를 부여했다면 뺀다.

    //if ($mb_id && $ct['ct_point'] && $ct['ct_point_use'])
	if ($mb_id && $ct['ct_point_use'])
    {
        $point_use = 0;
        //insert_point($mb_id, (-1) * ($ct[ct_point] * $ct[ct_qty]), "주문번호 $od_id ($ct_id) 취소");
        delete_point($mb_id, "@delivery", $mb_id, "$od_id,$ct_id");
    }

    // 히스토리에 남김
    // 히스토리에 남길때는 작업|아이디|시간|IP|그리고 나머지 자료
    $now = G5_TIME_YMDHIS;
    $ct_history="\n$ct_status|{$member['mb_id']}|$now|$REMOTE_ADDR";

    $sql = " update {$g5['g5_shop_cart_table']}
                set ct_point_use  = '$point_use',
                    ct_stock_use  = '$stock_use',
                    ct_status     = '$ct_status',
                    ct_history    = CONCAT(ct_history,'$ct_history')
                where od_id = '$od_id'
                and ct_id  = '$ct_id' ";
    sql_query($sql);

    // it_id를 배열에 저장
    if($ct_status == '주문' || $ct_status == '취소' || $ct_status == '반품' || $ct_status == '품절' || $ct_status == '완료')
        $arr_it_id[] = $ct['it_id'];
}


// 상품 판매수량 반영
if(is_array($arr_it_id) && !empty($arr_it_id)) {
    $unq_it_id = array_unique($arr_it_id);

    foreach($unq_it_id as $it_id) {
        $sql2 = " select sum(ct_qty) as sum_qty from {$g5['g5_shop_cart_table']} where it_id = '$it_id' and ct_status = '완료' ";
        $row2 = sql_fetch($sql2);

        $sql3 = " update {$g5['g5_shop_item_table']} set it_sum_qty = '{$row2['sum_qty']}' where it_id = '$it_id' ";
        sql_query($sql3);
    }
}

// 장바구니 상품 모두 취소일 경우 주문상태 변경
$cancel_change = false;
if (in_array($_POST['ct_status'], $status_cancel)) {
    $sql = " select count(*) as od_count1,
                    SUM(IF(ct_status = '취소' OR ct_status = '반품' OR ct_status = '품절', 1, 0)) as od_count2
                from {$g5['g5_shop_cart_table']}
                where od_id = '$od_id' ";
    $row = sql_fetch($sql);

    if($row['od_count1'] == $row['od_count2']) {
        $cancel_change = true;

        $pg_res_cd = '';
        $pg_res_msg = '';
        $pg_cancel_log = '';

        // PG 신용카드 결제 취소일 때
        if($pg_cancel == 1) {
            $sql = " select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' ";
            $od = sql_fetch($sql);

            if($od['od_tno'] && ($od['od_settle_case'] == '신용카드' || $od['od_settle_case'] == '간편결제' || $od['od_settle_case'] == 'KAKAOPAY') || ($od['od_pg'] == 'inicis' && is_inicis_order_pay($od['od_settle_case']) )) {
                switch($od['od_pg']) {
                    case 'lg':
                        include_once(G5_SHOP_PATH.'/settle_lg.inc.php');

                        $LGD_TID = $od['od_tno'];

                        $xpay = new XPay($configPath, $CST_PLATFORM);

                        // Mert Key 설정
                        $xpay->set_config_value('t'.$LGD_MID, $config['cf_lg_mert_key']);
                        $xpay->set_config_value($LGD_MID, $config['cf_lg_mert_key']);

                        $xpay->Init_TX($LGD_MID);

                        $xpay->Set('LGD_TXNAME', 'Cancel');
                        $xpay->Set('LGD_TID', $LGD_TID);

                        if ($xpay->TX()) {
                            $res_cd = $xpay->Response_Code();
                            if($res_cd != '0000' && $res_cd != 'AV11') {
                                $pg_res_cd = $res_cd;
                                $pg_res_msg = $xpay->Response_Msg();
                            }
                        } else {
                            $pg_res_cd = $xpay->Response_Code();
                            $pg_res_msg = $xpay->Response_Msg();
                        }
                        break;
                    case 'inicis':
						
                        include_once(G5_SHOP_PATH.'/settle_inicis.inc.php');
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');

                        /*********************
                         * 3. 취소 정보 설정 *
                         *********************/
                        $inipay->SetField("type",      "cancel");                        // 고정 (절대 수정 불가)
                        $inipay->SetField("mid",       $default['de_inicis_mid']);       // 상점아이디
                        /**************************************************************************************************
                         * admin 은 키패스워드 변수명입니다. 수정하시면 안됩니다. 1111의 부분만 수정해서 사용하시기 바랍니다.
                         * 키패스워드는 상점관리자 페이지(https://iniweb.inicis.com)의 비밀번호가 아닙니다. 주의해 주시기 바랍니다.
                         * 키패스워드는 숫자 4자리로만 구성됩니다. 이 값은 키파일 발급시 결정됩니다.
                         * 키패스워드 값을 확인하시려면 상점측에 발급된 키파일 안의 readme.txt 파일을 참조해 주십시오.
                         **************************************************************************************************/
                        $inipay->SetField("admin",     $default['de_inicis_admin_key']); //비대칭 사용키 키패스워드
                        $inipay->SetField("tid",       $od['od_tno']);                   // 취소할 거래의 거래아이디
                        $inipay->SetField("cancelmsg", $cancel_msg);                     // 취소사유

                        /****************
                         * 4. 취소 요청 *
                         ****************/
                        $inipay->startAction();

                        /****************************************************************
                         * 5. 취소 결과                                           	*
                         *                                                        	*
                         * 결과코드 : $inipay->getResult('ResultCode') ("00"이면 취소 성공)  	*
                         * 결과내용 : $inipay->getResult('ResultMsg') (취소결과에 대한 설명) 	*
                         * 취소날짜 : $inipay->getResult('CancelDate') (YYYYMMDD)          	*
                         * 취소시각 : $inipay->getResult('CancelTime') (HHMMSS)            	*
                         * 현금영수증 취소 승인번호 : $inipay->getResult('CSHR_CancelNum')    *
                         * (현금영수증 발급 취소시에만 리턴됨)                          *
                         ****************************************************************/

                        $res_cd  = $inipay->getResult('ResultCode');
                        $res_msg = $inipay->getResult('ResultMsg');

                        if($res_cd != '00') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }
                        break;
                    case 'KAKAOPAY':
                        include_once(G5_SHOP_PATH.'/settle_kakaopay.inc.php');
                        $_REQUEST['TID']               = $od['od_tno'];
                        $_REQUEST['Amt']               = $od['od_receipt_price'];
                        $_REQUEST['CancelMsg']         = '쇼핑몰 운영자 승인 취소';
                        $_REQUEST['PartialCancelCode'] = 0;
                        include G5_SHOP_PATH.'/kakaopay/kakaopay_cancel.php';
                        break;
                    default:
                        include_once(G5_SHOP_PATH.'/settle_kcp.inc.php');
                        require_once(G5_SHOP_PATH.'/kcp/pp_ax_hub_lib.php');

                        // locale ko_KR.euc-kr 로 설정
                        setlocale(LC_CTYPE, 'ko_KR.euc-kr');

                        $c_PayPlus = new C_PP_CLI_T;

                        $c_PayPlus->mf_clear();
                        
                        $ordr_idxx = $od['od_id'];
                        $tno = $od['od_tno'];
                        $tran_cd = '00200000';
                        $cancel_msg = iconv_euckr('쇼핑몰 운영자 승인 취소');
                        $cust_ip = $_SERVER['REMOTE_ADDR'];
                        $bSucc_mod_type = "STSC";

                        $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                        $c_PayPlus->mf_set_modx_data( "mod_type", $bSucc_mod_type              );  // 원거래 변경 요청 종류
                        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                        $c_PayPlus->mf_set_modx_data( "mod_desc", $cancel_msg );  // 변경 사유

                        $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                                              $g_conf_site_key,  $tran_cd,    "",
                                              $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                                              $ordr_idxx, $cust_ip, "3" ,
                                              0, 0, $g_conf_key_dir, $g_conf_log_dir);

                        $res_cd  = $c_PayPlus->m_res_cd;
                        $res_msg = $c_PayPlus->m_res_msg;

                        if($res_cd != '0000') {
                            $pg_res_cd = $res_cd;
                            $pg_res_msg = iconv_utf8($res_msg);
                        }

                        // locale 설정 초기화
                        setlocale(LC_CTYPE, '');
                        break;
                }

                // PG 취소요청 성공했으면
                if($pg_res_cd == '') {
                    $pg_cancel_log = ' PG 신용카드 승인취소 처리';
                    $sql = " update {$g5['g5_shop_order_table']}
                                set od_refund_price = '{$od['od_receipt_price']}'
                                where od_id = '$od_id' ";
                    sql_query($sql);
                }
            }
        }

        // 관리자 주문취소 로그
        $mod_history .= G5_TIME_YMDHIS.' '.$member['mb_id'].' 주문'.$_POST['ct_status'].' 처리'.$pg_cancel_log."\n";
    }
}

// 미수금 등의 정보
$info = get_order_info($od_id);


if(!$info)
    alert('주문자료가 존재하지 않습니다.');


//완료일 업데이트하기
$od_result_date = ($_POST['ct_status'] == "완료")?G5_TIME_YMDHIS:"0000-00-00 00:00:00";


$sql = " update {$g5['g5_shop_order_table']}
            set od_cart_price   = '{$info['od_cart_price']}',
                od_cart_coupon  = '{$info['od_cart_coupon']}',
                od_coupon       = '{$info['od_coupon']}',
                od_send_coupon  = '{$info['od_send_coupon']}',
                od_cancel_price = '{$info['od_cancel_price']}',
                -- od_send_cost    = '{$info['od_send_cost']}',
                od_misu         = '{$info['od_misu']}',
                od_tax_mny      = '{$info['od_tax_mny']}',
                od_vat_mny      = '{$info['od_vat_mny']}',
                od_free_mny     = '{$info['od_free_mny']}',
				od_result_date	= '$od_result_date' ";

if ($mod_history) { // 주문변경 히스토리 기록
    $sql .= " , od_mod_history = CONCAT(od_mod_history,'$mod_history') ";
}

if($cancel_change) {
    $sql .= " , od_status = '취소' "; // 주문상품 모두 취소, 반품, 품절이면 주문 취소
} else {
    if (isset($_POST['ct_status']) && in_array($_POST['ct_status'], $status_normal)) { // 정상인 주문상태만 기록
        $sql .= " , od_status = '{$_POST['ct_status']}' ";
    }
}

$sql .= " where od_id = '$od_id' ";
sql_query($sql);






/* 2024-02-21 준섭 문자 추가 시작 */
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.kakao.lib.php');
// 주문 완료 (SMS, E-EMAIL)

if($_POST['ct_status'] === "입금") {
	
	
	$sms_content7 = $default['de_sms_cont7'];
	
	if ($_POST['mb_id']){
		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}else{
		$receive_numbers = $row['od_b_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}
	
	//$receive_numbers = $_POST['od_hp'];	
	//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

	$sms_content7 = str_replace("{이름}", $_POST['od_name'], $sms_content7);
	$sms_content7 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content7);
	$sms_content7 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content7);
	$sms_content7 = str_replace("{주문번호}", $_POST['od_id'], $sms_content7);
	$sms_content7 = str_replace("{주문금액}", number_format($_POST['od_total_price']), $sms_content7);


    if($config['cf_sms_use'] == "aligo"){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

		//알림톡발송
		//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
		$kresult = kakao_alim("TS_0380", $receive_number, $_POST['od_name'], $_POST['od_id'], $_POST['od_total_price'], "", "", "", "", "");
			
		if($kresult != 'Y'){
			//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
			aligo_sms_call($sms_content7, $receive_number, $send_number, "", "", "");
		}

		order_email_call('입금완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content7);



	}else if($config['cf_sms_use'] == "naver"){

		







	}
	
	//입금완료시 등급조절하기  //준섭
	$order_grade_price = $_POST['od_total_price']; 	//주문한금액 $_POST['od_total_price']
	$order_grade_mdid = $_POST['mb_id'];			//구매자 아이디
	//주문완료된 금액 확인하기
	$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
	//현재등급 가져오기
	$mb_grades = sql_fetch(" select mb_grade,mb_order_price from `g5_member` where mb_id = '".$order_grade_mdid."' ");
	//등급으로 제한금액 가져오기
	$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");
    
	//총구매금액
	$tot_price_g = $order_grade_price + $result_price['od_price'] + $mb_grades['mb_order_price'];
	
	if($mb_grades['mb_grade'] < 6){
		if($tot_price_g > $grade_limit['g_reward_end']){//종료금액보다 크면 등급상승

			$sql_members = " update `g5_member` set mb_grade = mb_grade + 1 where mb_id = '".$order_grade_mdid."' ";
			sql_query($sql_members);

		}
	}

	

// 환불 완료 (SMS, E-EMAIL)
} else if($_POST['ct_status'] === "취소") {

	$all_result = sql_fetch(" select count(*) as cnt from `g5_shop_cart` where od_id = '".$_POST['od_id']."' ");

	//부분취소일경우
	if($cancel_cnt != $all_result['cnt']){
		

		$sql = " select * from {$g5['g5_shop_order_table']} where od_id = '".$_POST['od_id']."' ";
		$od = sql_fetch($sql);

		if(! (isset($od['od_id']) && $od['od_id']))
			alert_close('주문정보가 존재하지 않습니다.');

		if($od['od_pg'] == 'inicis' && $od['od_settle_case'] == '계좌이체')
			alert_close('KG이니시스는 신용카드만 부분취소가 가능합니다.');

		if($od['od_settle_case'] == '계좌이체' && substr($od['od_receipt_time'], 0, 10) >= G5_TIME_YMD)
				alert_close('실시간 계좌이체건의 부분취소 요청은 결제일 익일에 가능합니다.');

		if($od['od_receipt_price'] - $od['od_refund_price'] <= 0)
			alert_close('부분취소 처리할 금액이 없습니다.');

		$od_misu = abs($od['od_misu']);

		$tax_mny = $od_misu;
		$free_mny = 0;
		$mod_memo = "고객 취소 요청";

		// PG사별 부분취소 실행
		include_once(G5_SHOP_PATH.'/'.strtolower($od['od_pg']).'/orderpartcancel.inc.php');

		$can_result = sql_query(" select * from `g5_shop_cart` where od_id = '".$_POST['od_id']."' and ct_status = '취소' ");
		
		$can_money = $od_misu;
		/*
		for ($c=0; $c < count($arr_ct_id); $c++) {
			$can_result = sql_fetch(" select * from `g5_shop_cart` where od_id = '".$_POST['od_id']."' and ct_id = '".$arr_ct_id[$c]."' ");

			$can_money += $can_result['ct_price'];
		}*/

		$sms_content5 = $default['de_sms_cont5'];

		if ($_POST['mb_id']){
			$receive_numbers = $row['od_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}else{
			$receive_numbers = $row['od_b_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}
		//$receive_numbers = $_POST['od_hp'];	
		//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

		$sms_content5 = str_replace("{이름}", $_POST['od_name'], $sms_content5);
		$sms_content5 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content5);
		$sms_content5 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content5);
		$sms_content5 = str_replace("{주문번호}", $_POST['od_id'], $sms_content5);
		$sms_content5 = str_replace("{주문금액}", number_format($can_money)."원", $sms_content5);
		$sms_content5 = str_replace("{주문일자}", $_POST['od_time'], $sms_content5);
		
		if($config['cf_sms_use'] == "aligo"){
			
			$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

			//알림톡발송
			//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
			$kresult = kakao_alim("TS_0378", $receive_number, $_POST['od_name'], $_POST['od_id'], $can_money, "", "", "", "", "");
				
			if($kresult != 'Y'){
				//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
				aligo_sms_call($sms_content5, $receive_number, $send_number, "", "", "");
			}

			order_email_call('환불취소완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content5);


		}

	}else{
        // 전체 취소
        // 전체 취소 회원의 쿠폰을 되돌려 줌 by ein1, cp_id로 log 테이블이 JOIN 되지 않도록하는 방식으로 처리.
        $od_sql = " update g5_shop_coupon_log
                   set cp_id = CONCAT('CANCLE_', cp_id)
                   where od_id = '{$_POST['od_id']}'";
        sql_query($od_sql);

		$sms_content5 = $default['de_sms_cont5'];

		if ($_POST['mb_id']){
			$receive_numbers = $row['od_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}else{
			$receive_numbers = $row['od_b_hp'];
			$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
		}
		//$receive_numbers = $_POST['od_hp'];
		//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

		$sms_content5 = str_replace("{이름}", $_POST['od_name'], $sms_content5);
		$sms_content5 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content5);
		$sms_content5 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content5);
		$sms_content5 = str_replace("{주문번호}", $_POST['od_id'], $sms_content5);
		$sms_content5 = str_replace("{주문금액}", number_format($_POST['od_total_price'])."원", $sms_content5);
		$sms_content5 = str_replace("{주문일자}", $_POST['od_time'], $sms_content5);
		
		if($config['cf_sms_use'] == "aligo"){
			
			$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

			//알림톡발송
			//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
			$kresult = kakao_alim("TS_0378", $receive_number, $_POST['od_name'], $_POST['od_id'], $_POST['od_total_price'], "", "", "", "", "");
				
			if($kresult != 'Y'){
				//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
				aligo_sms_call($sms_content5, $receive_number, $send_number, "", "", "");
			}

			order_email_call('환불취소완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content5);


		}else if($config['cf_sms_use'] == "naver"){
		

		}

        //취소시 등급조절하기  //준섭
		$order_grade_price = $_POST['od_total_price']; 	//주문한금액 $_POST['od_total_price']
		$order_grade_mdid = $_POST['mb_id'];			//구매자 아이디

		//주문완료된 금액 확인하기
		$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
		//현재등급 가져오기
		$mb_grades = sql_fetch(" select mb_grade from `g5_member` where mb_id = '".$order_grade_mdid."' ");
		//등급으로 제한금액 가져오기
		//echo "<br><br>mb_grades :: ".$mb_grades['mb_grade']."<br><br>";
		$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");
		
		//총구매금액
		$tot_price_g = $result_price['od_price'];
		if($mb_grades['mb_grade'] < 6){
			if($tot_price_g < $grade_limit['g_reward_start']){//종료금액보다 크면 등급상승

				$sql_members = " update `g5_member` set mb_grade = mb_grade - 1 where mb_id = '".$order_grade_mdid."' ";
				//echo "<br><br>하락하락update :: ".$sql_members."<br><br>";
				sql_query($sql_members);

			}
		}
	}

// 환불 완료 (SMS, E-EMAIL)
}else if($_POST['ct_status'] === "반품") {
	
	$sms_content6 = $default['de_sms_cont6'];
	

	$ods = sql_fetch(" select * from `g5_shop_order` where od_id = '$od_id' ");
	$od_settle  = $ods['od_settle_case'];
	$od_tot		= $ods['od_cart_price'] + $ods['od_send_cost'];

	$sql = " select * from `g5_shop_cart` where od_id = '$od_id' ";
    $od_cart = sql_query($sql);
	$product = "";


	//부분반품이 아닌 경우, 일괄반품인 경우
	$all_result = sql_fetch(" select count(*) as cnt from `g5_shop_cart` where od_id = '".$od_id."' ");
    if($cancel_cnt == $all_result['cnt']){
        // 반품 회원의 쿠폰을 되돌려 줌 by ein1, cp_id로 log 테이블이 JOIN 되지 않도록하는 방식으로 처리.
        $sql = " update g5_shop_coupon_log
                    set cp_id = CONCAT('CANCLE_', cp_id)
                    where od_id = '$od_id'";
        sql_query($sql);
    }
    
	for ($i=0; $row=sql_fetch_array($od_cart); $i++){
		
		if($row['io_type'] == 0){
			$price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty'];
			//$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']."EA / ".number_format($price)." 원";
			$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']."EA ";
		}else{
			//$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']."EA / ".number_format($row['io_price'] * $row['ct_qty'])." 원";
			$product .= $row['it_name']."(".$row['ct_option'].") / ".$row['ct_qty']."EA ";
		}
	}

	if($ods['od_send_cost'] > 0){
		$product .= "<br>추가배송비 : ".number_format($ods['od_send_cost'])." 원";
	}
	
	if ($_POST['mb_id']){
		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}else{
		$receive_numbers = $row['od_b_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}
	//$receive_numbers = $_POST['od_hp'];
	//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

	$sms_content6 = str_replace("{이름}", $_POST['od_name'], $sms_content6);
	$sms_content6 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content6);
	$sms_content6 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content6);
	$sms_content6 = str_replace("{주문번호}", $_POST['od_id'], $sms_content6);
	$sms_content6 = str_replace("{주문금액}", number_format($_POST['od_total_price'])." 원", $sms_content6);
	$sms_content6 = str_replace("{주문일자}", $_POST['od_time'], $sms_content6);
	$sms_content6 = str_replace("{주문상품}", $product, $sms_content6);
	
    if($config['cf_sms_use'] == "aligo"){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

		//알림톡발송
		//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
		$kresult = kakao_alim("TS_0379", $receive_number, $_POST['od_name'], $_POST['od_id'], $_POST['od_total_price'], $product, "", "", $odd['od_delivery_company'], $odd['od_invoice']);
			
		if($kresult != 'Y'){
			//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
			aligo_sms_call($sms_content6, $receive_number, $send_number, "", "", "");
		}

		order_email_call('반품완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content6);



	}else if($config['cf_sms_use'] == "naver"){
	

	}


	//취소시 등급조절하기  //준섭
	$order_grade_price = $_POST['od_total_price']; 	//주문한금액 $_POST['od_total_price']
	$order_grade_mdid = $_POST['mb_id'];			//구매자 아이디
	
	//주문완료된 금액 확인하기
	$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
	//현재등급 가져오기
	$mb_grades = sql_fetch(" select mb_grade from `g5_member` where mb_id = '".$order_grade_mdid."' ");
	//등급으로 제한금액 가져오기
	//echo "<br><br>mb_grades :: ".$mb_grades['mb_grade']."<br><br>";
	$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");
    
	//총구매금액
	$tot_price_g = $result_price['od_price'];
	if($mb_grades['mb_grade'] < 6){
		if($tot_price_g < $grade_limit['g_reward_start']){//종료금액보다 크면 등급상승

			$sql_members = " update `g5_member` set mb_grade = mb_grade - 1 where mb_id = '".$order_grade_mdid."' ";
			//echo "<br><br>하락하락update :: ".$sql_members."<br><br>";
			sql_query($sql_members);

		}
	}
// 배송완료 (SMS, E-EMAIL) - {배송사} : [ {송장번호} ]
}else if($_POST['ct_status'] === "배송") {
	
	$sms_content8 = $default['de_sms_cont8'];
	
	if ($_POST['mb_id']){
		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}else{
		$receive_numbers = $row['od_b_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}
		
	//$receive_numbers = $_POST['od_hp'];
	//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	$odd = sql_fetch("SELECT * FROM `g5_shop_order` where od_id = '".$_POST['od_id']."' ");
	$sms_content8 = str_replace("{이름}", $_POST['od_name'], $sms_content8);
	$sms_content8 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content8);
	$sms_content8 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content8);
	$sms_content8 = str_replace("{주문번호}", $_POST['od_id'], $sms_content8);
	$sms_content8 = str_replace("{주문금액}", number_format($_POST['od_total_price'])."원", $sms_content8);
	$sms_content8 = str_replace("{주문일자}", $_POST['od_time'], $sms_content8);
	$sms_content8 = str_replace("{배송사}", $odd['od_delivery_company'], $sms_content8);
	$sms_content8 = str_replace("{송장번호}", $odd['od_invoice'], $sms_content8);
	
		
    if($config['cf_sms_use'] == "aligo"){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호
		
		if($odd['od_delivery_company'] && $odd['od_invoice']){
			

			//알림톡발송
			//$tpl_code, $recevier, $name="", $od_id="", $od_price="", $product="", $md_id="", $account="", $company="", $invoice=""
			$kresult = kakao_alim("TS_0381", $receive_number, $_POST['od_name'], "", "", "", "", "", $odd['od_delivery_company'], $odd['od_invoice']);
			
			if($kresult != 'Y'){
				//내용,받는사람번호,보낸사람번호,SMS or LMS,제목,구분
				aligo_sms_call($sms_content8, $receive_number, $send_number, "", "", "");
			}
			order_email_call('배송중', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content8);
		}
		
	}else if($config['cf_sms_use'] == "naver"){
	

	}


	//취소시 등급조절하기  //준섭
	$order_grade_price = $_POST['od_total_price']; 	//주문한금액 $_POST['od_total_price']
	$order_grade_mdid = $_POST['mb_id'];			//구매자 아이디
	
	//echo "<br><br>order_grade_price :: ".$order_grade_price."<br><br>";
	//echo "<br><br>order_grade_mdid :: ".$order_grade_mdid."<br><br>";
	//주문완료된 금액 확인하기
	$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
	//현재등급 가져오기
	$mb_grades = sql_fetch(" select mb_grade,mb_mobile_token from `g5_member` where mb_id = '".$order_grade_mdid."' ");
	//등급으로 제한금액 가져오기
	//echo "<br><br>mb_grades :: ".$mb_grades['mb_grade']."<br><br>";
	$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");
    
	//총구매금액
	$tot_price_g = $result_price['od_price'];
	if($mb_grades['mb_grade'] < 6){
		if($tot_price_g < $grade_limit['g_reward_start']){//종료금액보다 크면 등급상승

			$sql_members = " update `g5_member` set mb_grade = mb_grade - 1 where mb_id = '".$order_grade_mdid."' ";
			//echo "<br><br>하락하락update :: ".$sql_members."<br><br>";
			sql_query($sql_members);

		}
	}

	//배송시 PUSH발송 토큰 / 내용
	$sql = " select * from `g5_shop_cart` where od_id = '".$_POST['od_id']."' ";
    $od_cart = sql_query($sql);
	$product = "";
	$product_qty = 0;
	
	for ($i=0; $row=sql_fetch_array($od_cart); $i++){
		
		if($i == 0){
			$price = ($row['ct_price'] + $row['io_price']) * $row['ct_qty'];
			$product = $row['it_name']."(".$row['ct_option'].")";
		}else{
			$product_qty++;
		}
	}

	if($product_qty > 0){
		$product .= " 외 ".$product_qty."EA 가";
	}
	$push_content = str_replace("{상품명}", $product, $config_apppush['app_push1']);
	$push_token = $mb_grades['mb_mobile_token'];
	if($push_token){
		fcm_send($push_token, $push_content);
	}


// 배송완료 (SMS, E-EMAIL) - {배송사} : [ {송장번호} ]
}else if($_POST['ct_status'] === "완료") {
	
	$sms_content11 = $default['de_sms_cont11'];

	if ($_POST['mb_id']){
		$receive_numbers = $row['od_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}else{
		$receive_numbers = $row['od_b_hp'];
		$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);
	}
	//$receive_numbers = $_POST['od_hp'];
	//$receive_number = preg_replace("/[^0-9]/", "", $receive_numbers);

	$sms_content11 = str_replace("{이름}", $_POST['od_name'], $sms_content11);
	$sms_content11 = str_replace("{회원아이디}", $_POST['mb_id'], $sms_content11);
	$sms_content11 = str_replace("{회사명}", $default['de_admin_company_name'], $sms_content11);
	$sms_content11 = str_replace("{주문번호}", $_POST['od_id'], $sms_content11);
	$sms_content11 = str_replace("{주문금액}", number_format($_POST['od_total_price']."원"), $sms_content11);
	$sms_content11 = str_replace("{주문일자}", $_POST['od_time'], $sms_content11);
	/*
    if($config['cf_sms_use'] == "aligo"){
		
		$send_number = preg_replace("/[^0-9]/", "", $config['cf_aligo_sender']); // 발신자번호

		//알림톡발송
		$kresult = kakao_alim("TS_0385", $_POST['od_hp'], $_POST['od_name'], $_POST['od_id'], "", "", "", "", "", "");
			
		if($kresult != 'Y'){
			aligo_sms_call($sms_content11, $receive_number, $send_number, "", "", "");
		}

		order_email_call('배송완료', $_POST['od_email'], $_POST['mb_id'], $_POST['od_id'], $_POST['od_name'], $_POST['od_time'],  $default['de_admin_company_name'], $default['de_bank_account'], $sms_content11);

	}else if($config['cf_sms_use'] == "naver"){
	

	}
*/

	//취소시 등급조절하기  //준섭
	$order_grade_price = $_POST['od_total_price']; 	//주문한금액 $_POST['od_total_price']
	$order_grade_mdid = $_POST['mb_id'];			//구매자 아이디
	
	//echo "<br><br>order_grade_price :: ".$order_grade_price."<br><br>";
	//echo "<br><br>order_grade_mdid :: ".$order_grade_mdid."<br><br>";
	//주문완료된 금액 확인하기
	$result_price = sql_fetch(" select sum(od_cart_price + od_send_cost) as od_price from `g5_shop_order` where od_status = '완료' and mb_id = '".$order_grade_mdid."' ");
	//현재등급 가져오기
	$mb_grades = sql_fetch(" select mb_grade,mb_first_coupon from `g5_member` where mb_id = '".$order_grade_mdid."' ");
	//등급으로 제한금액 가져오기
	//echo "<br><br>mb_grades :: ".$mb_grades['mb_grade']."<br><br>";
	$grade_limit = sql_fetch(" select g_reward_start,g_reward_end from `g5_member_grade` where idx = ".$mb_grades['mb_grade']." ");
    
	//총구매금액
	$tot_price_g = $result_price['od_price'];
	
	if($mb_grades['mb_grade'] < 6){
		if($tot_price_g < $grade_limit['g_reward_start']){//종료금액보다 크면 등급상승

			$sql_members = " update `g5_member` set mb_grade = mb_grade - 1 where mb_id = '".$order_grade_mdid."' ";
			//echo "<br><br>하락하락update :: ".$sql_members."<br><br>";
			sql_query($sql_members);

		}
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


/* 2024-02-21 준섭 문자 추가 끝 */


$qstr = "sort1=$sort1&amp;sort2=$sort2&amp;sel_field=$sel_field&amp;search=$search&amp;page=$page";

$url = "./orderform.php?od_id=$od_id&amp;$qstr";

// 신용카드 취소 때 오류가 있으면 알림
if($pg_cancel == 1 && $pg_res_cd && $pg_res_msg) {
    alert('오류코드 : '.$pg_res_cd.' 오류내용 : '.$pg_res_msg, $url);
} else {
    // 1.06.06
    $od = sql_fetch(" select od_receipt_point from {$g5['g5_shop_order_table']} where od_id = '$od_id' ");
    if ($od['od_receipt_point'])
        alert("포인트로 결제한 주문은,\\n\\n주문상태 변경으로 인해 포인트의 가감이 발생하는 경우\\n\\n회원관리 > 포인트관리에서 수작업으로 포인트를 맞추어 주셔야 합니다.", $url);
    else
        goto_url($url);
}