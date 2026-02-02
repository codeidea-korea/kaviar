<?php
if (!defined('_GNUBOARD_')) exit;// 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

//블록아이디 정의
$blockID = '#'.$blockName;

$_masonry = strpos($latest_type, '_masonry') !== false ? true : false;
$_slide = strpos($latest_type, '_slide') !== false ? true : false;
$_webzine = strpos($latest_type, '_webzine') !== false ? true : false;
$_grid = strpos($latest_type, '_grid') !== false ? true : false;


include(G5_BBS_PATH.'/my/skinOption/latest.skin.option.lib.php'); //옵션관리
@include($latest_skin_path.'/latest.skin.option.lib.php'); //스킨폴더안에 옵션파일
include(G5_BBS_PATH.'/my/skinOption/latest.skin.option.style.php');

$board_skin_url = is_dir($board_skin_path) ? $board_skin_url : $board_pcskin_url;

//가로 수
$latest_gall_cols = $colspan ? $colspan : $board['bo_gallery_cols'];

//리스트 간격
$gutter = $distance;

//상속받은 썸네일 사이즈 (비율만 상속한다.)
$bo_gallery_width = G5_IS_MOBILE ? $board['bo_mobile_gallery_width'] : $board['bo_gallery_width'];
$bo_gallery_height = G5_IS_MOBILE ? $board['bo_mobile_gallery_height'] : $board['bo_gallery_height'];

//기본 썸네일 사이즈 (썸네일 비율은 불러오는 게시판 설정에 따름)
$thumbWidth = (int)(($latest_width - $gutter * ($latest_gall_cols -1)) / $latest_gall_cols);
$thumbHeight = (int)(($thumbWidth / $bo_gallery_width) * $bo_gallery_height);



//리스트 자동사이즈 사용여부 및 썸네일 설정 및 전용 스타일
@include($latest_pcskin_path.'/latest.head.skin.php');

//썸네일 사이즈
if($autoThumb) {
	$thumbWidth = $thumb_width ? $thumb_width : $thumbWidth;
	$thumbHeight = $thumb_height ? $thumb_height : $thumbHeight;
	if($_masonry) $thumbHeight = 0; //masonry일때 원본비율 유지
	for ($i=0; $i<count($list); $i++) {
		//목록에서 재생 비디오
		$playVideo[$i] = $list[$i]['wr_video'] && $list[$i]['wr_video_play'] ? true : false;
		if($playVideo[$i]) { //비디오 타입 채크
			if(strpos($list[$i]['wr_video_src'], 'youtu') !== false) {
				$video_type[$i] = 'youtube';
			} else if(strpos($list[$i]['wr_video_src'], 'vimeo') !== false) {
				$video_type[$i] = 'vimeo';
			} else if($list[$i]['wr_video_src']) {
				$video_type[$i] = 'mp4';
			}
		}
		$new_thumbWidth = $new_thumb_width ? $new_thumb_width : $thumbWidth;
		$new_thumbHeight = $new_thumb_height ? $new_thumb_height : $thumbHeight;

		

		/*if($_grid) {
			if($list[$i]['wr_grid']=='grid_4x2') $new_thumbWidth = 1300;
			if($list[$i]['wr_grid']=='grid_3x1' || $list[$i]['wr_grid']=='grid_3x2' || $list[$i]['wr_grid']=='grid_3x3' || $list[$i]['wr_grid']=='grid_3x4') $new_thumbWidth = 1200;
			if($list[$i]['wr_grid']=='grid_2x2' || $list[$i]['wr_grid']=='grid_2x3' || $list[$i]['wr_grid']=='grid_2x4') $new_thumbWidth = 760;
			if($list[$i]['wr_grid']=='grid_1x1' || $list[$i]['wr_grid']=='grid_1x2' || $list[$i]['wr_grid']=='grid_1x3' || $list[$i]['wr_grid']=='grid_1x4') $new_thumbWidth = 620;
			$new_thumbHeight = 0;
		}*/
		
		if($_webzine) {
			$new_thumbWidth = G5_IS_MOBILE ? $board['bo_mobile_gallery_width']*1.5 : $board['bo_gallery_width'];
			$new_thumbHeight = G5_IS_MOBILE ? $board['bo_mobile_gallery_height']*1.5 : $board['bo_gallery_height'];
		}

		if($_slide && $latest_gall_cols == 1) {
			$new_thumbWidth = $new_thumbHeight = round($latest_width / 1.8);
		}
		
		$editor_img = $editor_img_not ? false : true;
		$img_thumb[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $new_thumbWidth, $new_thumbHeight, false, true, 'center', false, '80/0.5/3', 0, $editor_img);
	}

	//비디오 플레이 버튼 사이즈
	/*$youtube_height = (int)($thumbWidth * 480 / 850);
	$latestStyle .= $blockID.' .gall_li .youtube-wrap .video{height:'.$youtube_height.'px;}'.PHP_EOL;*/
}

//갤러리형 가로사이즈(비율)
if($gallCols && !$_grid) {

	//반응형 갤러리 목록수 감소
	if($board['bo_max_screen'] || $list[$i]['wr_max_screen']) {
		$board['bo_max_screen'] = $list[$i]['wr_max_screen'] ? $list[$i]['wr_max_screen'] : $board['bo_max_screen'];
		$bo_max_screen = explode('|', $board['bo_max_screen']);
		$bo_min_screen = $bo_max_screen[0] + 1;
	}

	if($board['bo_max_screen'] && $latest_gall_cols > 1 && !G5_IS_MOBILE) $latestStyle .= '@media screen and (min-width:'.$bo_min_screen.'px) {'.PHP_EOL;

	$latestStyle .= $blockID.' .gall_ul{--gall-cols:'.$latest_gall_cols.';--gall-gap:'.$gutter.'px;}';
	if($_masonry) $latestStyle .= $blockID.' .gall_ul .gall_li:nth-child(-n+'.$latest_gall_cols.'){margin-top:0 !important}';
	if($_webzine) {
		$latestStyle .= $blockID.' .gall_ul .gall_li:nth-child(-n+'.$latest_gall_cols.'){border-top-width:1px;}';		
		if($latest_gall_cols > 2) {
			$latestStyle .= $blockID.' .wzContents{display:block;}'.PHP_EOL;
			$latestStyle .= $blockID.' .wzContents .wz_thumb{float:left;z-index:5;max-width:37%;margin-right:15px;margin-bottom:10px;}'.PHP_EOL;
			$latestStyle .= $blockID.' .wzContents .wz_con{display:inline;}'.PHP_EOL;
			$latestStyle .= $blockID.' .wzContents .textSubject{margin-bottom:10px;display:line-block !important;width:auto !important}'.PHP_EOL;
			$latestStyle .= $blockID.' .wzContents .list-btn-set{width:100%;margin-top:20px;}'.PHP_EOL;
		}
	}
	if($board['bo_max_screen'] && $latest_gall_cols > 1 && !G5_IS_MOBILE) $latestStyle .= '}'.PHP_EOL;

	//반응형 | 구분만큼 반복
	if($board['bo_max_screen'] && $latest_gall_cols > 1 && !G5_IS_MOBILE) {
		for ($s=0; $s<count($bo_max_screen); $s++) {
			$n = $s+1;
			$maxScreen = trim($bo_max_screen[$s]);
			$minScreen = trim($bo_max_screen[$n]);
			if ($maxScreen=='') continue;
			$new_latest_cols = $latest_gall_cols - $n;
			$latestStyle .= '@media screen and ';
			if($minScreen) $latestStyle .= '(min-width:'.$minScreen.'px) and ';
			$latestStyle .= '(max-width:'.$maxScreen.'px) {'.PHP_EOL;
			$latestStyle .= $blockID.' .gall_ul{--gall-cols:'.$new_latest_cols.';--gall-gap:'.$gutter.'px;}';
			if($_masonry) $latestStyle .= $blockID.' .gall_ul .gall_li:nth-child(-n+'.$new_latest_cols.'){margin-top:0 !important}';
			if($_webzine) {
				$latestStyle .= $blockID.' .gall_ul .gall_li:nth-child(-n+'.$new_latest_cols.'){border-top-width:1px;}';
				if($new_latest_cols > 1) {
					$latestStyle .= $blockID.' .wzContents{display:block;}'.PHP_EOL;
					$latestStyle .= $blockID.' .wzContents .wz_thumb{float:left;z-index:5;max-width:37%;margin-right:15px;margin-bottom:10px;}'.PHP_EOL;
					$latestStyle .= $blockID.' .wzContents .wz_con{display:inline;}'.PHP_EOL;
					$latestStyle .= $blockID.' .wzContents .textSubject{margin-bottom:10px;display:line-block !important;width:auto !important}'.PHP_EOL;
					$latestStyle .= $blockID.' .wzContents .list-btn-set{width:100%;margin-top:20px;}'.PHP_EOL;					
				}
			}
			$latestStyle .= '}'.PHP_EOL;
		}
	}

} //-- end $gallCols


if($_slide && $board['bo_max_screen']) {
	$bo_max_screen = explode('|', $board['bo_max_screen']);
	for ($s=0; $s<count($bo_max_screen); $s++) {
		$newCols[$s] = $latest_gall_cols - ($s + 1);
		$breakpoints[$s] = trim($bo_max_screen[$s]);
	}
}


//그룹전용 페이지에서 메인용 퀵뉴스는 레이어팝업으로 처리
if($group['gr_use_layout']) {
	if($board['bo_table'] == $quick_news['qn_table1'] || $board['bo_table'] == $quick_news['qn_table2']) $board['bo_layer_popup'] = true;
}

for ($i=0; $i<count($list); $i++) {

	if($list[$i]['is_notice']) {
		$list[$i]['ca_name'] = $list[$i]['ca_name'] ? $list[$i]['ca_name'] : '공지';
	}

	$boIcon_hot[$i] = $list[$i]['icon_hot'] && !$list[$i]['is_notice'] ? '<i class="boIcon_hot"></i>' : ''; //인기글
	$boIcon_secret[$i] = $list[$i]['icon_secret'] ? '<i class="boIcon_secret"></i>' : ''; //비밀글

	//썸네일
	if($playVideo[$i]) {
		if($video_type[$i] == 'mp4') {
			if($img_thumb[$i]['src']) {
				$poster[$i] = 'poster="'.$img_thumb[$i]['src'].'"';
				$preload[$i] = 'preload="none"';
			} else {
				$Poster_is[$i] = 'no-poster';
			}
			$img[$i] = '<div class="video-container play-btn '.$Poster_is[$i].'">';
			$img[$i] .= '<video src="'.$list[$i]['wr_video'].'" '.$preload[$i].' '.$poster[$i].' class="video">﻿</video>';
			$img[$i] .= '</div>';
		} else if($video_type[$i] == 'youtube') {
			$img[$i] = '<div class="youtube-wrap">';
			if($img_thumb[$i]['src']) $img[$i] .= '<div class="video_thumb"><img src="'.$img_thumb[$i]['src'].'" alt="'.$list[$i]['wr_subject'].'"></div>';
			$img[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=2&showinfo=0&autoplay=0&modestbranding=1&rel=0&loop=0" allowfullscreen  frameborder="0" class="video" title="'.$list[$i]['wr_subject'].'"></iframe>';
			$img[$i] .= '</div>';
		} else if ($video_type[$i] == 'vimeo') {
			$img[$i] = '<div class="vimeo-wrap">';
			$img[$i] .= '<iframe src="https://player.vimeo.com/video/'.$list[$i]['wr_video'].'?autoplay=0" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" class="video" title="'.$list[$i]['wr_subject'].'"></iframe>';
			$img[$i] .= '</div>';
		}
	} else if($img_thumb[$i]['src']) {
		$img[$i] = '<img src="'.$img_thumb[$i]['src'].'" class="" alt="'.strip_tags($list[$i]['wr_subject']).'">';
	}
	
	//카테고리
	if($use_category && $list[$i]['ca_name']) $cate_link[$i] = '<a href="'.$list[$i]['ca_name_href'].'" class="cate_link" alt="'.$list[$i]['ca_name'].'">'.$list[$i]['ca_name'].'</a>';
	if($use_category && $list[$i]['ca_name']) $category[$i] = '<span class="category" alt="'.$list[$i]['ca_name'].'">'.$list[$i]['ca_name'].'</span>';
	
	//제목 여부
	$isSubject[$i] = !$list[$i]['subject'] || $titleSize == '0' || $list[$i]['wr_subject_hide'] ? false : true;
	$list[$i]['subject'] = nl2br($list[$i]['wr_subject']);

	//내용 여부
	if($list[$i]['wr_content'] == '&nbsp;') $list[$i]['wr_content'] = '';
	if($list[$i]['wr_content_mobile'] == '&nbsp;') $list[$i]['wr_content_mobile'] = '';
	$list[$i]['wr_content'] = G5_IS_MOBILE && $list[$i]['wr_content_mobile'] ? $list[$i]['wr_content_mobile'] : $list[$i]['wr_content'];
	if($noContent) $list[$i]['wr_content'] = ''; //$conLen == 0 이면 $noContent = true
	if($list[$i]['wr_short_con']) {
		$wr_content[$i] = nl2br($list[$i]['wr_short_con']);
	} else if($contents_html) {
		$wr_content[$i] = preg_replace("/<img[^>]+\>/i", "", $list[$i]['wr_content']); 
	} else if($list[$i]['wr_content']) {
		$conLen_default = G5_IS_MOBILE ? 60 : 100;
		$conLen = $conLen ? $conLen : $conLen_default;
		if($conLine) $conLen = 500;
		$wr_content[$i] = preg_replace("/<(.*?)\>/"," ",$list[$i]['wr_content']); 
		$wr_content[$i] = preg_replace("/&nbsp;/"," ",$wr_content[$i]); 
		$wr_content[$i] = str_replace("//##", " ", $wr_content[$i]);
		$wr_content[$i] = cut_str($wr_content[$i], $conLen, '…');
	} else {
		$wr_content[$i] = '';
	}
	$isContent[$i] = $conSize == '0' || !$wr_content[$i] ? false : true;

	//게시물정보

	$list_hit[$i] = $list[$i]['wr_link1'] && $list[$i]['wr_link_target'] != 'attach' ? $list[$i]['link_hit'][1] : $list[$i]['wr_hit']; //조회수
	$gall_list_infoSet[$i] = '';
	if($use_writer || $use_date || $use_hit || $use_good) {
		$gall_list_infoSet[$i] .= '<div class="gall_list_infoSet">';
		
		if($use_good) { //추가
			include_once(G5_LIB_PATH.'/my/get_my.lib.php');
			$good_href = './good.php?bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;good=good';
			$gall_list_infoSet[$i] .= '<div class="list_goodContainer">';
			$new_good_cnt[$i] = get_new_good_cnt($bo_table, $list[$i]['wr_id']);
			if($list[$i]['wr_good'] > 0) $gall_list_infoSet[$i] .= '<label class="label_good'.($new_good_cnt[$i] > 0?' new':'').'" data-tip="'.$list[$i]['wr_good'].'">';
			$gall_list_infoSet[$i] .= '<a href="'.$good_href.'&amp;'.$qstr.'" class="good_button" alt="좋아요">좋아요</a>';
			$gall_list_infoSet[$i] .= '</label>';
			$gall_list_infoSet[$i] .= '</div>';
		}

		if($use_writer) $gall_list_infoSet[$i] .= $list[$i]['writer'];
		if($use_date) $gall_list_infoSet[$i] .= passing_time($list[$i]['wr_datetime']);
		if($use_hit) $gall_list_infoSet[$i] .= '<span class="info_hit">조회수<sub class="num">'.$list_hit[$i].'</sub></span>';		
		$gall_list_infoSet[$i] .= '</div>';
	}

	//댓글 아이콘
	if($use_reply && $list[$i]['comment_cnt']) $icon_reply[$i] = '<span class="boIcon_reply'.($list[$i]['icon_comment']?' new':'').'">'.$list[$i]['comment_cnt'].'</span>';
	
	//갤러리 콘텐츠 여부
	$gall_con[$i] = $isSubject[$i] || $wr_content[$i] || $gall_list_infoSet ? true : false;
	
	//게시물 인크루드 파일여부
	$include_top_path[$i] = G5_HTML_PATH.'/'.$bo_table.'/section_'.$list[$i]['wr_id'].'_top.php';
	$include_path[$i] = G5_HTML_PATH.'/'.$bo_table.'/section_'.$list[$i]['wr_id'].'.php';
	$include_top[$i] = file_exists($include_top_path[$i]) ? 'section_'.$list[$i]['wr_id'].'_top.php' : false;
	$include[$i] = file_exists($include_path[$i]) ? 'section_'.$list[$i]['wr_id'].'.php' : false;
	
	// 첨부파일 여부
	$sql = " select *, substring_index(bf_source, '.', -1) ext from $g5[board_file_table] where bo_table = '". $bo_table. "' and wr_id = '". $list[$i]['wr_id'] ."' order by bf_no ";
	$result = sql_query($sql);
	$is_file_img[$i] = $is_file[$i] = false;
	while ($row = sql_fetch_array($result)) {
		if($row['ext'] == 'jpg' || $row['ext'] == 'png' || $row['ext'] == 'gif') {
			if($board['bo_view_thumb']) $is_file_img[$i] = true;
		} else {
			$is_file[$i] = true;
		}
	}
		
	//팝업 링크
	$popup_link[$i] = file_exists($latest_skin_url.'/ajax.view.skin.php') ? $latest_skin_url.'/ajax.view.skin.php?bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&popupOption='.$popupOption : G5_BBS_URL.'/my/ajax.view.skin.php?bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&popupOption='.$popupOption;
	
	// 게시물 링크
	$list[$i]['link_href'][1] = $list[$i]['wr_link1'] == '#' ? $list[$i]['wr_link1'] : $list[$i]['link_href'][1]; //링크값이 #일때
	if($list[$i]['wr_link1'] && $list[$i]['wr_link_target'] != 'attach') {
		if($list[$i]['wr_link_target'] == 'popup') {
			$wr_link_option[$i] = explode("|",$list[$i]['wr_link_option']);
			$a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '<a href="'.$list[$i]['link_href'][1].'" class="popWin link-icon-pop" data-width="'.$wr_link_option[$i][0].'" data-height="'.$wr_link_option[$i][1].'" data-top="'.$wr_link_option[$i][2].'" data-left="'.$wr_link_option[$i][3].'" alt="'.strip_tags($list[$i]['wr_subject']).' 바로가기">';
		} else if($list[$i]['wr_link_target'] == 'alert') {
			//$a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '<a href="javascript:alert(\''.$list[$i]['wr_link1'].'\');" class="link-icon-alert">';
			$a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '<a class="link-icon-alert pop-alert" data-text="'.$list[$i]['wr_link1'].'">';
		} else {
			$a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '<a href="'.$list[$i]['link_href'][1].'" target="'.$list[$i]['wr_link_target'].'" class="link-icon-out" alt="'.strip_tags($list[$i]['wr_subject']).' 바로가기">';
		}
	} else if($board['bo_layer_popup']) {
		$a_link[$i] = '<a href="'.get_layer_popup_url($list[$i]['href']).'" class="link-icon-layerpop popup-view" alt="'.strip_tags($list[$i]['wr_subject']).' 상세보기">';
		$a_link_txt[$i] = '<a href="'.get_layer_popup_url($list[$i]['href']).'" class="link-icon-layerpop popup-view-txt" id="'.$bo_table.'_'.$list[$i]['wr_id'].'" alt="'.strip_tags($list[$i]['wr_subject']).' 상세보기">';
		$a_link_img[$i] = '<a href="'.get_layer_popup_url($list[$i]['href']).'" class="link-icon-layerpop popup-view-img" alt="'.strip_tags($list[$i]['wr_subject']).' 상세보기">';
	} else {
		$a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '<a href="'.$list[$i]['href'].$nav_para.'" alt="'.strip_tags($list[$i]['wr_subject']).' 상세보기">';
	}
	if(!$list[$i]['wr_link1'] && !$is_file[$i] && !$is_file_img[$i] && !$list[$i]['wr_content'] && !$list[$i]['wr_video_src'] && !$include[$i] && !$skin_map) $a_link[$i] = $a_link_txt[$i] = $a_link_img[$i] = '';
	if($playVideo[$i]) $a_link_img[$i] = '';
	
	
	//버튼달기
	$list_btn_set[$i] = '';
	if($board['bo_use_btn'] && $use_list_btn) {
		for($b=1; $board['bo_use_btn'] && $b<=$board['bo_use_btn']; $b++) {
			$ex_btn[$b][$i] = explode("|",$list[$i]['wr_btn'.$b]);
			if($ex_btn[$b][$i][2] == 'alert') {
				$abtnOption[$i] = ' class="btnIcon-alert pop-alert" data-text="'.$ex_btn[$b][$i][1].'"';
			} else if($ex_btn[$b][$i][2] == 'popup') {
				$abtnOption[$i] = ' class="btnIcon-popwin popWin a_'.$list[$i]['wr_id'].'_'.$b.'" data-width="'.$ex_btn[$b][$i][3].'" data-height="'.$ex_btn[$b][$i][4].'" data-top="0" data-left="0" ';
			} else if($ex_btn[$b][$i][2] == 'layerpopup') {
				$abtnOption[$i] = ' class="btnIcon-layerpop popup-view a_'.$list[$i]['wr_id'].'_'.$b.'"';
				$ex_btn[$b][$i][1] = explode("?",$ex_btn[$b][$i][1]);
				$ex_btn[$b][$i][1] = G5_BBS_URL.'/my/ajax.view.skin.php?'.$ex_btn[$b][$i][1][1];
			} else {
				if($ex_btn[$b][$i][2] == '_blank') {
					$abtnOption[$i] = ' class="btnIcon-link a_'.$list[$i]['wr_id'].'_'.$b.'" target="_blank"';
				} else if($ex_btn[$b][$i][2] == 'down') {
					$abtnOption[$i] = ' class="btnIcon-download a_'.$list[$i]['wr_id'].'_'.$b.'"';
				} else {
					$abtnOption[$i] = ' class="btnIcon-link a_'.$list[$i]['wr_id'].'_'.$b.'"';
				}
			}
			$wr_btn_href[$i] = $ex_btn[$b][$i][2] == 'alert' ? '' : ' href="'.$ex_btn[$b][$i][1].'" ';
			if($list[$i]['wr_btn'.$b] && $ex_btn[$b][$i][1]) $list_btn_set[$i] .= '<a'.$wr_btn_href[$i].$abtnOption[$i].'>'.$ex_btn[$b][$i][0].'</a>';

			$btn_color[$b][$i] = explode("|",$list[$i]['wr_btn'.$b.'_color']);
			if($btn_color[$b][$i][0]) $boStyle .= '.list-btn-set a.a_'.$list[$i]['wr_id'].'_'.$b.'{background:'.$btn_color[$b][$i][0].' !important;color:#fff !important;}';
			if($btn_color[$b][$i][1]) $boStyle .= '.list-btn-set a.a_'.$list[$i]['wr_id'].'_'.$b.':hover{background:'.$btn_color[$b][$i][1].' !important;}';
		}
		$list_btn_set[$i] = $list_btn_set[$i] ? '<div class="list-btn-set">'.$list_btn_set[$i].'</div>' : '';
	}
	
	//게시물별 태그목록
	$list_tag_set[$i] = '';
	if($list[$i]['wr_tag'] && $use_tag) {
		$list_tag[$i] = explode(",", $list[$i]['wr_tag']);
		$list_tag_set[$i] .= '<div class="tagSet">';
		for ($t=0; $t<count($list_tag[$i]); $t++) {
			$tag_name = trim($list_tag[$i][$t]);
			if($tag_name=='') continue;			
			$list_tag_set[$i] .= '<a href="'.(get_pretty_url($bo_table,'','tag='.urlencode($tag_name))).'" class="tag';
			if($tag == $tag_name) $list_tag_set[$i] .= ' active';
			$list_tag_set[$i] .= '">'.$tag_name.'</a>';
		}
		$list_tag_set[$i] .= '</div>';
	}

	
	//옵션 - 이미지만 보이기
	if($imgOnly) $gall_con[$i] = $list_btn_set[$i] = $list_tag_set[$i] = false;
	
}


if($latestStyle && $blockName) echo '<style name="'.$blockName.'">'.$latestStyle.'</style>';