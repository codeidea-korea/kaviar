<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/my/get_my.lib.php');
echo '<script src="'.get_url($board_skin_url.'/mix-type/mix_form.js').'"></script>';

$bo_table = $_POST['bo_table'];
$wr_id = $_POST['wr_id'];

for($i=0; $i<11; $i++) {
	$thumb[$i] = get_list_thumbnail($bo_table, $wr_id, 500, 0, false, true, 'center', false, '80/0.5/3', $i, false);
	$upImg[$i] = $thumb[$i]['src'] ? '<img src="'.$thumb[$i]['src'].'" alt="업로드 이미지">' : '';
	$wr[$i] = explode("|",$write['wr_'.$i]);
	$wr_sub[$i] = explode("|",$write['wr_sub'.$i]);
}