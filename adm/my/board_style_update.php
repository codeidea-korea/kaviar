<?php
$sub_menu = "300900";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

check_admin_token();

$title_style = implode("|", $_POST['title_style']);
$btn_write_style = implode("|", $_POST['btn_write_style']);
$btn_pager_style = implode("|", $_POST['btn_pager_style']);

$sql = " update {$g5['board_style_table']} set 
				use_bo_style			= '{$_POST['use_bo_style']}',
				title_style				= '{$title_style}',
				btn_write_style		= '{$btn_write_style}',
				btn_pager_style		= '{$btn_pager_style}'
				";
sql_query($sql);


goto_url('./board_style.php', false);