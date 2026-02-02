<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_skin_url.'/'.$latestCSS).'">', 3);


if($latest_type) {
	require($latest_skin_path.'/'.$latest_type.'.php');
    return;
} else {
	require($latest_skin_path.'/_faq_list.php');
    return;
}