<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_back = true; //뒤로가기
$head_title = $g5['title'];
$topMenu_skip = true;
include_once(G5_SHOP_PATH.'/_head.php');


include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
echo '<div id="shopblock">';
if($is_admin == 'super') {
	echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=customer&title=고객센터 관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">고객센터 관리</a>';
}
echo shop_block('customer');
echo '</div>';


//$footer_skip = true;
include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');