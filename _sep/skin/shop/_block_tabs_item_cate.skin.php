<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
//include_once('../../../_common.php');

$tabs_items_cate_arr = explode(",", $shopblock['tabs_items_cate']);
for ($j=0; $j<count($tabs_items_cate_arr); $j++) {
	//$tabs_items_cate .= '<a onclick="get_bl_'.$bl_id.'_items_ajax(\''.$tabs_items_cate_arr[$j].'\')" class="tab'.($j==0?' active':'').'">'.get_shop_cate($tabs_items_cate_arr[$j]).'</a>';
	$tabs_items_cate .= '<span id="test1" class="swiper-slide tab'.($j==0?' active':'').'" data-target="#tabCon_'.$tabs_items_cate_arr[$j].'">'.get_shop_cate($tabs_items_cate_arr[$j]).'</span>';
}
$tabs_items_cate = $tabs_items_cate ? '<div class="tabs_items_cate mySwiper" data-per="auto" data-gap="10" data-loop="false"><div class="swiper-container"><div class="swiper-wrapper">'.$tabs_items_cate.'</div></div></div>' : '';

echo $tabs_items_cate;
?>


<style>
<?php if(!G5_IS_MOBILE) { ?>
#section-<?=$bl_id?> .inner{position:relative;}
#section-<?=$bl_id?> .blCon-con{min-height:600px;}
._get_itemsContainer{min-height:600px;}
._get_itemsContainer .itemsContainer .item-list:nth-child(2){width:calc(var(--item-width) * 3);padding-right:calc(var(--item-width) * 2);}
._get_itemsContainer .itemsContainer .item-list:nth-child(1){margin-bottom:50px;}
._get_itemsContainer_banner{position:absolute;top:295px;right:0;width:calc(50% - 15px);}
._get_itemsContainer_banner .btnSetting{top:-40px;right:10px;}
<?php } else { ?>
._get_itemsContainer_banner{margin-bottom:25px;}
._get_itemsContainer_banner .mySwiper{padding:0 !important;}
<?php } ?>
</style>

<div class="_get_itemsContainer">

	<div class="_get_itemsContainer_banner" class="bottom relative">
		<?php
		$_get_items_banner_radius = G5_IS_MOBILE ? 5 : 8;
		echo shop_banner('', '_block_banner.skin.php', '메인블럭01', '', '', '', 10, '', $_get_items_banner_radius);
		?>
		<?php if($is_admin) echo '<a href="'.$_adm_url.'/?&pn=_shop_banner&bn_position=basic&bn_cate=메인블럭01&title=쇼핑몰 배너관리" class="btnSetting light popWin" style="top:5px;right:-25px;" data-width="1250" data-height="600" data-top="60" data-left="0" data-area="._get_itemsContainer_banner">쇼핑몰 배너관리</a>';?>
	</div>

	<?php
	$_get_items_cols = G5_IS_MOBILE ? 2 : 4;
	$_get_items_gap = G5_IS_MOBILE ? 10 : 30;
	$_get_items_radius = $items_radius;
	for ($j=0; $j<count($tabs_items_cate_arr); $j++) {
		echo '<div id="tabCon_'.$tabs_items_cate_arr[$j].'" class="tabContainer">';
		$list = new item_list();
		$list->set_list_mod(6);
		$list->set_list_row(1);
		$list->set_list_skin(G5_SHOP_SKIN_PATH.'/_block_item.skin.php');
		$list->set_img_size(350, 350);
		$list->set_category($tabs_items_cate_arr[$j], 1);
		$list->set_category($tabs_items_cate_arr[$j], 2);
		$list->set_category($tabs_items_cate_arr[$j], 3);
		$list->set_items_cols($_get_items_cols);
		$list->set_items_gap($_get_items_gap);
		$list->set_items_radius($_get_items_radius);
		$list->set_items_skin('_gall');
		$list->set_view('it_img', true);
		$list->set_view('it_id', false);
		$list->set_view('it_name', true);
		$list->set_view('it_cust_price', true);
		$list->set_view('it_price', true);
		$list->set_view('it_icon', true);
		echo $list->run();
		echo '</div>';
	} ?>
	
</div>




<?php if($shopblock['tabs_items_cate']) { ?>
<script>
_tabsContainer(".tabs_items_cate .tab", "._get_itemsContainer .tabContainer");
</script>

<?php } ?>