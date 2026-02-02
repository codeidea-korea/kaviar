<?php
include_once('./_common.php');

$qn_option = implode(",",$_POST['qn_option']);

$sql = " update {$g5['quick_news_table']} set
			 qn_use						= '{$qn_use}',
			 qn_use_admin			= '{$qn_use_admin}',
			 qn_start_option			= '{$qn_start_option}',			 
			 qn_title						= '{$qn_title}',
			 qn_background			= '{$qn_background}',
			 qn_width					= '{$qn_width}',
			 qn_table1					= '{$qn_table1}',
			 qn_list1					= '{$qn_list1}',
			 qn_table2					= '{$qn_table2}',
			 qn_list2					= '{$qn_list2}',
			 qn_option					= '{$qn_option}' ";
sql_query($sql);


echo "<script>
opener.document.location.href='".G5_URL."';
location.href='".$callback_url."';
</script>";