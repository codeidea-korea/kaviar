<?php
if (!defined('_GNUBOARD_')) exit;

$bl_text_align = implode("|", $_POST['bl_text_align']);

$latest_option = implode(",",$_POST['latest_option']);

$sql = " update {$write_table}
                set bl_name = '{$bl_name}',
					 bl_height = '{$bl_height}',
					 bl_height_mobile = '{$bl_height_mobile}',
					 bl_parallax = '{$bl_parallax}',
					 bl_background = '{$bl_background}',
					 wr_video = '{$wr_video}',
					 wr_video_src = '{$wr_video_src}',
					 wr_video_play = '{$wr_video_play}',
					 wr_video_width = '{$wr_video_width}',
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