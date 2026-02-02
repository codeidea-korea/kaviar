<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');


if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/_adminSet.php') && $is_admin == 'super') {    
	require_once(G5_THEME_PATH.'/_adminSet.php');
	return;
}


if($is_admin == 'super') {
	echo '<div id="adminSet" class="media-pc-only">';
	echo '<div class="adminMenu_opener"></div>';
	echo '<div class="adminMenu">';
	echo '<ul>';
	echo '<li><a href="'.correct_goto_url(G5_ADMIN_URL).'" target="_blank" class="icon_adm yellow bold" alt="관리자페이지">관리자 페이지</a></li>';			
	if($bo_table) {
		echo '<li><a href="'.G5_ADMIN_URL.'/board_form.php?w=u&bo_table='.$bo_table.'" target="_blank" class="icon_adm yellow bold" alt="게시판 관리자">';
		echo '<div class="flex">';
		echo '게시판 관리로 이동';
		if($board['bo_skin']) echo '<small>'.$board['bo_skin'].'</small>';
		echo '</div>';
		echo '</a></li>';
	}
	echo '<li><a href="'.G5_BBS_URL.'/my/_adm/?tab=1&pn=_adm_config" class="popWin icon_setting blue" data-width="1250" data-height="720" data-top="60" data-left="0">사이트 관리</a></li>';
	echo '<li><a href="'.G5_URL.'/link.php" target="_blank" class="icon_sitemap" alt="전체 게시판 현황">전체 게시판 현황</a></li>';
	if(G5_DEVICE_BUTTON_DISPLAY) {
		$reverce_device = G5_IS_MOBILE ? 'pc' : 'mobile';
		$href .= $seq ? '&amp;device='.$reverce_device : '?device='.$reverce_device;
		echo '<li><a href="'.get_device_change_url().'" class="'.(G5_IS_MOBILE?'icon_pc':'icon_mobile').'" alt="'.(G5_IS_MOBILE?'PC 보기':'모바일 보기').'">'.(G5_IS_MOBILE?'PC 보기':'모바일 보기').'</a></li>';
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
}


// 가변 메뉴
unset($auth_menu);
unset($menu);
unset($amenu);
$tmp = dir(G5_ADMIN_PATH);
$menu_files = array();
while ($entry = $tmp->read()) {
    if (!preg_match('/^admin.menu([0-9]{3}).*\.php$/', $entry, $m))
        continue;  // 파일명이 menu 으로 시작하지 않으면 무시한다.

    $amenu[$m[1]] = $entry;
    $menu_files[] = G5_ADMIN_PATH.'/'.$entry;
}
@asort($menu_files);
foreach($menu_files as $file_){
    include_once($file_);
}
@ksort($amenu);

$amenu = run_replace('admin_amenu', $amenu);
if( isset($menu) && $menu ){
    $menu = run_replace('admin_menu', $menu); 
}

//권한부여받은 페이지가 있는 중간 관리자
$au_menu_result = sql_query(" select * from {$g5['auth_table']} where mb_id = '{$member['mb_id']}' order by au_menu ");
$resultCount = sql_num_rows($au_menu_result);
$is_center_admin = sql_num_rows($au_menu_result) ? true : false;

if($is_center_admin && !G5_IS_MOBILE) {

	$au_menu_result_array = array();
	for ($jj=0; $row=sql_fetch_array($au_menu_result); $jj++) {
		$au_menu_result_array[] = $row['au_menu'];
	}

	$_tmp_auth = array();
	foreach($amenu as $key=>$value) {
		foreach($menu['menu'.$key] as $_key=>$_val) {
			if (!($_val[0] == '-' || !$_val[0])) {
				$_tmp_auth[$key]['key'][] = $_val[0];
				$_tmp_auth[$key]['val'][] = $_val[1];
				$_tmp_auth[$key]['url'][] = $_val[2];
			}
		}
	}

	echo '<div id="adminSet">';
	echo '<div class="adminMenu_opener"></div>';
	echo '<div class="adminMenu">';
	echo '<ul>';
	echo '<li><a href="'.G5_ADMIN_URL.'" target="_blank" class="icon_adm yellow bold" alt="관리자페이지">관리자페이지</a></li>';	
	$idx = 0;
	foreach($amenu as $key=>$value) {
		for($i=0; $i<count($_tmp_auth[$key]['key']); $i++) {
			if($i == 0) continue;
			if(in_array($_tmp_auth[$key]['key'][$i], $au_menu_result_array)) echo '<li><a href="'.$_tmp_auth[$key]['url'][$i].'" target="_blank">'.$_tmp_auth[$key]['val'][$i].'</a></li>';
			$idx++;
		}
	}
	echo '</ul>';
	echo '</div>';
	echo '</div>';
}
