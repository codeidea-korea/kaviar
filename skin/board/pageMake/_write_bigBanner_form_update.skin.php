<?php
if (!defined('_GNUBOARD_')) exit;

$sql = " update {$write_table}
                set bl_name = '{$bl_name}',
					 bl_height = '{$bl_height}',
					 bl_height_mobile = '{$bl_height_mobile}',
					 bl_parallax = '{$bl_parallax}',
					 bl_background = '{$bl_background}',
					 latest_sel_li_id = '{$latest_sel_li_id}',
					 latest_count = '{$latest_count}',
					 latest_mobile_count = '{$latest_mobile_count}',
					 latest_option = '{$latest_option}',
					 latest_mobile_option = '{$latest_mobile_option}'
              where wr_id = '{$wr_id}' ";
    sql_query($sql);