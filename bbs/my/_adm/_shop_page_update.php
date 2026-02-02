<?php
include_once('./_common.php');

$pn_id = $_POST['pn_id'];

$sql = " update {$g5['g5_shop_page_table']}
			 set pn_subject			= '{$_POST['pn_subject']}'
			 where pn_id = '$pn_id' ";
sql_query($sql);


echo "<script>
	location.href='".$callback_url."';
	</script>";