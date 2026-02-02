<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//필드추가
if(!isset($write['bl_name'])) { //컬럼 추가
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table}				 
				 ADD bl_name VARCHAR(255) NOT NULL DEFAULT '',
				 ADD bl_width INT(11) NOT NULL DEFAULT '0',
				 ADD bl_height INT(11) NOT NULL DEFAULT '0',
				 ADD bl_height_mobile INT(11) NOT NULL DEFAULT '0',
				 ADD bl_parallax TINYINT NOT NULL DEFAULT '0',
				 ADD bl_background VARCHAR(30) NOT NULL DEFAULT '',
				 ADD bl_font_color VARCHAR(30) NOT NULL DEFAULT '',
				 ADD bl_title text NOT NULL DEFAULT '',
				 ADD bl_title_color VARCHAR(30) NOT NULL DEFAULT '',
				 ADD bl_title_size INT(11) NOT NULL DEFAULT '0' after `bl_title_color`,
				 ADD wr_content_color VARCHAR(30) NOT NULL DEFAULT '',
				 ADD bl_text_align VARCHAR(30) NOT NULL DEFAULT '',
				 ADD latest_table VARCHAR(50) NOT NULL DEFAULT '',
				 ADD latest_order_option VARCHAR(30) NOT NULL DEFAULT '',
				 ADD latest_count INT(11) NOT NULL DEFAULT '0',
				 ADD latest_mobile_count INT(11) NOT NULL DEFAULT '0',
				 ADD latest_order_cate VARCHAR(255) NOT NULL DEFAULT '',
				 ADD latest_sel_li_id VARCHAR(255) NOT NULL DEFAULT '',
				 ADD latest_skin VARCHAR(30) NOT NULL DEFAULT '',
				 ADD latest_type VARCHAR(50) NOT NULL DEFAULT '',
				 ADD latest_list_style VARCHAR(50) NOT NULL DEFAULT '',
				 ADD latest_gall_cols FLOAT NOT NULL DEFAULT '0',
				 ADD latest_gall_mobile_cols FLOAT NOT NULL DEFAULT '0',
				 ADD latest_gall_itemspace INT(11) NOT NULL DEFAULT '0',
				 ADD latest_option VARCHAR(255) NOT NULL DEFAULT '',
				 ADD latest_mobile_option VARCHAR(255) NOT NULL DEFAULT ''	,
				 ADD gall_cols_default INT(11) NOT NULL DEFAULT '0'				 
				 ", false);
}

if(!isset($write['bl_padding_top'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table} 
					 ADD bl_padding_top VARCHAR(100) NOT NULL DEFAULT '' after `bl_width`,
					 ADD bl_padding_bottom VARCHAR(100) NOT NULL DEFAULT '' after `bl_padding_top`
					 ", false);
}

if(!isset($write['mix_type'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table} ADD mix_type VARCHAR(50) NOT NULL DEFAULT '' ", false);
}

if(!isset($write['wr_video_width'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table} ADD wr_video_width INT(11) NOT NULL DEFAULT '0' after `wr_video_play` ", false);
}

if(!isset($write['wr_sub1'])) {
	sql_query(" ALTER TABLE $g5[write_prefix]{$bo_table}				 
				 ADD wr_sub1 VARCHAR(255) NOT NULL DEFAULT '' after `wr_10`,
				 ADD wr_sub2 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub1`,
				 ADD wr_sub3 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub2`,
				 ADD wr_sub4 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub3`,
				 ADD wr_sub5 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub4`,
				 ADD wr_sub6 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub5`,
				 ADD wr_sub7 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub6`,
				 ADD wr_sub8 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub7`,
				 ADD wr_sub9 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub8`,
				 ADD wr_sub10 VARCHAR(255) NOT NULL DEFAULT '' after `wr_sub9`
				 ", false);
}


$bo_background = explode("|",$board['bo_background']);
if($bo_background[0]) {
	$boStyle .= '.labelInput.labelColor-lightGray .label{background:'.$bo_background[0].' !important;}';
	$boStyle .= '.labelInput.labelColor-lightGray .label, .bootstrap-select .dropdown-toggle.selectColor-lightGray{background:'.$bo_background[0].' !important;}';
}

//pageMake스킨은 업로드이미지 갯수를 10개로 미리 업데이트 
if($board['bo_upload_count'] != 10) sql_query(" update {$g5['board_table']} set bo_upload_count = 10 where bo_table = '{$bo_table}' ");