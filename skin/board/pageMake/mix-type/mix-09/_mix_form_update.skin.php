<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$sql = " update {$write_table}
			set latest_list_style = '$latest_list_style',
				 latest_gall_cols = '$latest_gall_cols'
			 where wr_id = '{$wr_id}' ";
sql_query($sql);