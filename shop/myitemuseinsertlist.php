<?php
include_once('./_common.php');
define("_ITEMUSELIST_", true);

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$g5['title'] = '상품후기 등록하기';
$head_title = '상품후기 등록하기';
$topMenu_skip = true;
include_once('./_head.php');

$is_id = $_GET['is_id'];

$sql_common = " from `{$g5['g5_shop_cart_table']}` a ";
$sql_search = " where a.ct_use_id = '' and a.ct_status = '완료' and a.mb_id='{$member['mb_id']}' ";


if (!$sst) {
    $sst  = "a.ct_id";
    $sod = "desc";
}
$sql_order = " order by $sst $sod ";

$sql = " select count(*) as cnt
         $sql_common
         $sql_search
         $sql_order ";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

$rows = $config['cf_mobile_page_rows'];
$total_page  = ceil($total_count / $rows);  // 전체 페이지 계산
if ($page < 1) { $page = 1; } // 페이지가 없으면 첫 페이지 (1 페이지)
$from_record = ($page - 1) * $rows; // 시작 열을 구함

$sql = " select *
          $sql_common
          $sql_search
          $sql_order
          limit $from_record, $rows ";
$result = sql_query($sql);



if($is_id) {
	$myitemuselist_skin = G5_SHOP_SKIN_PATH.'/myitemuse_insert_list.view.skin.php';
	$myitemuselist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemuse_insert_list.view.skin.php';
	$myitemuselist_mobile_skin = file_exists($myitemuselist_mobile_skin) ? $myitemuselist_mobile_skin : $myitemuselist_skin;
} else {
	$myitemuselist_skin = G5_SHOP_SKIN_PATH.'/myitemuse_insert_list.skin.php';
	$myitemuselist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemuse_insert_list.skin.php';
	$myitemuselist_mobile_skin = file_exists($myitemuselist_mobile_skin) ? $myitemuselist_mobile_skin : $myitemuselist_skin;
}


if(!G5_IS_MOBILE) {
	//echo '<div id="_myitemuse">';	
		include_once(G5_SHOP_PATH.'/_my_head.php');

		echo '<div id="_myContainer" class="max-width">';
			include_once(G5_SHOP_PATH.'/_my_gnb.php');
			echo '<div id="_myContainer_con">';
				if(!$is_id) echo '<div class="_myCon_title">상품후기 등록하기<sub>후기 작성 가능한 상품만 보여집니다.</sub></div>';
				@include_once($myitemuselist_skin);
			echo '</div>';
		echo '</div>';
	//echo '</div>';
} else {
	@include_once($myitemuselist_mobile_skin);
}


include_once('./_tail.php');