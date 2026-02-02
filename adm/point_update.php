<?php
$sub_menu = "200200";
include_once('./_common.php');

auth_check_menu($auth, $sub_menu, 'w');

check_admin_token();

if($_POST['chk_all_mb']) { //전체회원일때
	
	$po_point = isset($_POST['po_point']) ? strip_tags(clean_xss_attributes($_POST['po_point'])) : 0;
	$po_content = isset($_POST['po_content']) ? strip_tags(clean_xss_attributes($_POST['po_content'])) : '';
	$expire = isset($_POST['po_expire_term']) ? preg_replace('/[^0-9]/', '', $_POST['po_expire_term']) : '';
	
	$sql = " select mb_id from {$g5['member_table']} where mb_leave_date = '' and mb_intercept_date = '' ";
	$result = sql_query($sql);
	
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		insert_point($row['mb_id'], $po_point, $po_content, '@passive', $row['mb_id'], $member['mb_id'].'-'.uniqid(''), $expire);
	}
	
}else if($_POST['all_mb2'] || $_POST['all_mb3'] || $_POST['all_mb4'] || $_POST['all_mb5'] || $_POST['all_mb6'] || $_POST['all_mb7'] || $_POST['all_mb8']) { //등급별일때
	
	$po_point = isset($_POST['po_point']) ? strip_tags(clean_xss_attributes($_POST['po_point'])) : 0;
	$po_content = isset($_POST['po_content']) ? strip_tags(clean_xss_attributes($_POST['po_content'])) : '';
	$expire = isset($_POST['po_expire_term']) ? preg_replace('/[^0-9]/', '', $_POST['po_expire_term']) : '';
	
	if($_POST['all_mb2'])	$chk_mb[] .= '캐비아|2';
	if($_POST['all_mb3'])	$chk_mb[] .= '실버|3';
	if($_POST['all_mb4'])	$chk_mb[] .= '골드|4';
	if($_POST['all_mb5'])	$chk_mb[] .= '프리미엄|5';
	if($_POST['all_mb6'])	$chk_mb[] .= '임직원|6';
	if($_POST['all_mb7'])	$chk_mb[] .= '큐커플랜|7';
	if($_POST['all_mb8'])	$chk_mb[] .= 'QVIP|8';

	for($m=0; $m < count($chk_mb); $m++){
		$cc = explode("|", $chk_mb[$m]);
		if($m==0){
			$mb_id = $cc[0];
			$mb_grade = $cc[1];
		}else{
			$mb_id = $mb_id.",".$cc[0];
			$mb_grade = $mb_grade.",".$cc[1];
		}
	}
	
	$sql = " select mb_id from {$g5['member_table']} where mb_grade in (".$mb_grade.") and mb_leave_date = '' and mb_intercept_date = '' ";
	$result = sql_query($sql);
	for ($i=0; $row=sql_fetch_array($result); $i++) {
		insert_point($row['mb_id'], $po_point, $po_content, '@passive', $row['mb_id'], $member['mb_id'].'-'.uniqid(''), $expire);
	}


} else { //회원아이디 일경우
	
	$mb_id = isset($_POST['mb_id']) ? strip_tags(clean_xss_attributes($_POST['mb_id'])) : '';
	$po_point = isset($_POST['po_point']) ? strip_tags(clean_xss_attributes($_POST['po_point'])) : 0;
	$po_content = isset($_POST['po_content']) ? strip_tags(clean_xss_attributes($_POST['po_content'])) : '';
	$expire = isset($_POST['po_expire_term']) ? preg_replace('/[^0-9]/', '', $_POST['po_expire_term']) : '';

	$ids = explode(",", $mb_id);
	
	for($ii=0; $ii < count($ids); $ii++){
		
		$mb = get_member($ids[$ii]);
		
		$sql = " select mb_id from {$g5['member_table']} where mb_id = '".$ids[$ii]."' and mb_leave_date = '' and mb_intercept_date = '' ";
		$row = sql_fetch($sql);
		
		if(!$row['mb_id']){
			alert('입력하신 회원아이디는 존재하지 않거나 탈퇴 또는 차단된 회원아이디입니다.');
		}
		
		if (!$mb['mb_id']){
			alert('존재하는 회원아이디가 아닙니다.', './point_list.php?'.$qstr);
		}

		if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point'])){
			alert('포인트를 깎는 경우 현재 포인트보다 작으면 안됩니다.', './point_list.php?'.$qstr);
		}
		
		insert_point($ids[$ii], $po_point, $po_content, '@passive', $ids[$ii], $member['mb_id'].'-'.uniqid(''), $expire);
		
	}
}

goto_url('./point_list.php?'.$qstr);

/*
$mb = get_member($mb_id);

if (!$mb['mb_id'])
    alert('존재하는 회원아이디가 아닙니다.', './point_list.php?'.$qstr);

if (($po_point < 0) && ($po_point * (-1) > $mb['mb_point']))
    alert('포인트를 깎는 경우 현재 포인트보다 작으면 안됩니다.', './point_list.php?'.$qstr);

insert_point($mb_id, $po_point, $po_content, '@passive', $mb_id, $member['mb_id'].'-'.uniqid(''), $expire);

goto_url('./point_list.php?'.$qstr);*/