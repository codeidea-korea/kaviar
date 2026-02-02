<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가






if($del_bl_img1_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_1");
if($del_bl_img2_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_2");
if($del_bl_img3_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_3");
if($del_bl_img4_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_4");
if($del_bl_img5_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_5");
if($del_bl_img6_del)  @unlink(G5_DATA_PATH."/shop_block/bl{$bl_id}_6");


for($i=1; $i<=6; $i++) {
	if($_FILES['bl_img'.$i]['name']) {
		$dest_path[$i] = G5_DATA_PATH."/shop_block/bl".$bl_id."_".$i;
		@move_uploaded_file($_FILES['bl_img'.$i]['tmp_name'], $dest_path[$i]);
		@chmod($dest_path[$i], G5_FILE_PERMISSION);
	}
}