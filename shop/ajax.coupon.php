<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

if(!$member['mb_id'])
    die(json_encode(array('error' => '회원 로그인 후 이용해 주십시오.')));

$cu_code = sql_real_escape_string ($cu_code);

if(!$cu_code)
    die(json_encode(array('error' => '올바른 방법으로 이용해 주십시오.')));

$sql = " select * from {$g5['g5_shop_coupon_zone_table']} where cz_code = '$cu_code' ";
$cp = sql_fetch($sql);


if(!$cp['cz_id'])
    die(json_encode(array('error' => '쿠폰정보가 존재하지 않습니다.')));

if(!($cp['cz_start'] <= G5_TIME_YMD && $cp['cz_end'] >= G5_TIME_YMD))
    die(json_encode(array('error' => '다운로드할 수 없는 쿠폰입니다.')));

// 발급여부
if(is_coupon_downloaded($member['mb_id'], $cp['cz_id']))
    die(json_encode(array('error' => '이미 다운로드하신 쿠폰입니다.')));

// 쿠폰발급
$j = 0;
do {
    $cp_id = get_coupon_id();

    $sql3 = " select count(*) as cnt from {$g5['g5_shop_coupon_table']} where cp_id = '$cp_id' ";
    $row3 = sql_fetch($sql3);

    if(!$row3['cnt'])
        break;
    else {
        if($j > 20)
            die(json_encode(array('error' => 'Coupon ID Error')));
    }
    $j++;
} while(1);

$cp = array_map('addslashes', $cp);
$cp_start = G5_TIME_YMD;
$period = $cp['cz_period'] - 1;
if($period < 0)
    $period = 0;
$cp_end = date('Y-m-d', strtotime("+{$period} days", G5_SERVER_TIME));
$result = false;

if($cp['cz_qty'] > $cp['cz_download']){
	$sql = " INSERT INTO {$g5['g5_shop_coupon_table']}
				( cp_id, cp_subject, cp_method, cp_target, mb_id, cz_id, cp_start, cp_end, cp_type, cp_price, cp_trunc, cp_minimum, cp_maximum, cp_datetime )
			VALUES
				( '$cp_id', '{$cp['cz_subject']}', '{$cp['cp_method']}', '{$cp['cp_target']}', '{$member['mb_id']}', '{$cp['cz_id']}', '$cp_start', '$cp_end', '{$cp['cp_type']}', '{$cp['cp_price']}', '{$cp['cp_trunc']}', '{$cp['cp_minimum']}', '{$cp['cp_maximum']}', '".G5_TIME_YMDHIS."' ) ";

	$result = sql_query($sql);


	// 다운로드 증가
	sql_query(" update {$g5['g5_shop_coupon_zone_table']} set cz_download = cz_download + 1 where cz_id = '{$cp['cz_id']}' ");

	die(json_encode(array('error' => '')));
}else{

	die(json_encode(array('error' => '입력하신 쿠폰의 수량이 모두 소진되었습니다.')));
}

