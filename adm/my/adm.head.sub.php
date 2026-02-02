<?php
if (!defined('_GNUBOARD_')) exit;

include_once(G5_ADMIN_PATH.'/my/adm.lib.php');
include_once(G5_LIB_PATH.'/my/get_my.lib.php');
if($theme_type == 'shop') include_once(G5_LIB_PATH.'/my/_shop_my.lib.php'); //인태

if(!is_dir(G5_THIS_PATH)){
	@mkdir(G5_THIS_PATH, G5_DIR_PERMISSION);
	@chmod(G5_THIS_PATH, G5_DIR_PERMISSION);
}

// [_common]
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/_common.js').'"></script>', 1);
// [bootstrap-select]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.css').'">', 1);
add_javascript('<script src="'.G5_JS_URL.'/my/form/bootstrap-select/bootstrap.min.js"></script>', 1);
if (!strstr($_SERVER['REQUEST_URI'], 'sms_write.php'))
	add_javascript('<script src="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.js').'"></script>', 1);
// [datepicker]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.ko-KR.js').'"></script>', 1);
// [colorpicker]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.css').'">', 1);
add_javascript('<script src="'.G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.js"></script>', 1);
// [myform]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);
add_javascript('<script src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>', 1);
//add_javascript('<script src="'.get_url(G5_JS_URL.'/my/form/myform-lg.js').'"></script>', 1);

// [adminScript]
add_javascript('<script src="'.get_url(G5_ADMIN_URL.'/my/adminScript.js').'"></script>', 15);