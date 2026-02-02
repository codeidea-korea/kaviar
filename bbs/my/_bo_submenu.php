<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$gr_subject = $gr_subject ? $gr_subject : $group['gr_subject'];

echo '<div id="_boSubmenu" data-skin="'.$board['bo_skin'].'">';
	if(!G5_IS_MOBILE) echo '<div class="gr_subject">'.$gr_subject.'</div>';
	echo get_subMenu($gr_id);
echo '</div>';