<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

//$latest_table = implode(",", $_POST['latest_table']);

if($_POST['latest_table'] == 'SQUARE') $latest_skin = 'SQUARE';

$bl_text_align = implode("|", $_POST['bl_text_align']);

if(!$latest_table) $latest_skin = '';

if(!$wr_comment) {
	$sql = " update $write_table set				 
				 bl_name = '$bl_name',
				 bl_height = '$bl_height',
				 bl_height_mobile = '$bl_height_mobile',
				 bl_parallax = '$bl_parallax',
				 bl_background = '$bl_background',
				 latest_table = '$latest_table',
				 latest_order_option = '$latest_order_option',
				 latest_count = '$latest_count',
				 latest_mobile_count = '$latest_mobile_count',
				 latest_order_cate = '$latest_order_cate',
				 latest_sel_li_id = '$latest_sel_li_id',
				 latest_skin = '$latest_skin',
				 latest_type = '$latest_type',
				 latest_list_style = '$latest_list_style',
				 latest_gall_cols = '$latest_gall_cols',
				 latest_gall_mobile_cols = '$latest_gall_mobile_cols',
				 latest_gall_itemspace = '$latest_gall_itemspace',
				 gall_cols_default = '$gall_cols_default',
				 bl_title = '$bl_title',
				 bl_title_color = '$bl_title_color',
				 wr_content_color = '$wr_content_color',
				 bl_text_align  = '$bl_text_align',
				 bl_width = '$bl_width',
				 latest_option = '$latest_option',
				 latest_mobile_option = '$latest_mobile_option'
				 where wr_id = '$wr_id' " ;
	sql_query($sql); 
}

