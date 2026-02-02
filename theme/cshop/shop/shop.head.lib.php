<?php
if (!defined('_GNUBOARD_')) exit;


//임시 로고 (등록된 로고가 없을때)
$tmp_shop_logo = '<span class="tmp-logo">'.$config['cf_title'].'</span>';

$shop_logo_path_c = G5_DATA_PATH.'/logo/shop_logo_c.png';
$shop_logo_url_c = G5_DATA_URL.'/logo/shop_logo_c.png';
$shop_logo_path_w = G5_DATA_PATH.'/logo/shop_logo_w.png';
$shop_logo_url_w = G5_DATA_URL.'/logo/shop_logo_w.png';
$is_shop_logo_c = file_exists($shop_logo_path_c) ? true : false;
$is_shop_logo_w = file_exists($shop_logo_path_w) ? true : false;
$is_shop_logo = file_exists($shop_logo_path_c) && file_exists($shop_logo_path_w) ? true : false;

$shop_logo_c = '<a href="'.G5_SHOP_URL.'" class="top-header-logo" alt="'.$config['cf_title'].'">';
$shop_logo_c .= $is_shop_logo_c ? '<img src="'.get_url($shop_logo_url_c).'" alt="'.$config['cf_title'].'" class="shop_logo_c">' : $tmp_shop_logo;
$shop_logo_c .= '</a>';
$shop_logo_w = '<a href="'.G5_SHOP_URL.'" class="top-header-logo" alt="'.$config['cf_title'].'">';
$shop_logo_w .= $is_shop_logo_w ? '<img src="'.get_url($shop_logo_url_w).'" alt="'.$config['cf_title'].'" class="shop_logo_w">' : $tmp_shop_logo;
$shop_logo_w .= '</a>';

$shop_logo = '<a href="'.G5_SHOP_URL.'" class="top-header-logo" alt="'.$config['cf_title'].'">';
$shop_logo .= $is_shop_logo ? '<img src="'.get_url($shop_logo_url_c).'" alt="'.$config['cf_title'].'" class="shop_logo_c"><img src="'.get_url($shop_logo_url_w).'" alt="'.$config['cf_title'].'" class="shop_logo_w">' : $tmp_shop_logo;
$shop_logo .= '</a>';



