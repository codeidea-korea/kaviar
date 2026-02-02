<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

echo '<div class="box-tabs-container">';
	echo '<div class="tabs-group">';
		echo '<a href="'.$_adm_url.'/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=view" class="tab '.(!$ps||$ps=='view'?'active':'').'">뷰페이지</a>';
		echo '<a href="'.$_adm_url.'/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=write" class="tab '.($ps=='write'?'active':'').'">등록페이지</a>';
	echo '</div>';
echo '</div>';