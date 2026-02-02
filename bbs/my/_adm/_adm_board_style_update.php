<?php
include_once('./_common.php');

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


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";