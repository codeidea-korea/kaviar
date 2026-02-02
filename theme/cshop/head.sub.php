<?php
// 이 파일은 새로운 파일 생성시 반드시 포함되어야 함
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
} else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);

// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

/*
// 만료된 페이지로 사용하시는 경우
header("Cache-Control: no-cache"); // HTTP/1.1
header("Expires: 0"); // rfc2616 - Section 14.21
header("Pragma: no-cache"); // HTTP/1.0
*/
?>
<!doctype html>
<html lang="ko">
<head>
<meta charset="utf-8">
<?php
if (G5_IS_MOBILE) {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" >'.PHP_EOL;
    echo '<meta name="HandheldFriendly" content="true">'.PHP_EOL;
    echo '<meta name="format-detection" content="telephone=no">'.PHP_EOL;
	echo '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'.PHP_EOL;
	if(file_exists(G5_DATA_PATH.'/logo/shop_favorite_mobile.png')) echo '<link rel="apple-touch-icon" href="'.get_url(G5_DATA_URL.'/logo/shop_favorite_mobile.png').'" />'.PHP_EOL;
} else {
    echo '<meta http-equiv="imagetoolbar" content="no">'.PHP_EOL;
    echo '<meta http-equiv="X-UA-Compatible" content="IE=edge">'.PHP_EOL;	
}
if(file_exists(G5_DATA_PATH.'/logo/shop_favorite.ico')) echo '<link rel="shortcut icon" href="'.get_url(G5_DATA_URL.'/logo/shop_favorite.ico').'" />'.PHP_EOL;

if($config['cf_add_meta']) echo $config['cf_add_meta'].PHP_EOL;

$shopmain_img_path = G5_DATA_PATH.'/file/shop_main.png';
$shopmain_img_url = G5_DATA_URL.'/file/shop_main.png';
if(file_exists($shopmain_img_path)) echo '<meta property="og:image" content="'.get_url($shopmain_img_url).'" />';
?>
<title><?php echo $g5_head_title; ?></title>
<?php
echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_reset.css').'">'.PHP_EOL; //초기화(pc,모바일 공용)
if($cf_default_style[0]) add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/font/'.$cf_default_style[0].'.css').'">', 1); //사이트 기본폰트
$title_style = explode("|",$bo_style['title_style']);
if($title_style[0]&&file_exists(G5_CSS_URL.'/font/title/'.$title_style[0].'.css')) echo '<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/font/title/'.$title_style[0].'.css').'">'.PHP_EOL; //제목 폰트
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/font/nanumSN.css').'">', 1); //산돌고딕은 기본
if(file_exists(G5_THEME_PATH.'/css/_theme_reset.css')) add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_CSS_URL.'/_theme_reset.css').'">', 1); //테마전용 - 초기화
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_shop_common.css').'">', 3); //쇼핑몰 공통
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_shop_common'.(G5_IS_MOBILE?'_mobile':'_pc').'.css').'">', 3);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_CSS_URL.'/shop_theme'.(G5_IS_MOBILE?'_mobile':'').'.css').'">', 3); //쇼핑몰 테마전용

add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_util.css').'">', 50); //유틸리티 클래스(pc,모바일 공용)
if(file_exists(G5_THEME_PATH.'/css/_theme_util.css')) add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_CSS_URL.'/_theme_util.css').'">', 51);
if(file_exists(G5_THIS_PATH.'/_common.css')) echo '<link rel="stylesheet" href="'.get_url(G5_THIS_URL.'/_common.css').'">'.PHP_EOL; //현서버 전용(pc,모바일 공용)
if(file_exists(G5_THIS_PATH.'/_style.css') && !G5_IS_MOBILE) echo '<link rel="stylesheet" href="'.get_url(G5_THIS_URL.'/_style.css').'">'.PHP_EOL; //현서버 전용(pc용)
if(file_exists(G5_THIS_PATH.'/_mobile.css') && G5_IS_MOBILE) echo '<link rel="stylesheet" href="'.get_url(G5_THIS_URL.'/_mobile.css').'">'.PHP_EOL; //현서버 전용(모바일용)
?>

<!--[if lte IE 8]>
<link rel="stylesheet" href="<?php echo G5_JS_URL?>/_style.css">
<script src="<?php echo G5_JS_URL ?>/html5.js"></script>
<![endif]-->
<script>
// 자바스크립트에서 사용하는 전역변수 선언
var g5_url       = "<?php echo G5_URL ?>";
var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
var g5_theme_shop_url = "<?php echo G5_THEME_SHOP_URL; ?>";
var g5_shop_url = "<?php echo G5_SHOP_URL; ?>";

<?php if(defined('G5_IS_ADMIN')) { ?>
var g5_admin_url = "<?php echo G5_ADMIN_URL; ?>";
<?php } ?>

</script>
<!--
<script src="<?php echo G5_JS_URL?>/jquery-1.12.4.min.js"></script>
<script src="<?php echo G5_JS_URL?>/jquery-migrate-1.4.1.min.js"></script>
<script src="<?php echo G5_JS_URL?>/common.js?ver='.G5_JS_VER.'"></script>
<script src="<?php echo G5_JS_URL?>/wrest.js?ver='.G5_JS_VER.'"></script>
<script src="<?php echo G5_JS_URL?>/placeholders.min.js"></script>
<script src="<?php echo G5_JS_URL?>/modernizr.custom.70111.js"></script>
-->

<?php
add_javascript('<script src="'.G5_JS_URL.'/jquery-1.12.4.min.js"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/jquery-migrate-1.4.1.min.js"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);
add_javascript('<script src="'.G5_JS_URL.'/modernizr.custom.70111.js"></script>', 1); // overflow scroll 감지
add_javascript('<script type="text/javascript" src="'.get_url(G5_THEME_JS_URL.'/my/dropdown.js').'"></script>', 2);

if(!defined('G5_IS_ADMIN'))
    echo $config['cf_add_script'];
?>
</head>
<body<?php echo isset($g5['body_script']) ? $g5['body_script'] : ''; ?><?=$cf_default_style[0]?' data-font-family="'.$cf_default_style[0].'"':''?><?=$style_mainColor?' style="'.$style_mainColor.'"':''?>>
<?php
if ($is_member) { // 회원이라면 로그인 중이라는 메세지를 출력해준다.
    $sr_admin_msg = '';
    if ($is_admin == 'super') $sr_admin_msg = "최고관리자 ";
    else if ($is_admin == 'group') $sr_admin_msg = "그룹관리자 ";
    else if ($is_admin == 'board') $sr_admin_msg = "게시판관리자 ";

    echo '<div id="hd_login_msg">'.$sr_admin_msg.get_text($member['mb_nick']).'님 로그인 중 ';
    echo '<a href="'.G5_BBS_URL.'/logout.php">로그아웃</a></div>';
}
?>
