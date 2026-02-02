<?php
$sub_menu = "100290";
include_once('./_common.php');

check_demo();

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$cf_open_menu = implode(",", $_POST['cf_open_menu']);
$callback_url = $_POST['callback_url'];

$sql = " update {$g5['config_table']} set 
			cf_open_menu = '{$cf_open_menu}' ";
sql_query($sql);


if(strpos($callback_url, '/_adm') !== false) {
	echo "<script>
	opener.document.location.reload();
	location.href='".$callback_url."';
	</script>";
} else {
	goto_url($callback_url, false);
}