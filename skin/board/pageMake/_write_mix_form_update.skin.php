<?php
if (!defined('_GNUBOARD_')) exit;

$bl_padding_top = implode("|", $_POST['bl_padding_top']);
$bl_padding_bottom = implode("|", $_POST['bl_padding_bottom']);

$mix_type = $_POST['mix_type'];
$bl_text_align = implode("|", $_POST['bl_text_align']);

for($i=1; $i<11; $i++) {
	$wr[$i] = implode("|",$_POST['wr'.$i]);
	$wr_sub[$i] = implode("|",$_POST['wr_sub'.$i]);
}

for($i=0; $i<count($_FILES[bf_file][name]); $i++) { 
	if (!preg_match("/\.($config[cf_image_extension])$/i", $_FILES[bf_file][name][$i]) && $_FILES[bf_file][name][$i]) { 
		alert("이미지 파일만 업로드가 가능합니다!"); 
	}  
}

$sql = " update {$write_table}
                set mix_type = '{$mix_type}',
					 wr_comment = 0,
                     wr_content = '$wr_content',
					 wr_content_mobile = '$wr_content_mobile',
					 bl_name = '{$bl_name}',
					 bl_width = '{$bl_width}',
					 bl_padding_top = '{$bl_padding_top}',
					 bl_padding_bottom = '{$bl_padding_bottom}',
					 bl_background = '{$bl_background}',
					 bl_font_color = '{$bl_font_color}',
					 bl_title = '$bl_title',
					 bl_title_size = '{$bl_title_size}',
					 bl_title_color = '{$bl_title_color}',
					 
					 wr_content_color = '{$wr_content_color}',
					 bl_text_align = '$bl_text_align',
					 wr_1 = '{$wr[1]}',
					 wr_2 = '{$wr[2]}',
					 wr_3 = '{$wr[3]}',
					 wr_4 = '{$wr[4]}',
					 wr_5 = '{$wr[5]}',
					 wr_6 = '{$wr[6]}',
					 wr_7 = '{$wr[7]}',
					 wr_8 = '{$wr[8]}',
					 wr_9 = '{$wr[9]}',
					 wr_10 = '{$wr[10]}',
					 wr_sub1 = '{$wr_sub[1]}',
					 wr_sub2 = '{$wr_sub[2]}',
					 wr_sub3 = '{$wr_sub[3]}',
					 wr_sub4 = '{$wr_sub[4]}',
					 wr_sub5 = '{$wr_sub[5]}',
					 wr_sub6 = '{$wr_sub[6]}',
					 wr_sub7 = '{$wr_sub[7]}',
					 wr_sub8 = '{$wr_sub[8]}',
					 wr_sub9 = '{$wr_sub[9]}',
					 wr_sub10 = '{$wr_sub[10]}'
				 where wr_id = '{$wr_id}' ";
    sql_query($sql);

@include_once($board_pcskin_path.'/mix-type/'.$mix_type.'/_mix_form_update.skin.php');