<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/my/sms.aligo.lib.php');

//인태
if(file_exists(G5_THIS_PATH.'/shop/orderinquirycancel.php')) {
	require_once(G5_THIS_PATH.'/shop/orderinquirycancel.php');
	return;
}

$od_id = isset($_REQUEST['od_id']) ? safe_replace_regex($_REQUEST['od_id'], 'od_id') : '';

// 세션에 저장된 토큰과 폼으로 넘어온 토큰을 비교하여 틀리면 에러
if ($token && get_session("ss_token") == $token) {
    // 맞으면 세션을 지워 다시 입력폼을 통해서 들어오도록 한다.
    set_session("ss_token", "");
} else {
    set_session("ss_token", "");
    alert("토큰 에러", G5_SHOP_URL);
}

$od = sql_fetch(" select * from {$g5['g5_shop_order_table']} where od_id = '$od_id' and mb_id = '{$member['mb_id']}' ");

if (! (isset($od['od_id']) && $od['od_id'])) {
    alert("존재하는 주문이 아닙니다.");
}

// 장바구니 자료 반품요청
//sql_query(" update {$g5['g5_shop_cart_table']} set ct_status = '취소' where od_id = '$od_id' ");

// 반품요청
$return_memo = addslashes(strip_tags($return_memo));
$return_price = $od['od_cart_price'];

$mb_id = $od['mb_id'];

sql_query(" update {$g5['g5_shop_order_table']} set od_return_type = 1 where od_id = '$od_id' ");

$sql = " INSERT INTO `g5_shop_order_return` ( return_order, return_od_id, return_mb_id, return_price, return_type, return_date, return_memo) value ('".$return_order."', $od_id, '".$mb_id."',  $return_price, '".$return_type."', '".G5_TIME_YMDHIS."', '".$return_memo."') ";

sql_query($sql);


//반품요청 문자 이메일보내기
//담당자발송
aligo_sms_call($return_order." 문의가 들어왔습니다.", $config['cf_manager_hp'], $send_number, "", "", "");
qna_email_call('반품교환환불', $config['cf_manager_order_email'], $mb_id, $default['de_admin_company_name'], $return_order, $od_id, $return_type, $return_price, $return_memo);


goto_url(G5_SHOP_URL."/orderinquiryview.php?od_id=$od_id&amp;uid=$uid");