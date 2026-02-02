<?php
include_once('./_common.php');
define("_CSCENTER_", true);

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$g5['title'] = '1:1문의 내역';

$head_title = '1:1문의 내역';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/_head.php');



//1:1문의 게시판 테이블
$bo_table = '11_inquiry';
$tmp_write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블 전체이름
$sql_common = " from {$tmp_write_table} where wr_is_comment = 0 and mb_id = '{$member['mb_id']}' ";

// 테이블의 전체 레코드수만 얻음
$sql = " select count(*) as cnt " . $sql_common;
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = 20;
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$cs_sql = "select * $sql_common order by wr_order < 0, wr_order = 0, wr_order, wr_num, wr_reply limit $from_record, {$rows} ";
$cs_result = sql_query($cs_sql);

$write_pages = get_paging($rows, $page, $total_page, "{$_SERVER['SCRIPT_NAME']}?$qstr&amp;page=");

$wr_id = isset($_REQUEST['wr_id']) ? preg_replace('/[^0-9]/', '', $_REQUEST['wr_id']) : 0;
if($wr_id) {
	$sql = " select * $sql_common and wr_id = '$wr_id' ";
	$view = sql_fetch($sql);
}




if($wr_id) {
	$mycscenter_skin = G5_SHOP_SKIN_PATH.'/mycscenter.view.skin.php';
	$mycscenter_mobile_skin = G5_MSHOP_SKIN_PATH.'/mycscenter.view.skin.php';
	$mycscenter_mobile_skin = file_exists($mycscenter_mobile_skin) ? $mycscenter_mobile_skin : $mycscenter_skin;
} else {
	$mycscenter_skin = G5_SHOP_SKIN_PATH.'/mycscenter.skin.php';
	$mycscenter_mobile_skin = G5_MSHOP_SKIN_PATH.'/mycscenter.skin.php';
	$mycscenter_mobile_skin = file_exists($mycscenter_mobile_skin) ? $mycscenter_mobile_skin : $mycscenter_skin;
}


if(!G5_IS_MOBILE) {
	include_once(G5_SHOP_PATH.'/_my_head.php');

	echo '<div id="_myContainer" class="max-width">';
		include_once(G5_SHOP_PATH.'/_my_gnb.php');
		echo '<div id="_myContainer_con">';
			echo '<div class="_myCon_title border-bottom/2">'.$head_title.'</div>';
			@include_once($mycscenter_skin);
		echo '</div>';
	echo '</div>';
} else {
	@include_once($mycscenter_mobile_skin);
}


include_once(G5_SHOP_PATH.'/_tail.php');