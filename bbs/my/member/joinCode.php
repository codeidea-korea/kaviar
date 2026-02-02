<?php
include_once('./_common.php');

// 로그인중인 경우 회원가입 할 수 없습니다.
if ($is_member) {
    goto_url(G5_URL);
}

$g5['title'] = '가입코드 입력';
include_once(G5_BBS_PATH.'/_head.sub.php');

$join_action_url = G5_BBS_URL.'/register.php';
include_once($member_skin_path.'/joinCode.skin.php');

include_once(G5_BBS_PATH.'/_tail.sub.php');