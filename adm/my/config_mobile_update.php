<?php
$sub_menu = "110700";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$cfm_top_bg = implode("|", $_POST['cfm_top_bg']);
$cfm_menu_top_bg = implode("|", $_POST['cfm_menu_top_bg']);
$cfm_menu_color = implode("|", $_POST['cfm_menu_color']);

$sql = " update {$g5['config_mobile_table']} set
				 cfm_top_layout			= '{$_POST['cfm_top_layout']}',
				 cfm_top_bg				= '{$cfm_top_bg}',
				 cfm_menu_top_bg		= '{$cfm_menu_top_bg}',
				 cfm_menu_bg			= '{$_POST['cfm_menu_bg']}',
				 cfm_menu_color		= '{$cfm_menu_color}' ";
sql_query($sql);


goto_url('./config_mobile.php', false);
?>