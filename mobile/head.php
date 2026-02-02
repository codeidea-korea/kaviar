<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH."/mobile/head.php")) {
	require_once(G5_THEME_PATH.'/mobile/head.php');
	return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/my/get_my.lib.php'); //인태
include_once(G5_MOBILE_PATH.'/head.lib.php'); //인태
include_once(G5_LIB_PATH.'/my/_my.lib.php'); //인태
include_once(G5_BBS_PATH.'/my/adminSet.php'); //인태 - 관리자 메뉴 호출
include_once(G5_LIB_PATH.'/my/latest_multi.lib.php'); //인태 
include_once(G5_LIB_PATH.'/my/quick.latest.lib.php'); //인태
//include_once(G5_LIB_PATH.'/outlogin.lib.php');
//include_once(G5_LIB_PATH.'/poll.lib.php');
//include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
//include_once(G5_LIB_PATH.'/popular.lib.php');

//include_once(G5_BBS_PATH.'/my/pop-hd-search-set.php'); //사이트 검색(일반 팝업)

if($is_quickNews) echo get_quicknews(); //퀵뉴스 호출
if(defined('_INDEX_')) include G5_BBS_PATH.'/newwin.inc.php'; // 팝업레이어


add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_MOBILE_URL.'/js/slideMenu/slideMenu.css').'">', 0);
add_javascript('<script src="'.get_url(G5_MOBILE_URL.'/js/slideMenu/slideMenu.js').'"></script>',0);
?>

<div id="page-wrapper" class="mobile-max-width <?=$header_layout?>">
	<?php
	if($headerStyle) echo '<style name="header">'.$headerStyle.'</style>';

	echo '<header id="header" class="'.($board['bo_skin']=='pageMake'?'scrollfixed ':'').'mobile-max-width '.$header_layout.'">';
	if($instant_header) {
		echo $instant_header;
	} else {
		echo '<a href="javascript:;" class="menuOpener"><span class="line-1"></span><span class="line-2"></span><span class="line-3"></span></a>';
		echo '<div id="logo">'.$top_logo.'</div>';

		if(!$bo_viewpage && !$bo_writepage) {
			if($board['bo_search_skin'] || $is_quickNews || defined('_INDEX_')) {
				echo '<div id="hd-r">';
				if(defined('_INDEX_')) echo '<span id="boSearch-opener" data-href="#pop-hd-search-set" class="pop-inline"></span>';
				if(!defined('_INDEX_') && $board['bo_search_skin']) echo '<span id="boSearch-opener" data-href="#pop-bo-search-set" class="pop-inline"></span>';
				if($is_quickNews) echo '<span class="quickNews_opener">Quick News</span>';
				echo '</div>';
			}
		}		
	}
	if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?pn=_mobile_header_setting&title=모바일 헤더관리" class="btnSetting popWin" data-width="900" data-height="500" data-top="60" data-left="0" data-area="#header">모바일 헤더관리</a>';
	echo '</header>';
	
	if(!$bo_viewpage && !$bo_writepage) {
		echo '<div id="navContainer" class="mobile-max-width">';		
		echo '<div class="navContainer-inner">';	
		if($is_admin == 'super') echo '<a href="'.$_adm_url.'/?pn=_mobile_side_header_setting&title=모바일 헤더관리(사이드)" class="btnSetting popWin" data-width="900" data-height="300" data-top="60" data-left="0" data-area=".navContainer-inner">모바일 헤더관리(사이드)</a>';
		
		if($is_member) {
			echo '<div id="nav-head" class="memberContainer">';		
			//echo '<a href="javascript:;" class="menuCloser">메뉴닫기</a>';	
			echo '<div class="user_thumb">'.get_mb_img($member['mb_id'], 50, 'no_mb_img').'</div>';		
			echo '<div class="user_profile">';
			echo '<span class="name">'.get_text($member['mb_nick']).'님</span>';
			echo '<span class="email">'.get_text($member['mb_email']).'</span>';
			echo '</div>';							
			echo '</div>';
			echo '<div id="nav-head-sub">';
			echo '<ul>';
			echo '<li><a href="'.G5_BBS_URL.'/member_confirm.php?url=register_form.php" class="mypage">회원정보</a></li>';
			echo '<li><a href="'.G5_BBS_URL.'/logout.php?url='.$urlencode.'" class="logout">로그아웃</a></li>';
			echo '</ul>';
			echo '</div>';
		} else {
			if($config['cf_use_login']=='1' || $config['cf_use_login']=='3' || $config['cf_use_join']){
				echo '<div class="nomemberContainer">';
				if($config['cf_use_login']=='1' || $config['cf_use_login']=='3') echo '<a href="'.G5_BBS_URL.'/login.php" class="btn_login" title="로그인">로그인</a>';
				if($config['cf_use_join']) echo '<a href="'.$join_url.'" class="btn_join">회원 가입</a>';
				echo '</div>';
			}
		}

		echo '	<div id="nav-body">';
		if($is_admin == 'super' && !$group['gr_use_layout']) echo '<a href="'.$_adm_url.'/?pn=_adm_mainmenu_setting&title=메인메뉴 관리" class="btnSetting popWin" data-width="1300" data-height="600" data-top="60" data-left="0" data-area=".nav_ul">메인메뉴 관리</a>';
		echo			$galobalNavigation;
		echo '	</div>';
		echo '</div>';
		echo '</div>';
	}
	?>


	<div id="wrapper">

		<div id="container">
			<?php //if (!defined("_INDEX_") && !$bo_table) echo '<div id="container_title"><span title="'.get_text($g5['title']).'">'.get_head_title($g5['title']).'</span></div>'; ?>