<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(!$wr_comment) {
	$sql = " update $write_table set				 
				 wr_store_id = '$wr_store_id'
				 where wr_id = '$wr_id' " ;
	sql_query($sql); 
}

