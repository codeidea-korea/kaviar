<?php
include_once('./_common.php');

if( ($gr_id && $is_admin == 'group') || ($bo_table && $is_admin == 'board') || $is_admin == 'super') {
	$auth_check_pass = true; //인태 -> admin.lib.php
}
if(!$auth_check_pass) {
	echo '<script>window.close();</script>';
	exit;
}
include_once(G5_ADMIN_PATH.'/admin.lib.php');
include_once(G5_ADMIN_PATH.'/my/adm.lib.php');
include_once(G5_LIB_PATH.'/my/get_my.lib.php');
if($theme_type == 'shop') include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태
include_once(G5_PATH.'/css/font/font.extend.php');
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<title><?=$title?$title:'설정';?></title>
<?php
echo '<link rel="shortcut icon" href="'.get_url(G5_IMG_URL.'/my/setting_favorite.ico').'" />';
$_font_css_files = glob(G5_PATH.'/css/font/*');
if (is_array($_font_css_files)) {
    foreach ((array) $_font_css_files as $k=>$css_file) {        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];        
        if( $ext !== 'css' ) continue;        
        $css_file = str_replace(G5_PATH, G5_URL, $css_file);
        echo '<link rel="stylesheet" href="'.$css_file.'">';
    }
}
$_title_font_css_files = glob(G5_PATH.'/css/font/title/*');
if (is_array($_title_font_css_files)) {
    foreach ((array) $_title_font_css_files as $k=>$css_file) {        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];        
        if( $ext !== 'css' ) continue;        
        $css_file = str_replace(G5_PATH, G5_URL, $css_file);
        echo '<link rel="stylesheet" href="'.$css_file.'">';
    }
}
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_reset.css').'">';
if(file_exists(G5_THEME_PATH.'/css/_theme_reset.css')) echo '<link rel="stylesheet" href="'.get_url(G5_THEME_URL.'/css/_theme_reset.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/iconfont/icon-shape/style.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/iconfont/shop/style.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_ADMIN_URL.'/css/adminDefault.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_ADMIN_URL.'/css/admin.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_BBS_URL.'/my/_adm/_adm_style.css').'">';
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_util.css').'">';
if(file_exists(G5_THEME_PATH.'/css/_theme_util.css')) echo '<link rel="stylesheet" href="'.get_url(G5_THEME_URL.'/css/_theme_util.css').'">';
$_adm_css_files = glob(G5_THEME_PATH.'/_adm/_adm_*');
if (is_array($_adm_css_files)) {
    foreach ((array) $_adm_css_files as $k=>$css_file) {
        
        $fileinfo = pathinfo($css_file);
        $ext = $fileinfo['extension'];
        
        if( $ext !== 'css' ) continue;
        
        $css_file = str_replace(G5_THEME_PATH, G5_THEME_URL, $css_file);
        echo '<link rel="stylesheet" href="'.get_url($css_file).'">';
    }
}

echo '<script src="'.G5_JS_URL.'/jquery-1.12.4.min.js"></script>';
echo '<script src="'.get_url(G5_JS_URL.'/my/_common.js').'"></script>';
echo '<script src="'.G5_JS_URL.'/my/form/bootstrap-select/bootstrap.min.js"></script>';
echo '<script src="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.js').'"></script>';
echo '<script src="'.G5_JS_URL.'/my/form/datepicker/datepicker.js"></script>';
echo '<script src="'.G5_JS_URL.'/my/form/datepicker/datepicker.ko-KR.js"></script>';
echo '<script src="'.G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.js"></script>';
echo '<script src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>';
echo '<script src="'.get_url(G5_ADMIN_URL.'/my/adminScript.js').'"></script>';
$_adm_js_files = glob(G5_THEME_PATH.'/_adm/_adm_*');
if (is_array($_adm_js_files)) {
    foreach ((array) $_adm_js_files as $k=>$js_file) {
        
        $fileinfo = pathinfo($js_file);
        $ext = $fileinfo['extension'];
        
        if( $ext !== 'js' ) continue;
        
        $js_file = str_replace(G5_THEME_PATH, G5_THEME_URL, $js_file);
        echo '<script src="'.$js_file.'"></script>';
    }
}
?>
</head>
<body<?=$cf_default_style[0]?' data-font-family="'.$cf_default_style[0].'"':''?><?=$style_mainColor?' style="'.$style_mainColor.'"':''?>>