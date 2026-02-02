<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!$wr_comment) {
	$sql = " update $write_table set
				 wr_hp = '$wr_hp'
				 where wr_id = '$wr_id' " ;
	sql_query($sql); 
}


$redirect_url = run_replace('write_update_move_url', short_url_clean(G5_HTTP_BBS_URL.'/board.php?bo_table='.$bo_table), $board, $wr_id, $w, $qstr, $file_upload_msg);
alert('문의가 접수되었습니다.', $redirect_url);