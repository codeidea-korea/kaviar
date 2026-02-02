<?php
include_once('./_common.php');

if( function_exists('social_check_login_before') ){
    $social_login_html = social_check_login_before();
}

//인태 - 별도 인트로 페이지를 운영할때 사용.. ───────────────────────────────────────────
if($pn) {
	if(file_exists(G5_THIS_PATH.'/member/'.$pn.'.php')) {
		require_once(G5_THIS_PATH.'/member/'.$pn.'.php');
		return;
	} else if(file_exists(G5_THEME_PATH.'/member/'.$pn.'.php')) {
		require_once(G5_THEME_PATH.'/member/'.$pn.'.php');
		return;
	}
}
// ───────────────────────────────────────────────────────────────────────

$g5['title'] = '로그인';
include_once('./_head.sub.php');

$url = isset($_GET['url']) ? strip_tags($_GET['url']) : '';
$od_id = isset($_POST['od_id']) ? safe_replace_regex($_POST['od_id'], 'od_id') : '';

// url 체크
check_url_host($url);

// 이미 로그인 중이라면
if ($is_member && $mode !='admin') {
    if ($url)
        goto_url($url);
    else
        goto_url(G5_URL);
}

$login_url        = login_url($url);
$login_action_url = G5_HTTPS_BBS_URL."/login_check.php";

if($theme_type=='shop') $member_skin_path = $member_skin_path.'/shop';
if(file_exists(G5_THEME_PATH.'/member/login.skin.php')) $member_skin_path = G5_THEME_PATH.'/member'; //인태 - 테마에 로그인 스킨이 있다면..
$_inc_file = $member_skin_path.'/login.skin.php';
if(!file_exists($_inc_file)) $member_skin_path   = G5_SKIN_PATH.'/member/basic';

include_once($member_skin_path.'/login.skin.php');

run_event('member_login_tail', $login_url, $login_action_url, $member_skin_path, $url);

include_once('./_tail.sub.php');