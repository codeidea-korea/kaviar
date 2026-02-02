<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

if(!$wr_comment) {
	$sql = " update $write_table set				 
				 editor_img_slide = '$editor_img_slide'
				 where wr_id = '$wr_id' " ;
	sql_query($sql); 
}

