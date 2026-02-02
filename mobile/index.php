<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//define('_INDEX_', true);

if($config['cf_main_url']) { //메인페이지 URL
	goto_url($config['cf_main_url']);
} else {
	//메인페이지용 게시판 확인
	$bo_table = $config['cf_main_table'];
	$write_table = $g5['write_prefix'] . $bo_table;
	$board = sql_fetch(" select * from {$g5['board_table']} where bo_table = '$bo_table' ");
	if($board['bo_table']) {
		$board_skin_path = $board_pcskin_path = get_skin_path('board', $board['bo_skin']);
		$board_skin_url = $board_skin_url = get_skin_url('board', $board['bo_skin']);
		require_once(G5_BBS_PATH.'/board.php');
		return;
	} else {	
		include_once(G5_THEME_PATH.'/head.php');
		if($is_admin == 'super') echo '<div class="flexCenter" style="background:rgba(0,0,0,0.85);color:#fff;"><a href="'.G5_ADMIN_URL.'/my/mainpage.make.php" target="_blank" class="btn blue">인덱스용 게시판 설정하기</a></div>';
		include_once(G5_PATH.'/tail.php');
	}
}