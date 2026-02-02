<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/'.$css).'">', 3);


// 글이 있다면 뷰페이지로 없다면 쓰기버튼 출력
$subrow = sql_fetch(" select * from $g5[write_prefix]$bo_table ");
if($subrow['wr_id']) {
	goto_url(get_pretty_url($bo_table,'','wr_id='.$subrow[wr_id]));
} else {

	echo '<div class="bo_list" style="'.$bo_width.'">';
		echo '<div class="empty_list" data-text="페이지가 없습니다."></div>';
		if($write_href) echo '<div class="tcenter p15"><a href="'.$write_href.'" class="_btn/lg w-150">페이지 만들기</a></div>';
	echo '</div>';

}