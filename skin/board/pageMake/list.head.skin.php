<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$is_bo_padding = false;

//리스트 정렬을 최근글이 밑으로 가도록 고정
if($board['bo_sort_field'] != 'wr_last asc') sql_query(" update {$g5['board_table']} set bo_sort_field = 'wr_last asc' where bo_table = '{$bo_table}' ");
//pageMake스킨은 목록수를 고정...
if($board['bo_page_rows'] != 50) sql_query(" update {$g5['board_table']} set bo_page_rows = 50 where bo_table = '{$bo_table}' ");
if($board['bo_mobile_page_rows'] != 50) sql_query(" update {$g5['board_table']} set bo_mobile_page_rows = 50 where bo_table = '{$bo_table}' ");
//분류에서 전체보기 사용안함
if(!$board['bo_cate_all_hidden']) sql_query(" update {$g5['board_table']} set bo_cate_all_hidden = 1 where bo_table = '{$bo_table}' ");

if($header['header_height']) {
	$pageMakeStyle .= '.list_bundle{top:'.$header['header_height'].'px}';
}


//상세옵션
$bl_font = $bo_option[0] ? $bo_option[0] : 'noto600'; //블록 제목 폰트