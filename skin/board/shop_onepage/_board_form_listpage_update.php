<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$bo_table = $_POST['bo_table'];

$sql = " update {$g5['board_table']}
                set bo_subject_hide	= '{$_POST['bo_subject_hide']}',
					 bo_subject	= '{$_POST['bo_subject']}'
              where bo_table = '{$bo_table}' ";
sql_query($sql);

echo "<script>
opener.document.location.reload();
location.href='".$callback_url."';
</script>";