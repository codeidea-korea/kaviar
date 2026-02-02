<?php
include_once('./_common.php');
define('_SHOPSTORE_', true); //인태 - 하단메뉴 셀렉팅


$where = array();

if (!$is_admin){
	$where[] = " store_use = '1' ";
}

$q = utf8_strcut(get_search_string(trim($_GET['q'])), 30, "");

if ($q) {
    $arr = explode(" ", $q);
    $detail_where = array();

	 for ($i=0; $i<count($arr); $i++) {
        $word = trim($arr[$i]);
        if (!$word) continue;

        $detail_where[] = " store_address like '%$word%' ";
    }

    $where[] = "(".implode(" and ", $detail_where).")";

}

$sql_where = $where ? " where " . implode(" and ", $where) : '';

$sql_common = " from {$g5['g5_shop_store_table']} ";
$sql_common .= $sql_where;

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 40;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$shop_sql = "select * $sql_common order by store_order < 0, store_order = 0, store_order, store_id limit $from_record, {$rows} ";
$shop_result = sql_query($shop_sql);

$write_pages = get_paging($rows, $page, $total_page, shop_short_url_my('shopStore','',$qstr.'&amp;page='));

$store_id = isset($_REQUEST['store_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['store_id']) : 0;
if($store_id) {
	$sql = " select * from {$g5['g5_shop_store_table']} where store_id = '$store_id' ";
	$store = sql_fetch($sql);
}

if (G5_IS_MOBILE) {
    include_once(G5_MSHOP_PATH.'/shopStore.php');
    return;
}

$g5['title'] = $store_id ? $store['store_subject'] : $store_label.'검색';
include_once('./_head.php');


$store_skin = G5_SHOP_SKIN_PATH.'/store.skin.php';
if($store_id) $store_skin = G5_SHOP_SKIN_PATH.'/store.view.skin.php';

if(!file_exists($store_skin)) {
    echo str_replace(G5_PATH.'/', '', $store_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($store_skin);
}

include_once('./_tail.php');