<?php
include_once('./_common.php');

if ($is_guest)
    alert('로그인 한 회원만 접근하실 수 있습니다.', G5_BBS_URL.'/login.php');

$url = isset($_GET['url']) ? clean_xss_tags($_GET['url']) : '';

while (1) {
    $tmp = preg_replace('/&#[^;]+;/', '', $url);
    if ($tmp == $url) break;
    $url = $tmp;
}

//소셜 로그인 한 경우
if( function_exists('social_member_comfirm_redirect') && (! $url || $url === 'register_form.php' || (function_exists('social_is_edit_page') && social_is_edit_page($url) ) ) ){    
    social_member_comfirm_redirect();
}

$g5['title'] = '회원 비밀번호 확인';
if($theme_type=='shop') {
	$is_back = true; //뒤로가기
	$head_title = '회원정보수정';
	$topMenu_skip = true;
	include_once(G5_SHOP_PATH.'/shop.head.php');
} else {
	include_once('./_head.sub.php');
}


// url 체크
check_url_host($url, '', G5_URL, true);

if($url){
    $url = preg_replace('#^/\\\{1,}#', '/', $url);

    if( preg_match('#^/{3,}#', $url) ){
        $url = preg_replace('#^/{3,}#', '/', $url);
    }
}


$url = get_text($url);

if($theme_type=='shop') $member_skin_path = $member_skin_path.'/shop';
if(file_exists(G5_THEME_PATH.'/member/member_confirm.skin.php')) $member_skin_path = G5_THEME_PATH.'/member'; //인태 - 테마에 로그인 스킨이 있다면..
$_inc_file = $member_skin_path.'/member_confirm.skin.php';
if(!file_exists($_inc_file)) $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/member_confirm.skin.php');

if($theme_type=='shop') {
	$footer_skip = true;
	include_once(G5_SHOP_PATH.'/shop.tail.php');
} else {
	include_once('./_tail.sub.php');
}