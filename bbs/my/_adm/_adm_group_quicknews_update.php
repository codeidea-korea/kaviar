<?php
include_once('../../../common.php');

$gr_id = $_POST['gr_id'];

$sql = " update {$g5['group_table']} set 
			 gr_qn_table	= '{$_POST['gr_qn_table']}',
			 gr_qn_list		= '{$_POST['gr_qn_list']}'
			 where gr_id = '{$_POST['gr_id']}' ";
sql_query($sql);



delete_cache_latest($bo_table);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";