<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($is_member) {
    goto_url(G5_URL);
}

//가입코드 체크
include_once(G5_BBS_PATH.'/my/member/_get_check_join_code.php');
check_join_code($_POST['join_code']);

// 세션을 지웁니다.
set_session("ss_mb_reg", "");

if($pn) {
	if(file_exists(G5_THIS_PATH.'/member/'.$pn.'.php')) { //인태 - 별도 인트로 페이지를 운영할때 사용..
		require_once(G5_THIS_PATH.'/member/'.$pn.'.php');
		return;
	} else if(file_exists(G5_THEME_PATH.'/member/'.$pn.'.php')) { //인태 - 별도 인트로 페이지를 운영할때 사용..
		require_once(G5_THEME_PATH.'/member/'.$pn.'.php');
		return;
	}
}

$g5['title'] = '회원가입약관';
if($theme_type=='shop') {
	$is_back = true; //뒤로가기
	$head_title = '회원가입';
	$topMenu_skip = true;
	include_once(G5_SHOP_PATH.'/shop.head.php');
} else {
	include_once('./_head.php');
}

$register_action_url = G5_BBS_URL.'/register_form.php';

if($theme_type=='shop') $member_skin_path = $member_skin_path.'/shop';
if(file_exists(G5_THEME_PATH.'/member/register.skin.php')) $member_skin_path = G5_THEME_PATH.'/member'; //인태 - 테마에 로그인 스킨이 있다면..
$_inc_file = $member_skin_path.'/register.skin.php';
if(!file_exists($_inc_file)) $member_skin_path = G5_SKIN_PATH.'/member/basic';

if($config['cf_use_stipulation']) {	
	include_once($_inc_file);
} else {
	//[회원가입 약관사용여부]가 사용안함이면 바로 입력페이지로 넘어간다. 단 입력한 가입코드가 있으면 전달.
	echo '<form name="fjoincode" action="'.$register_action_url.'" onsubmit="return fjoincode_submit(this);" method="POST" autocomplete="off">';
	if($_POST['join_code']) echo '<input type="hidden" name="join_code" value="'.$_POST['join_code'].'">';
	echo '<input type=submit value="">';
	echo '</form>';
	echo '<script>document.fjoincode.submit();</script>';
}

if($theme_type=='shop') {
	$footer_skip = true;
	include_once(G5_SHOP_PATH.'/shop.tail.php');
} else {
	include_once('./_tail.php');
}