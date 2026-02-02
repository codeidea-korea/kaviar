<?php
include_once('./_common.php');
define("_ITEMUSELIST_", true);

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$g5['title'] = '상품후기';
$head_title = '상품후기';
$topMenu_skip = true;
include_once('./_head.php');

$is_id = $_GET['is_id'];
$sql_common = " from `{$g5['g5_shop_item_use_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where a.is_confirm = '1' and a.mb_id='{$member['mb_id']}' ";
if($is_id) $sql_search .= " and a.is_id='{$is_id}' ";

if(!$sfl)
    $sfl = 'b.it_name';

if ($stx) {
    $sql_search .= " and ( ";
    switch ($sfl) {
        case "a.it_id" :
            $sql_search .= " ($sfl like '$stx%') ";
            break;
        case "a.is_name" :
        case "a.mb_id" :
            $sql_search .= " ($sfl = '$stx') ";
            break;
        default :
            $sql_search .= " ($sfl like '%$stx%') ";
            break;
    }
    $sql_search .= " ) ";
}

if (!$sst) {
    $sst  = "a.is_id";
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
	$myitemuselist_skin = G5_SHOP_SKIN_PATH.'/myitemuselist.view.skin.php';
	$myitemuselist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemuselist.view.skin.php';
	$myitemuselist_mobile_skin = file_exists($myitemuselist_mobile_skin) ? $myitemuselist_mobile_skin : $myitemuselist_skin;
} else {
	$myitemuselist_skin = G5_SHOP_SKIN_PATH.'/myitemuselist.skin.php';
	$myitemuselist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemuselist.skin.php';
	$myitemuselist_mobile_skin = file_exists($myitemuselist_mobile_skin) ? $myitemuselist_mobile_skin : $myitemuselist_skin;
}


if(!G5_IS_MOBILE) {
	//echo '<div id="_myitemuse">';	
		include_once(G5_SHOP_PATH.'/_my_head.php');

		echo '<div id="_myContainer" class="max-width">';
			include_once(G5_SHOP_PATH.'/_my_gnb.php');
			echo '<div id="_myContainer_con">';
				if(!$is_id) echo '<div class="_myCon_title">상품후기<sub>최근 주문하신 3개월 이내의 내역만 보여집니다</sub></div>';
				@include_once($myitemuselist_skin);
			echo '</div>';
		echo '</div>';
	//echo '</div>';
} else {
	@include_once($myitemuselist_mobile_skin);
}


include_once('./_tail.php');