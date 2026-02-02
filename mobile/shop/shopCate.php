<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$head_title = '카테고리';
$topMenu_skip = true;
include_once(G5_MSHOP_PATH.'/_head.php');

//비회원 접근 제한
closure_auth_check('');
?>


<div id="_shopCate">
	
	<?php if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?pn=_shop_cate_setting&title=카테고리 이미지 관리" class="btnSetting popWin" data-width="800" data-height="700" data-top="60" data-left="0" data-area="#_shopCate">카테고리 이미지 관리</a>'; ?>
	
	<div id="_shopCateMenuContainer" class="_shopCateContainer">
		<?=get_shopCate_menu('img')?>
	</div>

	<?php// echo get_shopCate_list($option="list", $img=true, $all=true, 'shopCate_ul'); ?>
	
	<?php
	include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
	echo '<div id="shopblock">';
	if($is_admin == 'super') {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate=category&title=블럭관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopblockSetting" class="btnSetting popWin mobile-max-width'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopblock">블럭관리</a>';
	}
	echo shop_block('category');
	echo '</div>';
	?>

</div>


<?php
$footer_skip = true;
include_once(G5_MSHOP_PATH.'/_tail.php');
?>