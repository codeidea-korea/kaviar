<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_LIB_PATH.'/my/_boCategory.lib.php'); //인태
include_once(G5_LIB_PATH.'/my/_boSearch.lib.php'); //인태

//if($theme_type = 'shop') add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_THEME_CSS_URL.'/shop_board.css').'">', 3); //쇼핑몰 테마전용

// ───────────────────────────────────────────────────────────────────────────────────────
//																			_board
// ───────────────────────────────────────────────────────────────────────────────────────

//전용폴더 스킨 인지 표시 (빨간점) ───────────────────────────
if($is_admin == 'super') $seperate = '<div style="position:fixed;top:5px;left:5px;z-index:9999;display:inline-block;width:4px;height:4px;background:#ff0033;border-radius:50%;"></div>';
function seperate_skin($file_url) {
	global $g5, $is_admin, $seperate;
	$is_seperate = strpos($file_url, G5_THIS_DIR.'/') !== false ? true : false;
	$result = '';
	if(!$is_seperate) $seperate = '';
	return $seperate;
}
echo seperate_skin($board_skin_url); 



//게시판 페이지 구분 ───────────────────────────
$bo_listpage = $bo_viewpage = $bo_writepage = false;
if(basename($PHP_SELF) =='board.php' && !$wr_id) $bo_listpage = true;
if((basename($PHP_SELF) =='board.php' || basename($PHP_SELF) =='ajax.view.skin.php') && $wr_id) $bo_viewpage = true;
if(basename($PHP_SELF) =='write.php') $bo_writepage = true;	


if($bo_listpage) @include_once(G5_BBS_PATH.'/my/skinOption/skin.option.lib.php'); //게시판 스킨 옵션 



/* ──────────────────────────────────────────────────────
								게시판 기본스타일 (모바일 부분 적용)
────────────────────────────────────────────────────── */
if($bo_style['use_bo_style']) {
	
	$btn_write_style = explode("|",$bo_style['btn_write_style']);
	$btn_pager_style = explode("|",$bo_style['btn_pager_style']);
	$bo_title_style = explode("|",$bo_style['title_style']);

	$bo_title_root = '';
	if($bo_listpage) {		
		if($bo_title_style[1] && !G5_IS_MOBILE) $bo_title_root .= '--font-size:'.$bo_title_style[1].'px;';
		if($bo_title_style[2]) $bo_title_root .= '--font-color:'.$bo_title_style[2].';';
		if($bo_title_style[3] && !G5_IS_MOBILE) $bo_title_root .= 'margin-bottom:'.$bo_title_style[3].'px;';
	}

	$bo_btnSet_root = '';
	if($btn_write_style[0] && !G5_IS_MOBILE) $bo_btnSet_root .= '--font-size:'.$btn_write_style[0].'px;';
	if($btn_write_style[1] && !G5_IS_MOBILE) $bo_btnSet_root .= '--btn-width:'.$btn_write_style[1].'px;';
	if($btn_write_style[2] && !G5_IS_MOBILE) $bo_btnSet_root .= '--btn-height:'.$btn_write_style[2].'px;';
	if($btn_write_style[3]) $bo_btnSet_root .= '--btnColor:'.$btn_write_style[3].';';
	if($btn_write_style[4]) $bo_btnSet_root .= '--btnColor-hover:'.$btn_write_style[4].';';

	$pg_wrap_root = '';
	if($btn_pager_style[0] && !G5_IS_MOBILE) $pg_wrap_root .= '--btn-size:'.$btn_pager_style[0].'px;';
	if($btn_pager_style[1] && !G5_IS_MOBILE) $pg_wrap_root .= '--btn-gap:'.$btn_pager_style[1].'px;';
	if($btn_pager_style[1]!='' && $btn_pager_style[1]==0) $pg_wrap_root .=  '--btn-gap:'.$btn_pager_style[1].'px;';
	if($btn_pager_style[2] && !G5_IS_MOBILE) $pg_wrap_root .= '--btn-radius:'.$btn_pager_style[2].'px;';
	if($btn_pager_style[3]) $pg_wrap_root .= '--btnColor-active:'.$btn_pager_style[3].';';	

	if($pg_wrap_root) $boStyle .= '.boWrap .pg_wrap{'.$pg_wrap_root.'}';
	if($btn_pager_style[1] !='' && $btn_pager_style[1] == '0' && !G5_IS_MOBILE) {
		$boStyle .= '.boWrap{}';
		$boStyle .= '.boWrap .pg_wrap .pg > *:not(:last-child){border-right:0;}';
		$boStyle .= '.boWrap .pg_wrap .pg > *:first-child{border-top-right-radius:0 !important;border-bottom-right-radius:0 !important;}';
		$boStyle .= '.boWrap .pg_wrap .pg > *:last-child{border-top-left-radius:0 !important;border-bottom-left-radius:0 !important;}';
		$boStyle .= '.boWrap .pg_wrap .pg > *:not(:first-child):not(:last-child){border-radius:0 !important;}';
	}
}




//게시판 사이즈 ───────────────────────────
if(!G5_IS_MOBILE) {
	$bo_max_width = 'max-width:'.$width.';'; //게시판 최대사이즈
	if($board['bo_min_width']) $bo_min_width = 'min-width:'.$board['bo_min_width'].'px;'; //게시판 최소사이즈
	$bo_width = $bo_max_width.$bo_min_width;
	if($bo_viewpage && $board['bo_view_width']) { //상세페이지
		$bo_width = $board['bo_view_width'] <= 100 ? 'width:'.$board['bo_view_width'].'%;' : 'width:'.$board['bo_view_width'].'px;';
	}
}

//게시판 배경
$bo_background = explode("|",$board['bo_background']);

//게시판 여백 기본 적용
$is_bo_padding = true;

//모바일 상세,쓰기에서 전용해더 사용안함.
if(($bo_viewpage || $bo_writepage) && G5_IS_MOBILE) $is_extra_header = true;

//게시판 상하단내용 사용여부
$bo_content = true;

//게시판 상세 옵션
$bo_option = explode("|",$board['bo_option']);


if(($bo_listpage || defined('_INDEX_')) && file_exists($board_pcskin_path.'/list.head.skin.php')) {
	@include_once($board_pcskin_path.'/list.head.skin.php');
}
if($bo_viewpage && file_exists($board_pcskin_path.'/view.head.skin.php')) {
	@include_once($board_pcskin_path.'/view.head.skin.php');
}


//게시판스킨명 ───────────────────────────
$boSkin = $board['bo_skin'];
if(preg_match('#^theme/(.+)$#', $boSkin, $match) || preg_match('#^seperate/(.+)$#', $boSkin, $match)) $boSkin = $match[1];
$skin_adm = strpos($boSkin, 'adm-') !== false ? true : false;
$skin_pagemake = strpos($boSkin, 'pageMake') !== false ? true : false;
$skin_gallery = $boSkin == 'GALLERY' || strpos($boSkin, 'gallery') !== false ? true : false;

// 게시판 인크루드파일 ───────────────────────────
$htmlURL = G5_HTML_URL.'/'.$bo_table;
$imgURL = G5_HTML_URL.'/'.$bo_table.'/img';
$htmlPATH = G5_HTML_PATH.'/'.$bo_table;
$boTopPATH = $htmlPATH.'/bo_top.php';
$boBottomPATH = $htmlPATH.'/bo_bottom.php';
$is_boTop = file_exists($boTopPATH);
$is_boBottom = file_exists($boBottomPATH);

//게시판 상단 이미지 ───────────────────────────
$top_img_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img.png';
$top_img_mob_url = G5_DATA_URL.'/file/'.$bo_table.'/bo_top_img_mob.png';
$is_top_img_pc = file_exists(G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img.png');
$is_top_img_mob = file_exists(G5_DATA_PATH.'/file/'.$bo_table.'/bo_top_img_mob.png');
$bo_top_img = false;
if(!G5_IS_MOBILE && $is_top_img_pc) $bo_top_img = true;
if(G5_IS_MOBILE && $is_top_img_mob) $bo_top_img = true;
// 상단 이미지 -> my/bo_top_img.php


//게시판 배경컬러 설정 ───────────────────────────
//if($bo_listpage) {
	if($bo_background[0] && $board['bo_skin'] != 'pageMake') {
		$boStyle .= '#wrapper, #container, .headerSpace{background:'.$bo_background[0].';}'.PHP_EOL;
		$boStyle .= '.boWrap .ul_adm li input[type="submit"]{background:rgba(53,57,69,0.7);color:#fff;}';
	}
	if($bo_background[1]) {
		$boStyle .= '.boWrap, .boWrap form a:not([class*="btn_"]):not([class*="btn"]), .boWrap .textsubject, .boWrap .textContent, .boWrap .list_infoSet, .boWrap .list_infoSet .writer, .boWrap .tagSet,
			#container_title, .boWrap .cate_ul li a{color:'.$bo_background[1].';}';
		$boStyle .= '.boWrap .cate_ul li:not(.active) a, .boWrap .textContent, .boWrap .list_infoSet{opacity:0.8}';
		$boStyle .= '.boWrap .cate_ul li:not(.active) a:hover{opacity:1}';
		$boStyle .= '.boWrap .cate_ul li.active a:after, .boWrap .list_infoSet .writer:after{background:'.$bo_background[1].';}';
		$boStyle .= '.boWrap .list_infoSet .writer:after{opacity:0.4}';
		$boStyle .= '.boWrap form table thead tr th{color:'.$bo_background[1].';}';
	}
	if($bo_top_img) {
		$boWrap_background = $bo_background[0] ? $bo_background[0] : '#fff';
		$boStyle .= '.boWrap{background:'.$boWrap_background.';}';			
	}
//}


/* ──────────────────────────────────────────────────────
											게시판 제목
────────────────────────────────────────────────────── */
$is_bo_title = $board['bo_subject_hide'] ? false : true;
$bo_subject = G5_IS_MOBILE && $board['bo_mobile_subject'] ? $board['bo_mobile_subject'] : $board['bo_subject'];
$bo_title_sub = $skin_adm && !$bo_viewpage ? '<span class="bo_title_sub">관리전용 스킨</span>' : '';
$bo_title = $bo_title_viewpage = '<div id="bo_title"><a href="'.get_pretty_url($bo_table).'">'.$bo_subject.'</a>'.$bo_title_sub.'</div>';
//if($theme_type=='shop') $bo_title = '';

// 최고관리자 또는 그룹관리자라면
$bo_admin_href = "";
if ($member['mb_id'] && ($is_admin === 'super' || $group['gr_admin'] === $member['mb_id'])) {
	$bo_admin_href = G5_ADMIN_URL.'/board_form.php?w=u&amp;bo_table='.$bo_table;
}

$bo_cate_label = $board['bo_category_label'] ? $board['bo_category_label'] : '카테고리';
$bo_cate_skin = $board['bo_cate_skin'];
$bo_comment = $board['bo_comment_level'] >= 1 ? true : false;
$bo_hit = $board['bo_hit'] ? true : false;
$bo_writer = ($bo_listpage && $board['bo_list_writer']) || ($bo_viewpage && $board['bo_view_writer']) ? true : false;
$bo_date = ($bo_listpage && $board['bo_list_date']) || ($bo_viewpage && $board['bo_view_date']) ? true : false;
$bo_use_good_guest = $board['bo_use_good_guest'] ? true : false; //비회원도 추천 가능
$bo_use_reply_captcha = ($board['bo_use_reply_captcha'] == 1 && $member['mb_level'] == 1) || ($board['bo_use_reply_captcha'] == 2 && $member['mb_level'] < 6) ? true : false; //자동등록방지 여부


if(G5_IS_MOBILE) {
	if($is_bo_padding) {
		//if($board['bo_mobile_padding']) $boStyle .= '.boWrap > *:not(#bo_cate){padding-left:'.$board['bo_mobile_padding'].'px;padding-right:'.$board['bo_mobile_padding'].'px;}'.PHP_EOL;
		if($board['bo_mobile_padding']) {
			$boStyle .= '.boWrap{--bo-mobile-padding:'.$board['bo_mobile_padding'].'px;--bo-mobile-inner-padding:0;}'.PHP_EOL;
		} else {
			if($bo_writepage) $boStyle .= '.boWrap{--bo-mobile-padding:15px;}'.PHP_EOL;
			$boStyle .= '.boWrap{--bo-mobile-inner-padding:15px;}'.PHP_EOL;
		}
	}
} else {
	if($bo_writepage) {
		$is_bo_padding = true; //모든 쓰기페이지는 여백옵션 적용
		$board['bo_padding_top'] = 100;
		$board['bo_padding_bottom'] = 100;
		$board['bo_padding_left_right'] = 100;
	}
	if($is_bo_padding) {
		if($board['bo_padding_top']) $boStyle .= '.boWrap{padding-top:'.$board['bo_padding_top'].'px;}'.PHP_EOL;
		if($board['bo_padding_bottom']) $boStyle .= '.boWrap{padding-bottom:'.$board['bo_padding_bottom'].'px;}'.PHP_EOL;
		$bo_padding_left_right = $board['bo_table_width'] == '100' && $board['bo_padding_left_right'] <= 10 ? $board['bo_padding_left_right'].'%;' : $board['bo_padding_left_right'].'px;';
		if($board['bo_padding_left_right']) $boStyle .= '.boWrap{padding-left:'.$bo_padding_left_right.'padding-right:'.$bo_padding_left_right.'}'.PHP_EOL;
	}		
}

// 게시판 관리 버튼 ───────────────────────────
$boSetting_url = '';
if($is_admin == 'group' || $is_admin == 'super' || $is_admin == 'board') {
	if($bo_writepage) {
		$boSetting_url = G5_BBS_URL.'/my/_adm/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=write';
		$pop_height = '560';
	} else if($bo_viewpage) {
		$boSetting_url = G5_BBS_URL.'/my/_adm/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table.'&ps=view';
		$pop_height = '560';
	} else {
		$boSetting_url = G5_BBS_URL.'/my/_adm/?pn=_board_form&title=게시판 설정&bo_table='.$bo_table;
		$pop_height = $board['bo_skin'] == 'pageMake' ? '750' : '750';
	}
	
	if($boSetting_url && !defined('_INDEX_')) $boSetting = '<a href="'.$boSetting_url.'" id="boSetting" class="btnSetting popWin" data-width="1250" data-height="'.$pop_height.'" data-top="60" data-left="0" data-area=".boWrap">게시판 관리</a>'; //board_head.php에서 출력
}






/* ──────────────────────────────────────────────────────
											모바일 게시판 헤더
────────────────────────────────────────────────────── */
if(G5_IS_MOBILE) {
	include_once(G5_LIB_PATH.'/my/quick.latest.lib.php'); //인태 - $is_quickNews여부를 확인하기 위해 lib파일을 head.php보다 먼저 인크루드 한다. 

	//모바일 상세,쓰기 전용 헤더
	$instant_header = false;

	if($bo_viewpage) {
		$instant_header .= '<div id="hd-l">';
		$instant_header .= '<a href="javascript:history.back()" class="history-back" alt="뒤로">'.($bo_viewpage?'뒤로':'취소').'</a>';
		$instant_header .= '</div>';	
		$instant_header .= '<div id="bo_v_title" class="'.$bo_title_style[0].'"><a href="'.get_pretty_url($bo_table).'">'.$bo_subject.'</a>'.($category_name?'<span class="sub ellipsis">'.$category_name.'</span>':'').'</div>';
		if($board['bo_search_skin'] || $is_quickNews) {
			$instant_header .= '<div id="hd-r">';
			if($is_quickNews) $instant_header .= '<span class="quickNews_opener">Quick News</span>';
			$instant_header .= '</div>';
		}
	}

	if($bo_writepage) {
		$instant_header .= '<div id="hd-l">';
		$instant_header .= '<a href="javascript:history.back()" class="history-back" alt="뒤로">'.($bo_viewpage?'뒤로':'취소').'</a>';
		$instant_header .= '</div>';	
		$instant_header .= '<div id="bo_v_title" class="'.$bo_title_style[0].'"><a href="'.get_pretty_url($bo_table).'">'.$bo_subject.'</a>'.($category_name?'<span class="sub ellipsis">'.$category_name.'</span>':'').'</div>';
		if($board['bo_search_skin'] || $is_quickNews) {
			$instant_header .= '<div id="hd-r">';
			$instant_header .= '<span class="btnSubmit">등록</span>';
			$instant_header .= '</div>';
		}
	}

	if($instant_header) $is_bo_title = false;
}






// 썸네일 가로 수, 썸네일 사이즈, 썸네일 간격 -> list.php
// 상세페이지 폭 -> board.php
//if (!G5_IS_MOBILE) echo '<div style="width:'.$width.'; margin:0 auto;">'.include_once(G5_THEME_PATH.'/location.php').'</div>'; //location