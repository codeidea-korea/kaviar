<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];

$bo_search_sfl = implode(",", $_POST['bo_search_sfl']);

$sql = " update {$g5['board_table']} set 
				 bo_search_skin			= '{$_POST['bo_search_skin']}',
				 bo_search_color		= '{$_POST['bo_search_color']}',
				 bo_search_sfl			= '{$bo_search_sfl}'					 
              where bo_table = '{$bo_table}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";