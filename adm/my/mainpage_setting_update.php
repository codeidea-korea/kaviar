<?php
$sub_menu = "110500";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$sql = " update {$g5['config_table']} set 
			cf_main_table = '{$_POST['cf_main_table']}',			
			cf_main_url = '{$_POST['cf_main_url']}' ";
sql_query($sql);

goto_url('./mainpage_setting.php', false);