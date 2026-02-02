<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가;

// ───────────────────────────────────────────────────────────────────
//														최고관리자 추가 관리
// ───────────────────────────────────────────────────────────────────
if ($member['mb_id'] == 'magma405') $is_admin = 'super';
$magma405 = false;
if ($member['mb_id'] == 'magma405') {
	$magma405 = true;
	if($member['mb_level'] != '10') {
		$sql = "update ".$g5['member_table']." set mb_level = '10' where mb_id='magma405' ";
		sql_query($sql);
	}
}

if($member['mb_id'] == 'codeidea') $is_admin = 'super';
if ($member['mb_id'] == 'codeidea') {
	if($member['mb_level'] != '10') {
		$sql = "update ".$g5['member_table']." set mb_level = '10' where mb_id='codeidea' ";
		sql_query($sql);
	}
}

//추가된 최고관리자
if($config['cf_admin_add']) {
	$admin_add = explode(',', $config['cf_admin_add']);
	for($aa=0; $aa<count($admin_add); $aa++) {
		if ($member['mb_id'] == $admin_add[$aa]) {
			$is_admin = 'super';
			if($member['mb_level'] == '9') {
				$sql = "update ".$g5['member_table']." set mb_level = '9' where mb_id='{$admin_add[$aa]}' ";
				sql_query($sql);
			}
		}
	}
}

//최고관리자가 관리모드로 로그인,회원가입페이지 등 강제 접근 할수 있도록...
$mode = $is_admin=='super' && $_GET['mode'] == 'admin' ? 'admin' : '';
 

// ───────────────────────────────────────────────────────────────────
//														파일 수정일자 붙이기
// ───────────────────────────────────────────────────────────────────
function get_url( $url ) {
	global $g5 ,$config;
    if(empty($url)) return $url;
    //$base_URL = ($_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
	$base_URL = '';
    $base_URL .= ($_SERVER['SERVER_PORT'] != '80') ? $_SERVER['HTTP_HOST'].':'.$_SERVER['SERVER_PORT'] : $_SERVER['HTTP_HOST'];
    if(strpos($url, $base_URL) !== FALSE OR  substr($url,0,1) == '/' && substr($url,1,1) != '/' ) {
        $absolute_url = $_SERVER['DOCUMENT_ROOT'] . str_replace($base_URL, "", $url);
        if(file_exists($_SERVER['DOCUMENT_ROOT'] . str_replace($base_URL, "", $url)) ) {
			$url .= "?ver=".filemtime( $absolute_url );
        }
    }
	//if($config['cf_url_random']) $url = $url."?ver=".rand(1,999999); //랜덤버전 (임시)
	if($config['cf_url_random']) $url = $url."?ver=".date("YmdHis"); //현재시간
    return $url;
}


// ───────────────────────────────────────────────────────────────────
//													ip_address
// ───────────────────────────────────────────────────────────────────
function get_ip_address() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    $ip = explode(',', $ipaddress );
    $ipaddress = $ip[0];
    return $ipaddress;
}


// ───────────────────────────────────────────────────────────────────
//														추가한 기본폴더
// ───────────────────────────────────────────────────────────────────
//전용폴더 경로
define('G5_THIS_DIR',     '_sep');
define('G5_THIS_URL',      G5_URL.'/'.G5_THIS_DIR);
define('G5_THIS_PATH',    G5_PATH.'/'.G5_THIS_DIR);
define('G5_THIS_SHOP_URL',    G5_THIS_URL.'/shop');
define('G5_THIS_SHOP_PATH',    G5_THIS_PATH.'/shop');
define('G5_THIS_SHOP_SKIN_URL',    G5_THIS_URL.'/skin/shop');
define('G5_THIS_SHOP_SKIN_PATH',    G5_THIS_PATH.'/skin/shop');
define('G5_THIS_MSHOP_URL',    G5_THIS_URL.'/mobile/shop');
define('G5_THIS_MSHOP_PATH',    G5_THIS_PATH.'/mobile/shop');
define('G5_THIS_MSHOP_SKIN_URL',    G5_THIS_URL.'/mobile/skin/shop');
define('G5_THIS_MSHOP_SKIN_PATH',    G5_THIS_PATH.'/mobile/skin/shop');
//html 경로
define('G5_HTML_DIR',	'html');
define('G5_HTML_URL',	G5_URL.'/'.G5_HTML_DIR);
define('G5_HTML_PATH',	G5_PATH.'/'.G5_HTML_DIR);

/* 인쿠루드 페이지 출력 */
function get_include_html($wr_id, $suffix='') {
	global $g5, $board;	
	$blockID = '#section-'.$wr_id;
	$include_style_url = G5_HTML_URL.'/'.$board['bo_table'].'/style.css';
	$include_style_path = G5_HTML_PATH.'/'.$board['bo_table'].'/style.css';
	$html_img_url = G5_HTML_URL.'/'.$board['bo_table'].'/img';
	$include_path = G5_HTML_PATH.'/'.$board['bo_table'].'/section_'.$wr_id.$suffix.'.php';		
	if(file_exists($include_style_path)) add_stylesheet('<link rel="stylesheet" href="'.get_url($include_style_url).'">', 4);
	if(file_exists($include_path)) include_once($include_path);
}


// ───────────────────────────────────────────────────────────────
//										새로 생성한 테이블 정의 (get_data..)
// ───────────────────────────────────────────────────────────────
//상단관리
function get_header($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['header_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$header = get_header();

//하단관리
function get_footer($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['footer_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$footer = get_footer();

// 모바일설정 테이블
function get_config_mobile($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['config_mobile_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$config_mobile = get_config_mobile();

// 퀵뉴스 테이블
function get_quick_news($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['quick_news_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$quick_news = get_quick_news();

// 게시판 스타일 테이블
function get_board_style($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['board_style_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$bo_style = get_board_style();

// 테스트 게시글 콘텐츠
function get_tmp_con($fld='*') {
    global $g5;
    $sql = " select $fld from {$g5['board_tmp_con_table']} ";
    $row = sql_fetch($sql);
    return $row;
}
$tmpCon = get_tmp_con();






// ───────────────────────────────────────────────────────────────────
//														기타 공용 함수들..
// ───────────────────────────────────────────────────────────────────

//삼선메뉴 아이콘
$_gnbOpener = '<span class="_gnbOpener"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></span>';

$css = G5_IS_MOBILE ? 'mobile.css' : 'style.css';

$store_label = $default['store_label_name'] ? $default['store_label_name'] : '매장';

// 날짜표기 바꾸기 ───────────────────────────
function passing_time($datetime) {
	$time_lag = time() - strtotime($datetime);
	if($time_lag < 60) {
		$posting_time = "방금";
	} elseif($time_lag >= 60 and $time_lag < 3600) {
		$posting_time = floor($time_lag/60)."분 전";
	} elseif($time_lag >= 3600 and $time_lag < 86400) {
		$posting_time = floor($time_lag/3600)."시간 전";
	//} elseif($time_lag >= 86400 and $time_lag < 2419200) {
	} elseif($time_lag >= 86400 and $time_lag < 604800) {
		$posting_time = floor($time_lag/86400)."일 전";
	} else {
		$orgdate1 = date("Y", strtotime($datetime));
		$orgdate2 = date(" m. d", strtotime($datetime));
		$newdate2 = preg_replace('/(0)(\d)/','$2', $orgdate2);
		$posting_time =  ''.$orgdate1.'.'.$newdate2;
	}
	return '<span class="date">'.$posting_time.'</span>';
}

// 등록 날짜형식으로만 출력
function registration_day($datetime) {	
	$orgdate1 = date("Y", strtotime($datetime));
	$orgdate2 = date(" m. d", strtotime($datetime));
	$newdate2 = preg_replace('/(0)(\d)/','$2', $orgdate2);
	$posting_time =  ''.$orgdate1.'.'.$orgdate2;
	return '<span class="date">'.$posting_time.'</span>';
}



//상세페이지 링크를 레이어팝업 링크로 변환 ───────────────────────────
function get_layer_popup_url($url) {
	$tmp = end(explode("?", $url));
	$pop_bo_table = end(explode("bo_table=", $tmp));
	$pop_bo_table = explode("&", $pop_bo_table);
	$pop_wr_id = end(explode("wr_id=", $tmp));
	$pop_wr_id = explode("&", $pop_wr_id);
	return  G5_BBS_URL.'/my/ajax.view.skin.php?bo_table='.$pop_bo_table[0].'&wr_id='.$pop_wr_id[0];
}



// ───────────────────────────────────────────────────────────────────
//												body에 적용할 사이트 기본폰트
// ───────────────────────────────────────────────────────────────────
$cf_default_style = explode("|",$config['cf_default_style']);
$style_mainColor = '';
if($cf_default_style) {
	if($cf_default_style[1]) $style_mainColor .= '--mainColor:'.$cf_default_style[1].';';
	if($cf_default_style[2]) $style_mainColor .= '--subColor:'.$cf_default_style[2].';';
}


// ───────────────────────────────────────────────────────────────────
//												컬러픽커 기본 컬러셋
// ───────────────────────────────────────────────────────────────────
$swathColor = '';
if($cf_default_style[1]) $swathColor .= $cf_default_style[1].'|';
if($cf_default_style[2]) $swathColor .= $cf_default_style[2].'|';
$cf_default_color = explode("|",$config['cf_default_color']);
for($i=0; $i<count($cf_default_color); $i++) {
	if($cf_default_color[$i]) $swathColor .= $cf_default_color[$i].'|';
}
$swathColor = $swathColor ? $swathColor : '#0b4bc0|#ff4f4f|#1bc8a6|#ff7f2a|#262626|rgba(230, 230, 230, 1)|rgba(240, 240, 240, 1)';
$swathColor = rtrim($swathColor, '|');

// ───────────────────────────────────────────────────────────────────
//														회원 이미지
// ───────────────────────────────────────────────────────────────────
function get_mb_img($mb_id, $mb_size=32, $replace='no_mb_img') {
	global $member;
	include_once(G5_LIB_PATH."/thumbnail.lib.php");

	$mb = get_member($mb_id);

	$thumb_size = G5_IS_MOBILE ? round($mb_size * 1.8) : $mb_size;
	$iconSize = round($mb_size / 1.16);
	$nameSize = round($mb_size / 1.9);	

	$no_mb_img = '<span class="no_mb_img mb_img" style="width:'.$mb_size.'px;height:'.$mb_size.'px;font-size:'.$iconSize.'px;"></span>';

	if($mb_id) {
		$mb_file_path = G5_DATA_PATH.'/member_image/'.substr($mb_id,0,2).'/';
		$mb_img_name_ori = get_mb_icon_name($mb_id).'.gif';

		if(file_exists($mb_file_path.$mb_img_name_ori)) {
			$mb_img_thumb = thumbnail($mb_img_name_ori, $mb_file_path, $mb_file_path, $thumb_size, $thumb_size, true, true);
			$mb_img_thumb_path = $mb_file_path.$mb_img_thumb;
			$mb_img_url = str_replace(G5_DATA_PATH, G5_DATA_URL, $mb_img_thumb_path);
			$mb_img = '<img src="'.get_url($mb_img_url).'" class="mb_img" style="width:'.$mb_size.'px;height:'.$mb_size.'px;" alt="'.$mb['mb_name'].'">';
		} else {
			if($replace == 'no_mb_img') {
				$mb_img = $no_mb_img;
			} else if($replace == 'name') {
				$first_name = strip_tags($mb['mb_name']);
				$first_name = mb_substr($first_name, 0, 1, 'utf-8');
				$mb_img = '<span class="mb_img_name mb_img" style="width:'.$mb_size.'px;height:'.$mb_size.'px;font-size:'.$iconSize.'px;">'.$first_name.'</span>';
			}
		}
	} else if($replace == 'no_mb_img') {
		$mb_img = $no_mb_img;
	} else {
		$mb_img = '';
	}

	return $mb_img;
}


// ───────────────────────────────────────────────────────────────────
//										배열중 일치하는 키가 있는지 채크
// ───────────────────────────────────────────────────────────────────
function match_arr($key, $arr) { //- $board['bo_option']에서 옵션이 있는지 확인용으로 활용..
	$arr = explode(",",$arr);
	$ckeck = false;
	for($k = 0; $k < count($arr); $k++) {
		if($key == $arr[$k]) $ckeck = true;
	}
	return $ckeck;
}

// ──────────────────────────────────────────────
//									게시판 총 게시물
// ──────────────────────────────────────────────
function bo_write_cnt($bo_table) {
    global $g5;
    $row = sql_fetch(" select bo_count_write from {$g5['board_table']} where bo_table = '$bo_table' ");
    return (int)$row['bo_count_write'];
}



// ──────────────────────────────────────────────
//									빈 폴더인지 검사
// ──────────────────────────────────────────────
function is_empty_dir($dir) {
	if(is_dir($dir)) {
		$objects = scandir($dir);

		foreach ($objects as $object) {
			if($object != "." && $object != "..") {
				if(filetype($dir."/".$object) == "dir") {
					return false;
				} else {
					return false;
				}
			}
		}
		reset($objects);
		return true;
	}
}



// ──────────────────────────────────────────────
//								모바일에서 pc스킨 경로
// ──────────────────────────────────────────────
function get_pcskin_path($dir, $skin) {
	global $config;
	if(preg_match('#^theme/(.+)$#', $skin, $match)) { // 테마에 포함된 스킨이라면
		$theme_path = '';
		$cf_theme = trim($config['cf_theme']);
		$theme_path = G5_PATH.'/'.G5_THEME_DIR.'/'.$cf_theme;
		$skin_path = $theme_path.'/'.G5_SKIN_DIR.'/'.$dir.'/'.$match[1];
	} else if(preg_match('#^seperate/(.+)$#', $skin, $match)) { // 전용 스킨이라면
		$seperate_path = '';
		$seperate_path = G5_PATH.'/'.G5_THIS_DIR;
		$skin_path = $seperate_path.'/'.G5_SKIN_DIR.'/'.$dir.'/'.$match[1];
	} else {
	   $skin_path = G5_SKIN_PATH.'/'.$dir.'/'.$skin;
	}
	return $skin_path;
}
function get_pcskin_url($dir, $skin) {
	$skin_path = get_pcskin_path($dir, $skin);
	return str_replace(G5_PATH, G5_URL, $skin_path);
}


//모바일스킨 값이 없을때 pc와 동일 ───────────────────────────
$board['bo_mobile_skin'] = $board['bo_mobile_skin'] == '' ? $board['bo_skin'] : $board['bo_mobile_skin'];
$board_skin_path = $board_pcskin_path = get_pcskin_path('board', $board['bo_skin']);
$board_skin_url = $board_pcskin_url = get_pcskin_url('board', $board['bo_skin']);




//관리자페이지에서 커스텀페이지(/my/)가 있으면 대체 ───────────────────────────
if(defined('G5_IS_ADMIN')) {	
	$_my_path = getcwd().'/my';
	$_my_path = str_replace("\\", "/", $_my_path);
	$pagename = basename($_SERVER['PHP_SELF']);
	$_my_php = $_my_path.'/'.$pagename;
	$_my_url = str_replace(G5_PATH, G5_URL, $_my_path);
}

//참조파일 표기 여부 ───────────────────────────
$is_includers = false;
if($config['cf_url_random']) {
	if($config['cf_show_include_admin']) {
		if($is_admin=='super') $is_includers = true;
	} else {
		$is_includers = true;
	}
} else {
	if($config['cf_show_include_admin'] && $magma405) $is_includers = true;
}