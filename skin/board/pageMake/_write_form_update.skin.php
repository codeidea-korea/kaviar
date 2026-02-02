<?php
if (!defined('_GNUBOARD_')) exit;


$bl_padding_top = implode("|", $_POST['bl_padding_top']);
$bl_padding_bottom = implode("|", $_POST['bl_padding_bottom']);

$bl_text_align = implode("|", $_POST['bl_text_align']);

$latest_option = implode(",",$_POST['latest_option']);

if($_POST['option_con_length'] || $_POST['option_con_length'] === '0') $latest_option .= ',내용글자수'.$_POST['option_con_length'];
if($_POST['option_mobile_con_length'] || $_POST['option_mobile_con_length'] === '0') $latest_option .= ',모바일글자수'.$_POST['option_mobile_con_length'];

$sql = " update {$write_table}
                set bl_name = '{$bl_name}',
					 wr_subject = '{$wr_subject}',
					 bl_width = '{$bl_width}',
					 bl_padding_top = '{$bl_padding_top}',
					 bl_padding_bottom = '{$bl_padding_bottom}',
					 bl_height = '{$bl_height}',
					 bl_height_mobile = '{$bl_height_mobile}',
					 bl_parallax = '{$bl_parallax}',
					 bl_background = '{$bl_background}',
					 bl_font_color = '{$bl_font_color}',					 
					 wr_video = '{$wr_video}',
					 wr_video_src = '{$wr_video_src}',
					 wr_video_play = '{$wr_video_play}',
					 wr_video_width = '{$wr_video_width}',
					 latest_type = '{$latest_type}',
					 latest_list_style = '{$latest_list_style}',					 
					 latest_gall_cols = '{$latest_gall_cols}', 
                     latest_gall_mobile_cols = '{$latest_gall_mobile_cols}',
					 latest_gall_itemspace = '{$latest_gall_itemspace}',
					 gall_cols_default = '{$gall_cols_default}',
					 latest_sel_li_id = '{$latest_sel_li_id}',
					 latest_count = '{$latest_count}',
					 latest_mobile_count = '{$latest_mobile_count}',
					 bl_title = '{$bl_title}',
					 bl_title_color = '{$bl_title_color}',
					 bl_title_size = '{$bl_title_size}',
					 wr_content_color = '{$wr_content_color}',
					 bl_text_align  = '{$bl_text_align}',
					 latest_option = '{$latest_option}',
					 latest_mobile_option = '{$latest_mobile_option}'
              where wr_id = '{$wr_id}' ";
    sql_query($sql);
