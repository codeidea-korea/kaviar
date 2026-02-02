<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


if($is_admin == 'super') {
	echo '<div id="adminSet" class="media-pc-only">';
	echo '<div class="adminMenu_opener"></div>';
	echo '<div class="adminMenu">';
	echo '<ul>';
	echo '<li><a href="'.correct_goto_url(G5_ADMIN_URL.'/shop_admin').'" target="_blank" class="icon_adm yellow bold" alt="관리자페이지">관리자 페이지</a></li>';
	if($bo_table) {
		echo '<li><a href="'.G5_ADMIN_URL.'/board_form.php?w=u&bo_table='.$bo_table.'" target="_blank" class="icon_adm yellow bold" alt="게시판 관리자">';
		echo '<div class="flex">';
		echo '게시판 관리로 이동';
		if($board['bo_skin']) echo '<small>'.$board['bo_skin'].'</small>';
		echo '</div>';
		echo '</a></li>';
	}
	if(defined('_ITEM_')) echo '<li><a href="'.G5_ADMIN_URL.'/shop_admin/itemform.php?w=u&it_id='.$it_id.'&ca_id='.$it['ca_id'].'" target="_blank" class="icon_adm yellow bold" alt="관리자페이지">상품 관리</a></li>';
	echo '<li><a href="'.G5_BBS_URL.'/my/_adm/?tab=1&pn=_shop_config" class="popWin icon_setting blue" data-width="1250" data-height="764" data-top="60" data-left="0">쇼핑몰 사이트 관리</a></li>';
	echo '<li><a href="'.G5_BBS_URL.'/my/_adm/?&pn=_shop_banner&title=쇼핑몰 배너관리" class="popWin icon_setting blue" data-width="1430" data-height="700" data-top="60" data-left="0">쇼핑몰 배너관리</a></li>';
	echo '<li><a href="'.G5_BBS_URL.'/login.php?pn=login_intro&mod=admin" class="icon_page">로그인 페이지 블럭편집</a></li>';
	echo '</ul>';
	echo '</div>';
	echo '</div>';
}