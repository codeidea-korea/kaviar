<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!isset($write['wr_store_id'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table} 
					 ADD wr_store_id VARCHAR(100) NOT NULL DEFAULT ''
					 ", false);
}