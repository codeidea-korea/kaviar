<?php
if (!defined('_GNUBOARD_')) exit;

/*require_once (G5_PATH.'/lib/my/Mobile-Detect/Mobile_Detect.php'); // 모바일 Detect Class 파일
//테블릿 구분 추가
$detect = new Mobile_Detect;
$is_tablet = $detect->isTablet() ? true : false;*/


// ───────────────────────────────────────────────────────────────────
//														메뉴 호출 (메인메뉴)
// ───────────────────────────────────────────────────────────────────
function get_globalMenu($code="", $chasi=1) {
    global $g5;
    $MenuSql = "";
    $MenuResult = "";
    $MenuRow = array();
    $chasiLength = $chasi*2;
    $nextChasi = $chasi+1;
    $MenuWhere = " and length(me_code) = '".$chasiLength."' ";
    if($chasi > 1)
        $MenuWhere .= " and me_code LIKE '".$code."%' ";

	$myOrder = G5_IS_MOBILE ? "(me_use = '1' or me_use = '3')" : "(me_use = '1' or me_use = '2')"; //사용여부 추가
	$myOrder .= " and me_name !='' "; //메뉴명이 없으면 제외
    $MenuSql = " select * from {$g5['menu_table']} where {$myOrder} ".$MenuWhere." order by me_order, me_id ";
    $MenuResult = sql_query($MenuSql);
    for($i=0; $MenuRow = sql_fetch_array($MenuResult); $i++) {
        $Menu[$i] = $MenuRow;
        $Menu[$i][$nextChasi] = get_globalMenu($MenuRow['me_code'],$nextChasi);
        $Menu['cnt']++;
    }
    return $Menu;
}

function get_gnb_a_tag($gnb_cha, $cha=1) {
	global $g5;	
	$a_tag_class = '';
	$a_tag_class .= 'dep'.$cha.'_link';
	if($gnb_cha['me_target'] == 'alert') {
		$gnb_cha['me_link'] = 'javascript:alert(\''.$gnb_cha['me_link'].'\');';
	} else if($gnb_cha['me_target'] == 'popup') {
		$gnb_cha['me_link'] = explode('|', $gnb_cha['me_link'] );				
		$gnb_cha['me_link'][1] = $gnb_cha['me_link'][1] ? $gnb_cha['me_link'][1] : 400;
		$gnb_cha['me_link'][2] = $gnb_cha['me_link'][2] ? $gnb_cha['me_link'][2] : 500;
		$gnb_chaMenuOption[$i] = 'data-width="'.$gnb_cha['me_link'][1].'" data-height="'.$gnb_cha['me_link'][2].'" data-top="'.$gnb_cha['me_link'][3].'" data-left="'.$gnb_cha['me_link'][4].'" ';
		$gnb_cha['me_link'] = $gnb_cha['me_link'][0];
		$a_tag_class .= ' popWin';
	} else {			
		if( !preg_match('/http(s?)\:\/\//i', $gnb_cha['me_link']) && $gnb_cha['me_link'] != '#' ) $gnb_cha['me_link'] = G5_BBS_URL.'/board.php?bo_table='.$gnb_cha['me_link'];
		$gnb_chaMenuOption[$i] = $gnb_cha['me_target'] == 'blank' ? 'target="_blank"' : '';
	}
	if($gnb_cha['me_link'] == '#' || !$gnb_cha['me_link']) {
		$a_tag = '<span class="'.$a_tag_class.' null" '.$navStyle[$i].' '.$gnb_chaMenuOption[$i].' alt="'.$gnb_cha['me_name'].'">'.$gnb_cha['me_name'].'</span>';
	} else {
		$a_tag = '<a href="'.$gnb_cha['me_link'].'" class="'.$a_tag_class.'" '.$gnb_chaMenuOption[$i].' alt="'.$gnb_cha['me_name'].'">'.$gnb_cha['me_name'].'</a>';
	}
	return $a_tag;
}

$is_2chaMenu = false;
$globalMenu = get_globalMenu();
$galobalNavigation = '';
$galobalNavigation .= '<ul class="nav_ul">';
for($i=0; $i<$globalMenu['cnt']; $i++) {
	//1차 메뉴
	$gnb1 = $globalMenu[$i];
	$navClass[$i] = '';
	if($board['bo_subject'] == $gnb1['me_name'] || $board['bo_table'] == $gnb1['me_link'] && !defined('_INDEX_')) $navClass[$i] .= ' active';
	if(strpos($gnb1['me_link'], '&sca=') !== false) { //링크에 카테고리가 있다면, 해당 게시판 카테고리페이지일때 활성화
		$gnb1_link_sca[$i] = explode('&sca=', $gnb1['me_link']);
		if($board['bo_table'] == $gnb1_link_sca[$i][0] && $sca == $gnb1_link_sca[$i][1] && !defined('_INDEX_')) $navClass[$i] .= ' active';
	}
	if($gnb1['me_level'] >= 5) $navClass[$i] .= ' adm';
	if($gnb1['me_target'] == 'blank') $navClass[$i] .= ' blank';
	if($gnb1['me_use_id']) {
		$tmpArr= explode(',', $gnb1['me_use_id']); //접근 아이디
		$is_menuOn[$i] = in_array( $member['mb_id'], $tmpArr) || $is_admin ? true : false;		
	} else {
		$is_menuOn[$i] = $gnb1['me_level'] <= $member['mb_level'] ? true : false;
	}
	if($is_menuOn[$i]) {		
		$openMenu = explode(",",$config['cf_open_menu']); //상시 열림 메뉴 채크
		$defaultOpen[$i] = false;
		for($om = 0; $om < count($openMenu); $om++) {
			if($gnb1['me_name'] == $openMenu[$om]) $navClass[$i] .= ' defaultOpen open';
		}
		$galobalNavigation .= '<li class="nav_li'.$navClass[$i].''.($globalMenu[$i][2]['cnt']?' hasSub':'').'">';
		$galobalNavigation .= get_gnb_a_tag($gnb1, $cha=1);
		
		//2차 메뉴
		if($globalMenu[$i][2]['cnt']) {
			$is_2chaMenu = true;
			$galobalNavigation .= '<ul class="sub2cha_ul" data-parent="'.$gnb1['me_name'].'">'.PHP_EOL;
			for($j=0; $j<$globalMenu[$i][2]['cnt']; $j++) {
				$gnb2 = $globalMenu[$i][2][$j];
				$sub2chaClass[$j] = '';
				if(($board['bo_subject'] == $gnb2['me_name'] || $board['bo_table'] == $gnb2['me_link']) && !defined('_INDEX_')) $sub2chaClass[$j] .= ' active';				
				if(strpos($gnb2['me_link'], '&sca=') !== false) { //링크에 카테고리가 있다면, 해당 게시판 카테고리페이지일때 활성화
					$gnb2_link_sca[$j] = explode('&sca=', $gnb2['me_link']);
					if($board['bo_table'] == $gnb2_link_sca[$j][0] && $sca == $gnb2_link_sca[$j][1] && !defined('_INDEX_')) $sub2chaClass[$j] .= ' active';
				}
				if($gnb2['me_level'] >= 5) $sub2chaClass[$j] .= ' adm';
				if($gnb2['me_target'] == 'blank') $sub2chaClass[$j] .= ' blank';
				if($gnb2['me_use_id']) {
					$tmpArr2= explode(',', $gnb2['me_use_id']);
					$is_sub2chaOn[$j] = in_array( $member['mb_id'], $tmpArr2) || $is_admin ? true : false;		
				} else {
					$is_sub2chaOn[$j] = $gnb2['me_level'] <= $member['mb_level'] ? true : false;
				}
				if($is_sub2chaOn[$j]) {
					$galobalNavigation .= '<li class="sub2cha_li'.$sub2chaClass[$j].'">';
					$galobalNavigation .= get_gnb_a_tag($gnb2, $cha=2);
					//if($submenuActive[$j] && $is_admin && G5_IS_MOBILE) $galobalNavigation .= '<a href="'.$admin_href.'" class="bo_admin" target="_blank" alt="게시판 관리자">게시판 관리자</a>';

					//3차 메뉴
					if($globalMenu[$i][2][$j][3]['cnt']) {
						$galobalNavigation .= '<ul class="sub3cha_ul" data-parent="'.$gnb1['me_name'].'">'.PHP_EOL;
						for($k=0; $k<$globalMenu[$i][2][$j][3]['cnt']; $k++) {
							$gnb3 = $globalMenu[$i][2][$j][3][$k];
							$sub3chaClass[$k] = '';
							if(($board['bo_subject'] == $gnb3['me_name'] || $board['bo_table'] == $gnb3['me_link']) && !defined('_INDEX_')) $sub3chaClass[$k] .= ' active';
							if(strpos($gnb3['me_link'], '&sca=') !== false) { //링크에 카테고리가 있다면, 해당 게시판 카테고리페이지일때 활성화
								$gnb3_link_sca[$k] = explode('&sca=', $gnb3['me_link']);
								if($board['bo_table'] == $gnb3_link_sca[$k][0] && $sca == $gnb3_link_sca[$k][1] && !defined('_INDEX_')) $sub3chaClass[$k] .= ' active';
							}
							if($gnb3['me_level'] >= 5) $sub3chaClass[$k] .= ' adm';
							if($gnb3['me_target'] == 'blank') $sub3chaClass[$k] .= ' blank';
							if($gnb3['me_use_id']) {
								$tmpArr3= explode(',', $gnb3['me_use_id']);
								$is_sub3chaOn[$k] = in_array( $member['mb_id'], $tmpArr3) || $is_admin ? true : false;		
							} else {
								$is_sub3chaOn[$k] = $gnb3['me_level'] <= $member['mb_level'] ? true : false;
							}
							if($is_sub3chaOn[$k]) {
								$galobalNavigation .= '<li class="sub3cha_li'.$sub3chaClass[$k].'">';
								$galobalNavigation .= get_gnb_a_tag($gnb3, $cha=3);
								$galobalNavigation .= '</li>';
							}
						}
						$galobalNavigation .= '</ul>'.PHP_EOL;
					}
					//3차 끝

					$galobalNavigation .= '</li>';
				}
			}
			$galobalNavigation .= '</ul>'.PHP_EOL;
		}
		//2차 끝

		$galobalNavigation .= '</li>';
	}
}
$galobalNavigation .= '</ul>';



// ───────────────────────────────────────────────────────────────────
//						상단 보조메뉴(상단) 호출 (게시판 그룹별 전용 포함) - 테마전용...
// ───────────────────────────────────────────────────────────────────
$top_menu_list = '';
$tm_order = $group['gr_use_layout'] ? "top_menu_cate = '{$group[gr_id]}' " : "top_menu_cate = '' ";
$sql = " select * from {$g5['top_menu_table']} where {$tm_order} and length(top_menu_code) = '2' order by top_menu_order, top_menu_id ";
$result = sql_query($sql, false);
$gnb_zindex = 999; // gnb_1dli z-index 값 설정용
$top_menu_datas = array();

for($i=0; $row=sql_fetch_array($result); $i++) {
	$top_menu_datas[$i] = $row;
	$sql2 = " select * from {$g5['top_menu_table']} where length(top_menu_code) = '4' and substring(top_menu_code, 1, 2) = '{$row['top_menu_code']}' order by top_menu_order, top_menu_id ";
	$result2 = sql_query($sql2);
	for ($k=0; $row2=sql_fetch_array($result2); $k++) {
		$top_menu_datas[$i]['sub'][$k] = $row2;
	}
}

$i = 0;
foreach($top_menu_datas as $row) {
	if(empty($row)) continue; 
	$topmenuClass[$i] = '';
	if($board['bo_subject'] == $row['top_menu_name']) $topmenuClass[$i] .= ' on';
	if($row['top_menu_target'] == 'blank') $topmenuClass[$i] .= 'blank ';

	if($row['top_menu_target'] == 'alert') {
		$row['top_menu_link'] = 'javascript:alert(\''.$row['top_menu_link'].'\');';
	} else if($row['top_menu_target'] == 'popup') {
		$row['top_menu_link'] = explode('|', $row['top_menu_link'] );				
		$row['top_menu_link'][1] = $row['top_menu_link'][1] ? $row['top_menu_link'][1] : 400;
		$row['top_menu_link'][2] = $row['top_menu_link'][2] ? $row['top_menu_link'][2] : 500;
		$rowMenuOption[$i] = 'data-width="'.$row['top_menu_link'][1].'" data-height="'.$row['top_menu_link'][2].'" data-top="'.$row['top_menu_link'][3].'" data-left="'.$row['top_menu_link'][4].'" ';
		$row['top_menu_link'] = $row['top_menu_link'][0];
		$row['top_menu_target'] = 'popWin';
	} else {			
		if( !preg_match('/http(s?)\:\/\//i', $row['top_menu_link']) && $row['top_menu_link'] != '#' ) {
			$row['top_menu_link'] = G5_BBS_URL.'/board.php?bo_table='.$row['top_menu_link'];
		}
		$rowMenuOption[$i] = $row['top_menu_target'] == 'blank' ? 'target="_black"' : '';
	}

	$top_menu_list .= '<li class="nav_li'.$topmenuClass[$i].'">';
	$top_menu_list .= '	<a href="'.$row['top_menu_link'].'" class="dep1_link '.$row['top_menu_target'].'" '.$rowMenuOption[$i].' alt="'.$row['top_menu_name'].'">'.$row['top_menu_name'].'</a>';
	$top_menu_list .= '</li>';
}




//검색페이지 채크
if(basename($PHP_SELF) =='search.php') $searchpage = basename($PHP_SELF) =='search.php' ? true : false;



//회원 아웃로그인 정보 <- [lib/outlogin.lib.php]
if($is_member) {

	//그룹관리자 메뉴
	$group_adm = '';	
	$sql = " select gr_id, gr_subject, gr_main_table from {$g5['group_table']} where gr_admin like '{$member['mb_id']}' ";
	$result = sql_query($sql);
	$g = 0;
	for ($g=0; $row=sql_fetch_array($result); $g++) {
		if($row['gr_main_table']) {
			$group_adm .= '<a href="'.G5_URL.'/bbs/board.php?bo_table='.$row['gr_main_table'].'" class="member-tag group-admin">'.$row['gr_subject'].' 페이지관리</a>';
		} else {
			$group_adm .= '<a href="'.G5_URL.'/bbs/group.php?gr_id='.$row['gr_id'].'" class="member-tag group-admin">'.$row['gr_subject'].' 페이지관리</a>';
		}
		$g++;
	}

	if (array_key_exists('mb_nick', $member)) $nick  = get_text(cut_str($member['mb_nick'], $config['cf_cut_name']));
    if (array_key_exists('mb_point', $member)) $point = number_format($member['mb_point']);
	if( isset($member['mb_memo_cnt']) ){
		$memo_not_read = $member['mb_memo_cnt'];
	} else {
		$memo_not_read = get_memo_not_read($member['mb_id']);
	}
	$mb_scrap_cnt = isset($member['mb_scrap_cnt']) ? (int) $member['mb_scrap_cnt'] : '';
}

//회원가입 url
//$join_url = $config['cf_use_join_code'] && $config['cf_join_code'] ? G5_BBS_URL.'/my/member/joinCode.php' : G5_BBS_URL.'/register.php';
$join_url = G5_BBS_URL.'/register.php';



//관리자(팝업) 경로
$_adm_url = G5_BBS_URL.'/my/_adm';



// ───────────────────────────────────────────────────────────────────────────────────────────────────────
//																					커뮤니티 전용 스크립트
// ───────────────────────────────────────────────────────────────────────────────────────────────────────

// [imagesloaded]
//add_javascript('<script src="'.get_url(G5_JS_URL.'/my/imagesloaded/imagesloaded.pkgd.min.js').'"></script>', 1);
// [_common]
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/_common.js').'"></script>', 1);
// [easing]
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/easing.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/jquery.transit.min.js').'"></script>', 1);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/animation/animations.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url('https://cdnjs.cloudflare.com/ajax/libs/egjs-jquery-transform/2.0.0/transform.min.js').'"></script>', 1);
// [magnific-popup]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/magnific-popup/magnific-popup.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/magnific-popup/jquery.magnific-popup.js').'"></script>', 1);
// [swiper]
//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/swiper/swiper.min.css').'">', 1);
//add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/swiper/swiper.min.js').'"></script>', 1);
//add_stylesheet('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />', 1);
//add_javascript('<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>', 1);
//add_stylesheet('<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />', 1);
//add_javascript('<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>', 1);
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/swiper-bundle.min20240501.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/swiper-bundle.min20240501.js').'"></script>', 1);

// [wow]
//add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/wow/animate.css').'">', 1);
//add_javascript('<script src="'.get_url(G5_JS_URL.'/my/wow/wow.js').'"></script>', 1);
// [parallax]
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/parallax/jquery.appear.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/parallax/jquery.parallax.js').'"></script>', 1);
// [ScrollTrigger]
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/gsap.min.js"></script>',1);
add_javascript('<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.6.0/ScrollTrigger.min.js"></script>',1);
// [bodymovin]
//add_javascript('<script src="'.get_url(G5_JS_URL.'/my/bodymovin/lottie.min.js').'"></script>', 1);
//add_javascript('<script src="'.get_url(G5_JS_URL.'/my/bodymovin/svgAnimation.js').'"></script>', 1);
// [bootstrap-select]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.G5_JS_URL.'/my/form/bootstrap-select/bootstrap.min.js"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/bootstrap-select/bootstrap-select.js').'"></script>', 1);
// [datepicker]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.css').'">', 1);
add_javascript('<script type="text/javascript" type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.js').'"></script>', 1);
add_javascript('<script type="text/javascript" type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/datepicker/datepicker.ko-KR.js').'"></script>', 1);
// [colorpicker]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.G5_JS_URL.'/my/form/colorpicker/jquery.minicolors.js"></script>', 1);
// [myform]
add_stylesheet('<link rel="stylesheet" href="'.get_url(G5_CSS_URL.'/_myform.css').'">', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/form/myform'.(G5_IS_MOBILE?'-sm':'-lg').'.js').'"></script>', 1);
// [myScript]
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/myScript.js').'"></script>', 1);
add_javascript('<script type="text/javascript" src="'.get_url(G5_JS_URL.'/my/myScript'.(G5_IS_MOBILE?'-sm':'-lg').'.js').'"></script>', 1);