<?php
include_once('./_common.php');

if (!$member['mb_id'])
    alert('회원만 접근하실 수 있습니다.');

if ($is_admin == 'super')
    alert('최고 관리자는 탈퇴할 수 없습니다');

$post_mb_password = isset($_POST['mb_password']) ? trim($_POST['mb_password']) : '';

if (!($post_mb_password && check_password($post_mb_password, $member['mb_password'])))
    alert('비밀번호가 틀립니다.');

// 회원탈퇴일을 저장
$date = date("Ymd");
$sql = " update {$g5['member_table']} set mb_leave_date = '{$date}', mb_memo = '".date('Ymd', G5_SERVER_TIME)." 탈퇴함\n".sql_real_escape_string($mb['mb_memo'])."', mb_certify = '', mb_adult = 0, mb_dupinfo = '' where mb_id = '{$member['mb_id']}' ";
sql_query($sql);

// 3.09 수정 (로그아웃)
unset($_SESSION['ss_mb_id']);
foreach($_SESSION as $key => $value) {
    if(substr($key, 0, 3) == 'ss_') {  // 그누보드는 세션변수를 'ss_' 접두어로 시작
        unset($_SESSION[$key]);
    }
}

// 또는 완전한 세션 종료를 위해서는
session_destroy();

if (!$url)
    $url = G5_URL;

//소셜로그인 해제
if(function_exists('social_member_link_delete')){
    social_member_link_delete($member['mb_id']);
}

alert(''.$member['mb_nick'].'님께서는 '. date("Y년 m월 d일") .'에 회원에서 탈퇴 하셨습니다.', $url);