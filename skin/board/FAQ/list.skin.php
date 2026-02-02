<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/'.$css).'">', 2);


if(match_arr('faq-masonry', $board['bo_option'])) {
	require($board_pcskin_path.'/_faq_masonry.php');
    return;
} else {
	require($board_pcskin_path.'/_faq_list.php');
    return;
}