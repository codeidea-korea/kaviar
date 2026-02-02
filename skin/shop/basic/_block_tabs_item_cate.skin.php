<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
//include_once('../../../_common.php');

if(file_exists(G5_THIS_PATH.'/skin/shop/_block_tabs_item_cate.skin.php')) {
	require_once(G5_THIS_PATH.'/skin/shop/_block_tabs_item_cate.skin.php');
	return;
}

$tabs_items_cate_arr = explode(",", $shopblock['tabs_items_cate']);
for ($j=0; $j<count($tabs_items_cate_arr); $j++) {
	//$tabs_items_cate .= '<a onclick="get_bl_'.$bl_id.'_items_ajax(\''.$tabs_items_cate_arr[$j].'\')" class="tab'.($j==0?' active':'').'">'.get_shop_cate($tabs_items_cate_arr[$j]).'</a>';
	$tabs_items_cate .= '<span class="swiper-slide tab'.($j==0?' active':'').'" data-target="#tabCon_'.$tabs_items_cate_arr[$j].'">'.get_shop_cate($tabs_items_cate_arr[$j]).'</span>';
}
$tabs_items_cate = $tabs_items_cate ? '<div class="tabs_items_cate mySwiper" data-per="auto" data-gap="25" data-loop="false"><div class="swiper-container"><div class="swiper-wrapper">'.$tabs_items_cate.'</div></div></div>' : '';


echo $tabs_items_cate;
?>



<div class="_get_itemsContainer">
	<?php for ($j=0; $j<count($tabs_items_cate_arr); $j++) {
		echo '<div id="tabCon_'.$tabs_items_cate_arr[$j].'" class="tabContainer">';
		$list = new item_list();
		$list->set_list_mod(6);
		$list->set_list_row(1);
		$list->set_list_skin(G5_SHOP_SKIN_PATH.'/_block_item.skin.php');
		$list->set_img_size(350, 350);
		$list->set_category($tabs_items_cate_arr[$j], 1);
		$list->set_category($tabs_items_cate_arr[$j], 2);
		$list->set_category($tabs_items_cate_arr[$j], 3);
		$list->set_items_cols(4);
		$list->set_items_gap(30);
		$list->set_items_radius($items_radius);
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