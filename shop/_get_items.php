<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/json.lib.php');

define('G5_IS_SHOP_AJAX_LIST', true);

//$bl_id = $_POST['bl_id'];
//$ca_id = $_POST['ca_id'];
$bl_id = isset($_REQUEST['cbl_id_id']) ? sbl_idfe_replace_regex($_REQUEST['bl_id'], 'bl_id') : '';
$ca_id = isset($_REQUEST['ca_id']) ? safe_replace_regex($_REQUEST['ca_id'], 'ca_id') : '';

$data = array();

@include(G5_THEME_PATH.'/_shop_block_config.php'); //블럭 기본 설정값



$_shopblocksql  = "select * from {$g5['g5_shop_block_table']} where bl_id = '$bl_id' ";
$_shopblock = sql_fetch($_shopblocksql);	

$items_order_option = explode("|", $_shopblock['items_order_option']);
$items_order_option1 = $items_order_option[0];
$items_order_option2 = $items_order_option[1];
$items_order_option3 = $items_order_option[2];

// 목록수 (디폴트)
$items_count = $_shopblock['items_count'] ? $_shopblock['items_count'] : 2;
$items_cols = !G5_IS_MOBILE ? $_shopblock['items_cols'] : $_shopblock['items_cols_mobile'];
// 상품진열 스킨(_slide, _wz, _gall)
$items_skin_arr = explode("|", $_shopblock['items_skin']);
$items_skin = $items_skin_arr[0];
if($_shopblock['bl_type'] == 'banner' && !$items_cols) {
	if($items_skin == '_slide' && !G5_IS_MOBILE) $items_cols = $_banner_cols_slide;
	if($items_skin == '_gall' && !G5_IS_MOBILE) $items_cols = $_banner_cols_gall;
	if($items_skin == '_slide' && G5_IS_MOBILE) $items_cols = $_banner_cols_slide_mobile;
	if($items_skin == '_gall' && G5_IS_MOBILE) $items_cols = $_banner_cols_gall_mobile;
}
if($_shopblock['bl_type'] == 'item' && !$items_cols) {
	if($items_skin == '_slide' && !G5_IS_MOBILE) $items_cols = $_items_cols_slide;
	if($items_skin == '_gall' && !G5_IS_MOBILE) $items_cols = $_items_cols_gall;
	if($items_skin == '_slide' && G5_IS_MOBILE) $items_cols = $_items_cols_slide_mobile;
	if($items_skin == '_gall' && G5_IS_MOBILE) $items_cols = $_items_cols_gall_mobile;
}
//아이템 간격
$items_gap = !G5_IS_MOBILE ? $_shopblock['items_gap'] : $_shopblock['items_gap_mobile'];
if(!$items_gap) {
	if($_shopblock['bl_type'] == 'item' && !G5_IS_MOBILE) $items_gap = $_items_gap;
	if($_shopblock['bl_type'] == 'item' && G5_IS_MOBILE) $items_gap = $_items_gap_mobile;
}
//아이템 라운딩
$items_radius = !G5_IS_MOBILE ? $_shopblock['items_radius'] : $_shopblock['items_radius_mobile'];
if(!$items_radius && !G5_IS_MOBILE && $_items_radius) $items_radius = $_items_radius;
if(!$items_radius && G5_IS_MOBILE && $_items_radius_mobile) $items_radius = $_items_radius;


//썸네일 사이즈
$itemImgSize = $_shopblock['items_cols'] < 2 ? 580 : 350;

//상품 분류 (직접선택이 없을때만 적용)
if($items_order_option1!='list_of_select' && $items_order_option2!='list_of_select') $itemId = $items_order_option1;
//상품 타입 (직접선택이 없을때만 적용)
if($items_order_option1!='list_of_select' && $items_order_option2!='list_of_select') $itemtype = $items_order_option2;



echo $ca_id.$itemId;

// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★
//인태 - 상품 진열 로드가 안되고 있음..
// ★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★★

$list_file = G5_SHOP_SKIN_PATH.'/_block_item.skin.php';
$list = new item_list();
$list->set_list_mod($items_count);
$list->set_list_row(1);
//$list->set_mobile(true);
if($itemtype) $list->set_type($itemtype);
$list->set_list_skin($list_file);
$list->set_img_size($itemImgSize, $itemImgSize);
$list->set_category($ca_id, 1);
$list->set_category($ca_id, 2);
$list->set_category($ca_id, 3);
$list->set_items_cols($items_cols);
$list->set_items_gap($items_gap);
$list->set_items_radius($items_radius);
$list->set_items_skin($_shopblock['items_skin']);
$list->set_view('it_img', true);
$list->set_view('it_id', false);
$list->set_view('it_name', true);
$list->set_view('it_cust_price', true);
$list->set_view('it_price', true);
$list->set_view('it_icon', true);

echo $list->run();
