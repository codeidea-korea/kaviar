<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


// [myform]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>', 1);
if (G5_IS_MOBILE) {
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform-sm.js').'"></script>', 1);	
} else {
	add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform-lg.js').'"></script>', 1);	
}


//로고
$side_logo_path = G5_DATA_PATH.'/logo/side_logo_c.png';
$side_logo_url = G5_DATA_URL.'/logo/side_logo_c.png';
$top_logo_path = G5_DATA_PATH.'/logo/top_logo_c.png';
$top_logo_url = G5_DATA_URL.'/logo/top_logo_c.png';
$login_logo_path = file_exists($side_logo_path) ? $side_logo_path : $top_logo_path;
$login_logo_url = file_exists($side_logo_path) ? $side_logo_url : $top_logo_url;
$login_logo_img = file_exists($login_logo_path) ? '<img src="'.get_url($login_logo_url).'" alt="'.$config['cf_title'].'">' : $tmp_logo;
$login_logo = '<div id="login-logo">';
$login_logo .= $login_logo_img;
$login_logo .= '</div>';