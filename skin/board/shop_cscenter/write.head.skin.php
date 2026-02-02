<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$footer_skip = true;





$wr_subject_label = '문의 제목';
$wr_content_label = '문의 내용';




//필드추가
if(!isset($write['wr_agree'])){
    sql_query(" ALTER TABLE $g5[write_prefix]$bo_table
					 ADD wr_agree TINYINT NOT NULL DEFAULT '0',
					 ADD wr_hp VARCHAR(255) NOT NULL DEFAULT ''
					 ", false);
}