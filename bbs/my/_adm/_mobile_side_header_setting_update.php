<?php
include_once('./_common.php');

$cfm_top_bg = implode("|", $_POST['cfm_top_bg']);
$cfm_menu_top_bg = implode("|", $_POST['cfm_menu_top_bg']);
$cfm_menu_color = implode("|", $_POST['cfm_menu_color']);

$sql = " update {$g5['config_mobile_table']} set
				 cfm_menu_bg = '{$_POST['cfm_menu_bg']}',
				 cfm_menu_top_bg		= '{$cfm_menu_top_bg}',
				 cfm_menu_color = '{$cfm_menu_color}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";