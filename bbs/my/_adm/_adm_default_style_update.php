<?php
include_once('./_common.php');

$cf_default_style = implode("|", $_POST['cf_default_style']);

$cf_default_color = implode("|", $_POST['cf_default_color']);

$sql = " update {$g5['config_table']} set
			cf_default_style = '{$cf_default_style}',
			cf_default_color = '{$cf_default_color}'
			";
sql_query($sql);


echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";