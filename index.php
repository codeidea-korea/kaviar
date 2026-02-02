<?php
include_once('./_common.php');

define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/index.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_PATH.'/head.php');




if(!defined('G5_THEME_PATH')) {
	echo '<div style="position:fixed;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;flex-direction:column;gap:20px;">';
	if($is_member) {
		if($is_admin) {
			echo '<a href="'.correct_goto_url(G5_ADMIN_URL).'theme.php" style="padding:0 10px;height:30px;border:1px solid rgba(0,0,0,0.4);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;">테마 설정하기</a>';
		} else {
			echo '<p style="font-size:15px;font-weight:bold;">관리자 계정이 아닙니다.</p>';
			echo '<a href="'.G5_BBS_URL.'/logout.php?url='.$urlencode.'" style="padding:0 10px;height:30px;border:1px solid rgba(0,0,0,0.4);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;">로그아웃</a>';
		}
	} else {
		echo '<p style="font-size:15px;font-weight:bold;">설정된 테마가 없습니다. 관리자 로그인후 테마를 설정해 주세요.</p>';
		echo '<a href="'.G5_BBS_URL.'/login.php" style="padding:0 10px;height:30px;border:1px solid rgba(0,0,0,0.4);border-radius:5px;display:inline-flex;align-items:center;justify-content:center;">로그인 페이지로 이동</a>';
	}
	echo '</div>';
}




include_once(G5_PATH.'/tail.php');