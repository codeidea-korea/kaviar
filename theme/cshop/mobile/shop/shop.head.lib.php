<?php
if (!defined('_GNUBOARD_')) exit;

$shop_header_ui = explode("|", $default['shop_header_ui']);
$shop_header_ui_type = $shop_header_ui[0];

$shop_header_color = explode("|", $default['shop_header_color']);

if(!$shop_header_ui[1]) $topMenu_skip = true;

//헤더 상단 높이
$header_top_height = $head_title ? 55 : 62;
//탑메뉴 높이
$header_menu_height = 40;
$header_height = $topMenu_skip ? $header_top_height : $header_top_height + $header_menu_height;


//헤더 높이 + 탑메뉴 높이
$headerSpace_height = $topMenu_skip ? $header_height : $header_height + $topMenu_height;
//하단 네비게이션 높이
$bottomTabMenu_height = 64;
//콘텐츠여역 최소높이
$_style_min_height = 'calc(var(--vh) - '.($headerSpace_height + $bottomTabMenu_height).'px);';


//임시 로고 (등록된 로고가 없을때)
$tmp_shop_logo = '<span class="tmp-logo">'.$config['cf_title'].'</span>';

$shop_logo_mobile_path = G5_DATA_PATH.'/logo/shop_logo_mobile.png';
$shop_logo_mobile_url = G5_DATA_URL.'/logo/shop_logo_mobile.png';
$shop_logo_mobile_w_path = G5_DATA_PATH.'/logo/shop_logo_mobile_w.png';
$shop_logo_mobile_w_url = G5_DATA_URL.'/logo/shop_logo_mobile_w.png';
$is_shop_logo_mobile = file_exists($shop_logo_mobile_path) ? true : false;
$shop_logo = '<a href="'.G5_SHOP_URL.'" class="top-header-logo" alt="'.$config['cf_title'].'">';
$shop_logo .= $is_shop_logo_mobile ? '<img src="'.get_url($shop_logo_mobile_url).'" alt="'.$config['cf_title'].'" class="shop_logo_mobile_c"><img src="'.get_url($shop_logo_mobile_w_url).'" alt="'.$config['cf_title'].'" class="shop_logo_mobile_w">' : $tmp_shop_logo;
$shop_logo .= '</a>';



//헤더 아이콘
$shop_hdIcon_home_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_home.svg';
$shop_hdIcon_home_url = str_replace(G5_PATH, G5_URL, $shop_hdIcon_home_path);
$shop_hdIcon_brand_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_brand.svg';
$shop_hdIcon_brand_url = str_replace(G5_PATH, G5_URL, $shop_hdIcon_brand_path);
$shop_hdIcon_search_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_search.svg';
$shop_hdIcon_search_url = str_replace(G5_PATH, G5_URL, $shop_hdIcon_search_path);
$shop_hdIcon_cart_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_cart.svg';
$shop_hdIcon_cart_url = str_replace(G5_PATH, G5_URL, $shop_hdIcon_cart_path);
$shop_hdIcon_store_path = G5_DATA_PATH.'/shop_icon/shop_hdIcon_store.svg';
$shop_hdIcon_store_url = str_replace(G5_PATH, G5_URL, $shop_hdIcon_store_path);



$hdIcon_home = '<i class="myIcon"></i>';
$hdIcon_brand = file_exists($shop_hdIcon_brand_path) ? '<img src="'.get_url($shop_hdIcon_brand_url).'">' : '<i class="myIcon"></i>';
$hdIcon_search = file_exists($shop_hdIcon_search_path) ? '<img src="'.get_url($shop_hdIcon_search_url).'">' : '<i class="myIcon"></i>';
$hdIcon_cart = file_exists($shop_hdIcon_cart_path) ? '<img src="'.get_url($shop_hdIcon_cart_url).'">' : '<i class="myIcon"></i>';
$hdIcon_store = file_exists($shop_hdIcon_store_path) ? '<img src="'.get_url($shop_hdIcon_store_url).'">' : '<i class="myIcon"></i>';





$header_class = '';
if(!$head_title) {
	if($default['shop_header_scrollhidden']==1 || ($default['shop_header_scrollhidden']==2 && $topMenu_skip)) $header_class .= 'scrollTrigger';
	if($default['shop_header_scrollhidden']==2 && !$topMenu_skip) $header_class .= 'scrollTrigger2';
}
$header_var = '';
$header_var .= '--header-height:'.$header_height.'px;';
$header_var .= '--header-top-height:'.$header_top_height.'px;';
if(!$topMenu_skip) $header_var .= '--header-menu-height:'.$header_height.'px;';
if(!$head_title) {
	$header_var .= $shop_header_color[0] ? '--header-bg:'.$shop_header_color[0].';':'';
	$header_var .= $shop_header_color[1] ? '--header-color:'.$shop_header_color[1].';':'';
}
