<?php
include_once('./_common.php');


$g5['title'] = '나의 후기';

$is_back = true; //뒤로가기
$head_title = '나의 후기';
include_once(G5_SHOP_PATH.'/_head.php');


$myitemuselist_view_skin = G5_SHOP_SKIN_PATH.'/myitemuselist.view.skin.php';
$myitemuselist_view_mobile_skin = G5_MSHOP_SKIN_PATH.'/myitemuselist.view.skin.php';
$myitemuselist_view_mobile_skin = file_exists($myitemuselist_view_mobile_skin) ? $myitemuselist_view_mobile_skin : $myitemuselist_skin;


if(!G5_IS_MOBILE) {
	@include_once($myitemuselist_view_skin);
} else {
	@include_once($myitemuselist_view_mobile_skin);
}


$is_bottomTabMenu = true;
$not_footer = true;
include_once(G5_SHOP_PATH.'/_tail.php');