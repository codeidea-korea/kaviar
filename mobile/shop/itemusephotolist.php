<?php
include_once('./_common.php');

$g5['title'] = '사용후기';
include_once(G5_PATH.'/head.sub.php');


$sql_common = " from `{$g5['g5_shop_item_use_table']}` where it_id = '{$it_id}' and is_confirm = '1' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select COUNT(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 30;
$total_page  = ceil($total_count / $rows); // 전체 페이지 계산
if ($page < 1) $page = 1; // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 레코드 구함

$sql = "select * $sql_common order by is_id desc limit $from_record, $rows ";
$result = sql_query($sql);

$itemusephotolist_href = G5_MSHOP_URL.'/itemusephotolist.php?it_id='.$it_id;

$itemusephotolist_skin = G5_MSHOP_SKIN_PATH.'/itemusephotolist.skin.php';
if($is_id) $itemusephotolist_skin = G5_MSHOP_SKIN_PATH.'/itemusephotolist.view.skin.php';

if(!file_exists($itemusephotolist_skin)) {
    echo str_replace(G5_PATH.'/', '', $itemusephotolist_skin).' 스킨 파일이 존재하지 않습니다.';
} else {
    include_once($itemusephotolist_skin);
}

include_once(G5_PATH.'/tail.sub.php');