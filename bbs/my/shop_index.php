<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/my/shop_block.lib.php');

if($is_shop_manager) {
	echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=index&title=쇼핑몰 메인 블럭관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopIndexSetting" class="btnSetting popWin'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#container">쇼핑몰 메인 블럭관리</a>';
	if($pn=='_view_adm') echo '<div id="_view_adm_msg" class="mobile-max-width"><span class="msg">보고계신 페이지는<br>관리자 확인용 페이지입니다.</span></div>';
}

?>

<article id="shopIndex">	
	<?php echo shop_block('index'); ?>
</article>