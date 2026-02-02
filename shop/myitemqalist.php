<?php
include_once('./_common.php');
define("_ITEMQALIST_", true);

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_SHOP_URL."/mypage.php"));

$g5['title'] = '상품문의';

$head_title = '상품문의';
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/_head.php');

$iq_id = $_GET['iq_id'];
$sql_common = " from `{$g5['g5_shop_item_qa_table']}` a join `{$g5['g5_shop_item_table']}` b on (a.it_id=b.it_id) ";
$sql_search = " where a.mb_id='{$member['mb_id']}' ";
if($iq_id) $sql_search .= " and a.iq_id='{$iq_id}' ";

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
    $sst  = "a.iq_id";
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

if($iq_id) {
	$myitemqalist_skin = G5_SHOP_SKIN_PATH.'/myitemqalist.view.skin.php';
	$myitemqalist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemqalist.view.skin.php';
	$myitemqalist_mobile_skin = file_exists($myitemqalist_mobile_skin) ? $myitemqalist_mobile_skin : $myitemqalist_skin;
} else {
	$myitemqalist_skin = G5_SHOP_SKIN_PATH.'/myitemqalist.skin.php';
	$myitemqalist_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemqalist.skin.php';
	$myitemqalist_mobile_skin = file_exists($myitemqalist_mobile_skin) ? $myitemqalist_mobile_skin : $myitemqalist_skin;
}


if(!G5_IS_MOBILE) {
	include_once(G5_SHOP_PATH.'/_my_head.php');

	echo '<div id="_myContainer" class="max-width">';
		include_once(G5_SHOP_PATH.'/_my_gnb.php');
		echo '<div id="_myContainer_con">';
			if(!$iq_id) echo '<div class="_myCon_title border-bottom/2">상품문의</div>';
			@include_once($myitemqalist_skin);
		echo '</div>';
	echo '</div>';
} else {
	@include_once($myitemqalist_mobile_skin);
}



$is_bottomTabMenu = true;
$footer_skip = true;
include_once(G5_SHOP_PATH.'/_tail.php');