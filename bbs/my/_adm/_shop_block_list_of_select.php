<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$sel_li_id = explode(",",$_GET['sel_li_id']);
$check_type = $_GET['check_type']=='radio' ? 'radio' : 'checkbox';
$input_id = $_GET['input_id'] ? $_GET['input_id'] : '';

if($bl_type == 'banner') {
	include_once($_adm_path.'/_shop_block_banner_of_select.php');
} else if($bl_type == 'item') {
	include_once($_adm_path.'/_shop_block_item_of_select.php');
} else if($bl_type == 'itemuse') {
	include_once($_adm_path.'/_shop_block_itemuse_of_select.php');
}