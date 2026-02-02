<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(match_arr('faq-masonry', $board['bo_option'])) {
	//스킨 설정
	$autoSize = 'masonry'; //auto, 'masonry'
}