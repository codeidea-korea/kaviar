<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sql = " update {$g5['board_table']}
                set bo_use_dhtml_editor = '{$_POST['bo_use_dhtml_editor']}',
					 bo_editor_height	= '{$_POST['bo_editor_height']}',
					 bo_use_html_tag	= '{$_POST['bo_use_html_tag']}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);


delete_cache_latest($bo_table);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";