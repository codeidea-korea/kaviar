<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(G5_IS_MOBILE) $footer_skip = true;


if(!isset($write['editor_img_slide'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table} 
					 ADD editor_img_slide INT(11) NOT NULL DEFAULT '0'
					 ", false);
}