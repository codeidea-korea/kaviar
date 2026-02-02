<?php
$sub_menu = "130100";
include_once('./_common.php');

check_demo();

auth_check($auth[$sub_menu], 'w');

check_admin_token();

$sql = " update {$g5['quick_news_table']} set
			 qn_use						= '{$_POST['qn_use']}',
			 qn_use_admin			= '{$_POST['qn_use_admin']}',
			 qn_start_option			= '{$_POST['qn_start_option']}',			 
			 qn_title						= '{$_POST['qn_title']}',
			 qn_background			= '{$_POST['qn_background']}',
			 qn_width					= '{$_POST['qn_width']}',
			 qn_table1					= '{$_POST['qn_table1']}',
			 qn_list1					= '{$_POST['qn_list1']}',
			 qn_table2					= '{$_POST['qn_table2']}',
			 qn_list2					= '{$_POST['qn_list2']}',
			 qn_option					= '{$qn_option}' ";

sql_query($sql);

goto_url('./quick_news.php');
?>