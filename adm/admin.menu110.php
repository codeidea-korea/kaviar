<?php
if($theme_type == 'shop') {
	$menu['menu110'] = array (
		array('110000', '추가설정 관리', G5_ADMIN_URL.'/my/header_setting.php', 'header'),	
		array('110300', '쇼핑몰 로고 등록', G5_ADMIN_URL.'/shop_admin/my/shop_logo_register.php', 'cf_shop_logo'),
		array('110400', '카피라이트 등록', G5_ADMIN_URL.'/shop_admin/my/shop_copyright_register.php', 'cf_shop_copyright'),
		//array('110500', '메인페이지 관리', G5_ADMIN_URL.'/my/mainpage_setting.php', 'config_mainpage'),
		//array('110600', 'URL 일괄 변경', G5_ADMIN_URL.'/my/editor_reurl.php', 'editor_reurl'),
		//array('110700', '모바일 설정', G5_ADMIN_URL.'/my/config_mobile.php',   'config_mobile')
	);
} else {
	$menu['menu110'] = array (
		array('110000', '추가설정 관리', G5_ADMIN_URL.'/my/header_setting.php', 'header'),	
		array('110200', '해더 관리 ('.$config['cf_theme'].')', G5_ADMIN_URL.'/my/header_setting.php', 'header'),
		array('110300', '로고 등록', G5_ADMIN_URL.'/my/logo_register.php', 'cf_logo'),
		array('110400', '카피라이트 등록', G5_ADMIN_URL.'/my/copyright_register.php', 'cf_copyright'),
		array('110500', '메인페이지 관리', G5_ADMIN_URL.'/my/mainpage_setting.php', 'config_mainpage'),
		array('110600', 'URL 일괄 변경', G5_ADMIN_URL.'/my/editor_reurl.php', 'editor_reurl'),
		array('110700', '모바일 설정', G5_ADMIN_URL.'/my/config_mobile.php',   'config_mobile')
		//array('110710', 'SNS 바로가기', G5_ADMIN_URL.'/my/sns_link.php', 'sns_link'),	
	);
}