<?php
if (!defined('_GNUBOARD_')) exit;
$headerStyle = '';

//임시 로고 (등록된 로고가 없을때)
$tmp_top_logo = '<span class="tmp-logo top_logo_c">'.$config['cf_title'].'</span><span class="tmp-logo top_logo_w">'.$config['cf_title'].'</span>';

$home_url = $group['gr_use_layout'] ? G5_BBS_URL.'/group.php?gr_id='.$group['gr_id'] : G5_URL;


$header_top_bg = explode("|",$config_mobile['cfm_top_bg']);
$header_menu_top_bg = explode("|",$config_mobile['cfm_menu_top_bg']);
$header_menu_color = explode("|",$config_mobile['cfm_menu_color']);
if($header_top_bg[0]) {
	$headerStyle .= '#header{background:'.$header_top_bg[0].';}';
	$headerStyle .= '#header:after{display:none;}';
}
if($header_top_bg[1]) {
	$headerStyle .= '#header{--textColor:#fff;--subColor:rgba(255,255,255,0.6);}';
	$headerStyle .= '#header .top_logo .top_logo_c{opacity:0;}';
	$headerStyle .= '#header .top_logo .top_logo_w{opacity:1;}';
}
if($config_mobile['cfm_menu_bg'] || $header_menu_color[0] || $header_menu_color[1]) {
	$headerStyle .= '#navContainer{';	
	if($header_menu_top_bg[0]) $headerStyle .= '--nav-top-bg:'.$header_menu_top_bg[0].';';
	if($header_menu_top_bg[1]) $headerStyle .= '--nav-top-sub-bg:'.$header_menu_top_bg[1].';';
	if($config_mobile['cfm_menu_bg']) $headerStyle .= '--nav-bg:'.$config_mobile['cfm_menu_bg'].';';
	if($header_menu_color[0]) $headerStyle .= '--menuColor:'.$header_menu_color[0].';';
	if($header_menu_color[1]) $headerStyle .= '--menuActiveColor:'.$header_menu_color[1].';';
	$headerStyle .= '}'.PHP_EOL;
}

$header_layout = $config_mobile['cfm_top_layout'] ? 'slideNav-right' : 'slideNav-left';



//탑 로고
$top_logo_path_c = G5_DATA_PATH.'/logo/logo_mobile_c.png';
$top_logo_path_w = G5_DATA_PATH.'/logo/logo_mobile_w.png';
if(file_exists($top_logo_path_c) && file_exists($top_logo_path_w)) {
	$top_logo_url_c = str_replace(G5_DATA_PATH, G5_DATA_URL, $top_logo_path_c);
	$top_logo_url_w = str_replace(G5_DATA_PATH, G5_DATA_URL, $top_logo_path_w);
	$is_top_logo = true;
} else {
	$is_top_logo = false;
}
$top_logo = '<a href="'.$home_url.'" class="top_logo">';
$top_logo .= $is_top_logo ? '<img src="'.get_url($top_logo_url_c).'" alt="'.$config['cf_title'].'" class="top_logo_c"><img src="'.get_url($top_logo_url_w).'" alt="'.$config['cf_title'].'" class="top_logo_w">' : $tmp_top_logo;
$top_logo .= '</a>';