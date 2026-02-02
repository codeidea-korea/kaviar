<?php
include_once('./_common.php');


$sql = " update {$g5['config_table']} set 
			cf_main_table = '{$_POST['cf_main_table']}',			
			cf_main_url = '{$_POST['cf_main_url']}' ";
sql_query($sql);


echo "<script>
opener.document.location.href='".G5_URL."';
location.href='".$callback_url."';
</script>";