<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$bo_table = $_POST['bo_table'];

$sql = " update {$g5['board_table']}
                set bo_view_width	= '{$_POST['bo_view_width']}',
					 bo_view_thumb	= '{$_POST['bo_view_thumb']}',
					 bo_view_writer	= '{$_POST['bo_view_writer']}',
					 bo_view_date	= '{$_POST['bo_view_date']}',
					 bo_use_good	= '{$_POST['bo_use_good']}',
					 bo_use_good_guest	= '{$_POST['bo_use_good_guest']}',
					 bo_comment_level	= '{$_POST['bo_comment_level']}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";