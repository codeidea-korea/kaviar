<?php
include_once('./_common.php');
define('_SHOPSTORE_', true); //인태 - 하단메뉴 셀렉팅


if ($w == "u") {
    $sql = " select * from {$g5['g5_shop_store_table']} where store_id = '$store_id' ";
    $store = sql_fetch($sql);
	$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
    if (!$store['store_id'])
        alert('등록된 자료가 없습니다.');

}



if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/shopStore_write.php');
    return;
}

$g5['title'] = $store_label.'검색';
include_once('./_head.php');

$store_skin = G5_SHOP_SKIN_PATH.'/store.write.skin.php';

if(!file_exists($store_skin)) {
    echo str_replace(G5_PATH.'/', '', $store_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($store_skin);
}

include_once('./_tail.php');