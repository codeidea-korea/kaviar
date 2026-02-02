<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/my/boCategory.lib.php');
include_once(G5_LIB_PATH.'/my/boSearch.lib.php');

if($is_admin && !G5_IS_MOBILE && bo_write_cnt($bo_table) > 0) {
	$popSca = $sca ? '&sca='.urlencode($sca) : '';
	$list_bundle_form = '<a href="'.G5_BBS_URL.'/my/_adm/?pn=_list_bundle&bo_table='.$bo_table.$popSca.'&title='.(strpos($board['bo_skin'], 'pageMake') !== false?'블록':'게시물').' 순서 편집" class="list_bundle popWin inline-fixed fixed-top" data-width="1150" data-height="750" data-top="0" data-left="0" title="순서편집">순서편집</a>';
}

$category_menu = $is_category && !$bo_viewpage ? true : false; //상세페이지에서 목록출력시 카테고리 제외

if($bo_viewpage) { //상세페이지 목록보기 사용시
	$is_bo_title = false;
	$bo_use_searchbar = false;
	$write_pages = false;
	$list_href = $is_checkbox = $write_href = $board['bo_use_write_btn']  = false;
}



/*────────────────────────────────────────────────────────────────
										리스트 썸네일 사이즈 구하기 (비율)
─────────────────────────────────────────────────────────────────*/
$gutter = G5_IS_MOBILE ? $board['bo_gall_mobile_itemspace'] : $board['bo_gall_itemspace']; //리스트 간격
if(G5_IS_MOBILE) {
	$bo_table_width = $is_tablet ? 1200 : 700;
} else {
	$bo_table_width = $board['bo_table_width'];
	if($bo_table_width <= '100') $bo_table_width = $board['bo_table_width'] * 20;
}
$bo_gallery_width = G5_IS_MOBILE ? $board['bo_mobile_gallery_width'] : $board['bo_gallery_width'];
$bo_gallery_height = G5_IS_MOBILE ? $board['bo_mobile_gallery_height'] : $board['bo_gallery_height'];

//기본 썸네일 사이즈
$thumbWidth = (int)(($bo_table_width - $gutter * ($bo_gallery_cols -1)) / $bo_gallery_cols);
$thumbHeight = (int)(($thumbWidth / $bo_gallery_width) * $bo_gallery_height);

//스킨별 썸네일 설정 채크
@include_once($board_pcskin_path.'/list.head.skin.php');

$_grid = $autoSize === 'grid' ? true : false;
$_masonry = $autoSize === 'masonry' ? true : false;
$_webzine = $autoSize === 'webzine' ? true : false;

//썸네일 사이즈
if($autoThumb) {
	$thumbWidth = $thumb_width ? $thumb_width : $thumbWidth;
	$thumbHeight = $thumb_height ? $thumb_height : $thumbHeight;
	
	for ($i=0; $i<count($list); $i++) {		
		$playVideo[$i] = $list[$i]['wr_video'] && $list[$i]['wr_video_play'] ? true : false; //목록에서 재생 비디오
		if($playVideo[$i]) { //비디오 타입 채크
			if(strpos($list[$i]['wr_video_src'], 'youtu') !== false) {
				$video_type[$i] = 'youtube';
			} else if(strpos($list[$i]['wr_video_src'], 'vimeo') !== false) {
				$video_type[$i] = 'vimeo';
			} else if($list[$i]['wr_video_src']) {
				$video_type[$i] = 'mp4';
			}
		}
		$new_thumbWidth[$i] = $new_thumb_width[$i] ? $new_thumb_width[$i] : $thumbWidth;
		$new_thumbHeight[$i] = $new_thumb_height[$i] ? $new_thumb_height[$i] : $thumbHeight;
		if($video_type[$i] == 'mp4' || $_masonry || $_grid) $new_thumbHeight[$i] = 0;
		
		/*if($_grid) {
			if($list[$i]['wr_grid']=='grid_4x2') $new_thumbWidth[$i] = 1300;
			if($list[$i]['wr_grid']=='grid_3x1' || $list[$i]['wr_grid']=='grid_3x2' || $list[$i]['wr_grid']=='grid_3x3' || $list[$i]['wr_grid']=='grid_3x4') $new_thumbWidth[$i] = 1200;
			if($list[$i]['wr_grid']=='grid_2x2' || $list[$i]['wr_grid']=='grid_2x3' || $list[$i]['wr_grid']=='grid_2x4') $new_thumbWidth[$i] = 760;
			if($list[$i]['wr_grid']=='grid_1x1' || $list[$i]['wr_grid']=='grid_1x2' || $list[$i]['wr_grid']=='grid_1x3' || $list[$i]['wr_grid']=='grid_1x4') $new_thumbWidth[$i] = 620;
		}*/

		$img_thumb[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $new_thumbWidth[$i], $new_thumbHeight[$i], false, true);
		$img_thumb_mob[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], $new_thumbWidth[$i], $new_thumbHeight[$i], false, true, 'center', false, '80/0.5/3', 1, false);
		if(G5_IS_MOBILE) $img_thumb[$i] = $img_thumb_mob[$i]['src'] ? $img_thumb_mob[$i] : $img_thumb[$i];
	}

	//비디오 플레이 버튼 사이즈
	/*$video_btn_size = $thumbWidth / 13;
	if($board['bo_table_width'] == '100') $video_btn_size = $thumbWidth / 21;
	$video_btn_size = $video_btn_size < 18 ? '18' : $video_btn_size; //최소사이즈 지정
	$video_btn_size = $video_btn_size > 36 ? '36' : $video_btn_size; //최대사이즈 지정
	$youtube_height = (int)($thumbWidth * 480 / 850);
	$boStyle .= '.gall_li .youtube-wrap .video{height:'.$youtube_height.'px;}'.PHP_EOL;*/
}

//자동사이즈
if($autoSize && !$_grid) { 

	//썸네일 비율(이미지없이 썸네일비율로 박스만들기)
	$imgRatio = $bo_gallery_height / $bo_gallery_width * 100;
	$imgRatio_mob = $board['bo_mobile_gallery_height'] / $board['bo_mobile_gallery_width'] * 100;
	if($imgRatio == 0) $imgRatio = 60;
	$boStyle .= '.thumb-noimg:before{padding-top:'.$imgRatio.'%;}'.PHP_EOL;
	$boStyle .= '.thumb-noimg.mob:before{padding-top:'.$imgRatio_mob.'%;}'.PHP_EOL;

	//반응형 갤러리 목록수 감소
	if($board['bo_max_screen']) {
		$bo_max_screen = explode('|', $board['bo_max_screen']);
		$bo_min_screen = $bo_max_screen[0] + 1;
	}
	
	if($board['bo_max_screen'] && $bo_gallery_cols > 1 && !G5_IS_MOBILE) $boStyle .= '@media screen and (min-width:'.$bo_min_screen.'px) {'.PHP_EOL;
	$boStyle .= '#'.$bo_table.' .gall_ul{--gall-cols:'.$bo_gallery_cols.';--gall-gap:'.$gutter.'px;}';
	if($_masonry) $boStyle .= '#'.$bo_table.' .gall_ul .gall_li:nth-child(-n+'.$bo_gallery_cols.'){margin-top:0 !important}';
	if($_webzine) {
		$boStyle .= '#'.$bo_table.' .gall_ul .gall_li:nth-child(-n+'.$bo_gallery_cols.'){border-top-width:1px;}';
		if($bo_gallery_cols > 2) {
			$boStyle .= '#'.$bo_table.' .wzContents{display:block;}'.PHP_EOL;
			$boStyle .= '#'.$bo_table.' .wzContents .wz_thumb{float:left;max-width:36%;margin-right:15px;margin-bottom:10px;}'.PHP_EOL;
			$boStyle .= '#'.$bo_table.' .wzContents .wz_con{display:inline;}'.PHP_EOL;
			$boStyle .= '#'.$bo_table.' .wzContents .textSubject{margin-bottom:10px;}'.PHP_EOL;
			$boStyle .= '#'.$bo_table.' .wzContents .list-btn-set{width:100%;margin-top:20px;}'.PHP_EOL;
		}
	}
	if($board['bo_max_screen'] && $bo_gallery_cols > 1 && !G5_IS_MOBILE) $boStyle .= '}'.PHP_EOL;

	//반응형 | 구분만큼 반복
	if($board['bo_max_screen'] && $bo_gallery_cols > 1 && !G5_IS_MOBILE) {
		for ($s=0; $s<count($bo_max_screen); $s++) {
			$n = $s+1;
			$maxScreen = trim($bo_max_screen[$s]);
			$minScreen = trim($bo_max_screen[$n]);
			if ($maxScreen=='') continue;
			$new_gallery_cols = $bo_gallery_cols - $n;
			$boStyle .= '@media screen and ';
			if($minScreen) $boStyle .= '(min-width:'.$minScreen.'px) and ';
			$boStyle .= '(max-width:'.$maxScreen.'px) {'.PHP_EOL;
			$boStyle .= '#'.$bo_table.' .gall_ul{--gall-cols:'.$new_gallery_cols.';--gall-gap:'.$gutter.'px;}';
			if($_masonry) $boStyle .= '#'.$bo_table.' .gall_ul .gall_li:nth-child(-n+'.$new_gallery_cols.'){margin-top:0 !important}';
			if($_webzine) {
				$boStyle .= '#'.$bo_table.' .gall_ul .gall_li:nth-child(-n+'.$new_gallery_cols.'){border-top-width:1px;}';
				if($new_gallery_cols > 1) {
					$boStyle .= '#'.$bo_table.' .wzContents{display:block;}'.PHP_EOL;
					$boStyle .= '#'.$bo_table.' .wzContents .wz_thumb{float:left;max-width:36%;margin-right:15px;margin-bottom:10px;}'.PHP_EOL;
					$boStyle .= '#'.$bo_table.' .wzContents .wz_con{display:inline;}'.PHP_EOL;
					$boStyle .= '#'.$bo_table.' .wzContents .textSubject{margin-bottom:10px;}'.PHP_EOL;
					$boStyle .= '#'.$bo_table.' .wzContents .list-btn-set{width:100%;margin-top:20px;}'.PHP_EOL;
				}
			}
			$boStyle .= '}'.PHP_EOL;
		}
	}

} else if($_grid) {
	$boStyle .= '#'.$bo_table.' .block_auto_gall .auto_ul{gap:'.$gutter.'px;}'.PHP_EOL;


}//-- end ($autoSize)



for ($i=0; $i<count($list); $i++) {

	if($list[$i]['is_notice']) {
		$list[$i]['ca_name'] = $list[$i]['ca_name'] ? $list[$i]['ca_name'] : '공지';
	}
	$is_now[$i] = ($wr_id == $list[$i]['wr_id']) ? 'is_now' : ''; //열람중
	$bo_current[$i] = $wr_id == $list[$i]['wr_id'] ? '<span class="bo_current sound_only">열람중</span>' : '<span class="sound_only">'.$list[$i]['num'].'</span>';
	
	if($is_checkbox) {
		$gall_li_checkbox[$i] = '<label class="labelCheck edit-mode"><input type="checkbox" name="chk_wr_id[]" value="'.$list[$i]['wr_id'].'" id="chk_wr_id_'.$i.'"><i class="sound_only">'.$list[$i]['subject'].'</i></label>';
		$table_td_checkbox[$i] = '<td class="td_chk edit-mode"><label class="labelCheck"><input type="checkbox" name="chk_wr_id[]" value="'.$list[$i]['wr_id'].'" id="chk_wr_id_'.$i.'"><i class="sound_only">'.$list[$i]['subject'].'</i></label></td>';
	}
	
	if($list[$i]['wr_use'] && $is_admin) $icon_use[$i] = '<span class="boIcon_use_'.$list[$i]['wr_use'].'"></span>'; //사용유무
	
	$btnEdit_class[$i] = $list[$i]['wr_use'] == 'none' ? ' admin':''; //수정버튼 차별표기

	//썸네일
	if($playVideo[$i]) {
		if($video_type[$i] == 'mp4') {
			if($img_thumb[$i]['src']) {
				$poster[$i] = 'poster="'.$img_thumb[$i]['src'].'"';
				$preload[$i] = 'preload="none"';
			} else {
				$Poster_is[$i] = 'no-poster';
			}
			if( !preg_match('/http(s?)\:\/\//i', $list[$i]['wr_video']) ) $list[$i]['wr_video'] = G5_URL.$list[$i]['wr_video'];
			$img[$i] = '<div class="video-container play-btn '.$Poster_is[$i].'">';
			$img[$i] .= '<video src="'.$list[$i]['wr_video'].'" '.$preload[$i].' '.$poster[$i].' class="video">﻿</video>';
			$img[$i] .= '</div>';
		} else if($video_type[$i] == 'youtube') {
			$img[$i] = '<div class="youtube-wrap">';
			if($img_thumb[$i]['src']) $img[$i] .= '<div class="video_thumb"><img src="'.$img_thumb[$i]['src'].'" alt="'.strip_tags($list[$i]['wr_subject']).'"></div>';
			$img[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=2&showinfo=0&autoplay=0&modestbranding=1" allowfullscreen  frameborder="0" class="video" title="'.$list[$i]['wr_subject'].'"></iframe>';
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
	if($is_category && $list[$i]['ca_name']) $cate_link[$i] = '<a href="'.$list[$i]['ca_name_href'].'" class="cate_link" alt="'.$list[$i]['ca_name'].'">'.$list[$i]['ca_name'].'</a>';
	if($is_category && $list[$i]['ca_name']) $category[$i] = '<span class="category" alt="'.$list[$i]['ca_name'].'">'.$list[$i]['ca_name'].'</span>';
	
	//제목
	$isSubject[$i] = !$list[$i]['subject'] || $titleSize == '0' || $list[$i]['wr_subject_hide'] ? false : true;
	if(!$board['bo_subject_len']) $list[$i]['subject'] = nl2br($list[$i]['wr_subject']);
	if($titleEllipsis) $list[$i]['subject'] = $list[$i]['wr_subject'];
	if(isset($list[$i]['icon_secret']) && $list[$i]['icon_secret'] && !$is_admin) $list[$i]['subject'] = '<span class="color-gray">비밀글 입니다.</span>';

	//내용 여부	
	if($list[$i]['wr_content'] == '&nbsp;') $list[$i]['wr_content'] = '';
	if($list[$i]['wr_content_mobile'] == '&nbsp;') $list[$i]['wr_content_mobile'] = '';
	$list[$i]['wr_content'] = G5_IS_MOBILE && $list[$i]['wr_content_mobile'] ? $list[$i]['wr_content_mobile'] : $list[$i]['wr_content'];
	if($list[$i]['wr_short_con']) {
		$wr_content[$i] = nl2br($list[$i]['wr_short_con']);
	} else if($contents_html) {
		$wr_content[$i] = preg_replace("/<img[^>]+\>/i", "", $list[$i]['wr_content']); 
	} else if($list[$i]['wr_content']) {
		if($board['bo_skin']=='gallery-webzine' && $bo_gallery_cols < 3) {
			if($bo_gallery_cols == 1) {
				$conLen_default = G5_IS_MOBILE ? 250 : 470;
			} else if($bo_gallery_cols == 2) {
				$conLen_default = G5_IS_MOBILE ? 150 : 180;
			}
		} else {
			$conLen_default = G5_IS_MOBILE ? 100 : 100;
		}
		$conLen = $conLen ? $conLen : $conLen_default;
		if($conLine) $conLen = 500;
		$wr_content[$i] = preg_replace("/<(.*?)\>/"," ",$list[$i]['wr_content']); 
		$wr_content[$i] = preg_replace("/&nbsp;/"," ",$wr_content[$i]); 
		$wr_content[$i] = str_replace("//##", " ", $wr_content[$i]);
		//$wr_content[$i] = cut_str(get_text($wr_content[$i]), $conLen, '…'); //특수기호...
		$wr_content[$i] = cut_str($wr_content[$i], $conLen, '…');
	} else {
		$wr_content[$i] = '';
	}

	$isContent[$i] = $conSize == '0' || !$wr_content[$i] ? false : true;
	//에디터없이 등록한 글을 목록에서 줄바꿈 적용
	$html = 0;
	if(strstr($list[$i]['wr_option'], 'html1')) $html = 1;
	if(strstr($list[$i]['wr_option'], 'html2')) $html = 2;
	$list[$i]['content'] = conv_content($list[$i]['wr_content'], $html);
	

	//게시물정보
	$list_hit[$i] = $list[$i]['wr_link1'] && $list[$i]['wr_link_target'] != 'attach' ? $list[$i]['link_hit'][1] : $list[$i]['wr_hit']; //조회수
	$gall_list_infoSet[$i] = '';
	if($bo_writer || $bo_date || $bo_hit || $is_good) {
		$gall_list_infoSet[$i] .= '<div class="gall_list_infoSet">';	
		if($is_good) { //추가
			include_once(G5_LIB_PATH.'/my/get_my.lib.php');
			$good_href = './good.php?bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;good=good';
			$gall_list_infoSet[$i] .= '<div class="list_goodContainer">';
			$new_good_cnt[$i] = get_new_good_cnt($bo_table, $list[$i]['wr_id']);
			if($list[$i]['wr_good'] > 0) $gall_list_infoSet[$i] .= '<label class="label_good'.($new_good_cnt[$i] > 0?' new':'').'" data-tip="'.$list[$i]['wr_good'].'">';
			$gall_list_infoSet[$i] .= '<a href="'.$good_href.'&amp;'.$qstr.'" class="good_button" alt="좋아요">좋아요</a>';
			$gall_list_infoSet[$i] .= '</label>';
			$gall_list_infoSet[$i] .= '</div>';
		}
		if($bo_writer) $gall_list_infoSet[$i] .= $list[$i]['writer'];
		if($bo_date) $gall_list_infoSet[$i] .= passing_time($list[$i]['wr_datetime']);
		if($bo_hit) $gall_list_infoSet[$i] .= '<span class="info_hit">'.(G5_IS_MOBILE?'<span class="sound_only">조회수</span>':'조회수').'<sub class="num">'.$list_hit[$i].'</sub></span>';		
		$gall_list_infoSet[$i] .= '</div>';

		if(G5_IS_MOBILE) {
			$list_infoSet[$i] = '<div class="list_infoSet">'; //<- mobile : 기본list		
			if($is_good) {
				$list_infoSet[$i] .= '<div class="list_goodContainer">';
				$new_good_cnt[$i] = get_new_good_cnt($bo_table, $list[$i]['wr_id']);
				if($list[$i]['wr_good'] > 0) $list_infoSet[$i] .= '<label class="label_good'.($new_good_cnt[$i] > 0?' new':'').'" data-tip="'.$list[$i]['wr_good'].'">';
				$list_infoSet[$i] .= '<a href="'.$good_href.'&amp;'.$qstr.'" class="good_button" alt="좋아요">좋아요</a>';
				$list_infoSet[$i] .= '</label>';
				$list_infoSet[$i] .= '</div>';
			}
			if($bo_writer) $list_infoSet[$i] .= $list[$i]['writer'];
			if($bo_date) $list_infoSet[$i] .= passing_time($list[$i]['wr_datetime']);
			if($bo_hit) $list_infoSet[$i] .= '<span class="info_hit"><span class="sound_only">조회수</span><sub class="num">'.$list_hit[$i].'</sub></span>';		
			$list_infoSet[$i] .= '</div>';
		}
	}

	//댓글 아이콘
	if($bo_reply && $list[$i]['comment_cnt']) $icon_reply[$i] = '<span class="boIcon_reply'.($list[$i]['icon_comment']?' new':'').'">'.$list[$i]['comment_cnt'].'</span>';
	
	//갤러리 콘텐츠 여부
	$gall_con[$i] = $isSubject[$i] || $wr_content[$i] || $gall_list_infoSet ? true : false;
	
	//게시물 인크루드 파일여부
	$include_top_path[$i] = G5_HTML_PATH.'/'.$bo_table.'/section_'.$list[$i]['wr_id'].'_top.php';
	$include_path[$i] = G5_HTML_PATH.'/'.$bo_table.'/section_'.$list[$i]['wr_id'].'.php';
	$include_top[$i] = file_exists($include_top_path[$i]) ? 'section_'.$list[$i]['wr_id'].'_top.php' : false;
	$include[$i] = file_exists($include_path[$i]) ? 'section_'.$list[$i]['wr_id'].'.php' : false;
	$includeOn[$i] = $include_top[$i] || $include[$i] ? 'includeOn' : '';
	
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
	for($b=1; $b<=6; $b++) {
		$ex_btn[$b][$i] = explode("|",$list[$i]['wr_btn'.$b]);
		$btn_color[$b][$i] = explode("|",$list[$i]['wr_btn'.$b.'_color']);
		if($ex_btn[$b][$i][2] == 'alert') {
			$abtnOption[$i] = ' class="btnIcon-alert pop-alert'.(!$btn_color[$b][$i][0]?' default':'').'" data-text="'.$ex_btn[$b][$i][1].'"';
		} else if($ex_btn[$b][$i][2] == 'popup') {
			$abtnOption[$i] = ' class="btnIcon-popwin popWin a_'.$list[$i]['wr_id'].'_'.$b.''.(!$btn_color[$b][$i][0]?' default':'').'" data-width="'.$ex_btn[$b][$i][3].'" data-height="'.$ex_btn[$b][$i][4].'" data-top="0" data-left="0" ';
		} else if($ex_btn[$b][$i][2] == 'layerpopup') {
			$abtnOption[$i] = ' class="btnIcon-layerpop popup-view a_'.$list[$i]['wr_id'].'_'.$b.''.(!$btn_color[$b][$i][0]?' default':'').'"';
			$ex_btn[$b][$i][1] = explode("?",$ex_btn[$b][$i][1]);
			$ex_btn[$b][$i][1] = G5_BBS_URL.'/my/ajax.view.skin.php?'.$ex_btn[$b][$i][1][1];
		} else {
			if($ex_btn[$b][$i][2] == '_blank') {
				$abtnOption[$i] = ' class="btnIcon-link a_'.$list[$i]['wr_id'].'_'.$b.''.(!$btn_color[$b][$i][0]?' default':'').'" target="_blank"';
			} else if($ex_btn[$b][$i][2] == 'down') {
				$abtnOption[$i] = ' class="btnIcon-download a_'.$list[$i]['wr_id'].'_'.$b.''.(!$btn_color[$b][$i][0]?' default':'').'"';
			} else {
				$abtnOption[$i] = ' class="btnIcon-link a_'.$list[$i]['wr_id'].'_'.$b.''.(!$btn_color[$b][$i][0]?' default':'').'"';
			}
		}
		$wr_btn_href[$i] = $ex_btn[$b][$i][2] == 'alert' ? '' : ' href="'.$ex_btn[$b][$i][1].'" ';
		if($list[$i]['wr_btn'.$b] && $ex_btn[$b][$i][1]) $list_btn_set[$i] .= '<a'.$wr_btn_href[$i].$abtnOption[$i].'>'.$ex_btn[$b][$i][0].'</a>';

		
		if($btn_color[$b][$i][0]) $boStyle .= '.list-btn-set a.a_'.$list[$i]['wr_id'].'_'.$b.'{background:'.$btn_color[$b][$i][0].' !important;color:'.($btn_color[$b][$i][0]=='rgba(255, 255, 255, 1)'?'#000':'#fff').' !important;}';
		if($btn_color[$b][$i][1]) $boStyle .= '.list-btn-set a.a_'.$list[$i]['wr_id'].'_'.$b.':hover{background:'.$btn_color[$b][$i][1].' !important;}';
	}
	$list_btn_set[$i] = $list_btn_set[$i] ? '<div class="list-btn-set'.($skin_pagemake?'':' row-2 sm:row-1').'">'.$list_btn_set[$i].'</div>' : '';
	
	
	//게시물별 태그목록
	$list_tag_set[$i] = '';
	if($list[$i]['wr_tag']) {
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

	//게시물 수정,삭제
	$edit_href[$i] = '';
	if(($member['mb_id'] && ($member['mb_id'] == $list[$i]['mb_id'])) || $is_admin) { //로그인중이고 자신의 글이라면
		$edit_href[$i] = G5_BBS_URL.'/write.php?w=u&bo_table='.$bo_table.'&wr_id='.$list[$i]['wr_id'].'&page='.$page.$qstr.$nav_para;
		set_session('ss_delete_token', $token = uniqid(time()));
		$delete_href[$i] = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;token='.$token.'&amp;page='.$page.urldecode($qstr);
	} else if (!$write['mb_id'] && $member['mb_id'] == $list[$i]['mb_id'] && $is_admin) { //회원이 쓴 글이 아니라면
		$edit_href[$i] = G5_BBS_URL.'/password.php?w=u&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;page='.$page.$qstr;
		$delete_href[$i] = G5_BBS_URL.'/password.php?w=d&amp;bo_table='.$bo_table.'&amp;wr_id='.$list[$i]['wr_id'].'&amp;page='.$page.$qstr;
	}

	if(G5_IS_MOBILE && $theme_type != 'shop') $is_now[$i] = $bo_current[$i] = $gall_li_checkbox[$i] = $order_num[$i] = $edit_href[$i] = ''; //pc스킨을 모바일에서도 공통사용할 경우 대비..


	/*─────────────────────────────────────────────────
									목록 아이콘
	─────────────────────────────────────────────────*/
	$boIcon_secret[$i] = $list[$i]['icon_secret'] && !$list[$i]['is_notice'] ? '<i class="boIcon_secret"></i>' : ''; //비밀글
	$boIcon_hot[$i] = $list[$i]['icon_hot'] && !$list[$i]['is_notice'] ? '<i class="boIcon_hot"></i>' : ''; //인기글	
	$boIcon_file[$i] = $is_file[$i] ? '<i class="boIcon_file"></i>' : ''; //첨부파일
	$boIcon_img[$i] = $is_file_img[$i] ? '<i class="boIcon_img"></i>' : ''; //이미지
	$boIcon_video[$i] = $list[$i]['wr_video_src'] ? '<i class="boIcon_video"></i>' : ''; //동영상
	$boIcon_attach[$i] = $list[$i]['wr_link1'] && $list[$i]['wr_link_target'] == 'attach' ? '<i class="boIcon_attach"></i>' : ''; //첨부링크
	$boIcon_new[$i] = isset($list[$i]['icon_new']) && $list[$i]['icon_new'] ? '<i class="boIcon_new"></i>' : ''; //새글
	if($boIcon_secret[$i] && !$is_admin) $boIcon_hot[$i] = $boIcon_file[$i] = $boIcon_img[$i] = $boIcon_video[$i] = $boIcon_attach[$i] = '';
	
}






/*▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣*/

include_once(G5_BBS_PATH.'/my/skinOption/skin.option.style.php'); //스킨 옵션 스타일

if($boStyle) echo '<style name="boStyle">'.$boStyle.'</style>'; //게시판 스타일

if($bo_top_img) include_once('./my/bo_top_img.php'); //상단이미지

if($is_boTop) { //상단 인크루드
	echo '<div class="bo_top">';
	include_once($boTopPATH);
	echo '</div>';
}

echo '<div id="'.$bo_table.'" class="boWrap '.$boSkin.(G5_IS_MOBILE&&!$board['bo_mobile_padding']?' nopadding':'').'" data-option="'.$bo_skinOption.'">';

//모바일 스킨이 없으면 모바일에서도 pc용 스킨 사용.
if(file_exists($board_skin_path.'/list.skin.php')) {
	include_once($board_skin_path.'/list.skin.php');
} else {
	include_once($board_pcskin_path.'/list.skin.php');
}

echo '</div>'; // end - boWrap

if($is_boBottom) { //하단 인크루드
	echo '<div class="bo_bottom">';
	include_once($boBottomPATH);
	echo '</div>';
}


//레이어팝업 댓글 등록시 댓글 등록 후 해당 팝업 다시 열기
//$pop_id = $_GET['pop_id'];
//if($pop_id) $myScript .= '$(document).ready(function(){ $("#'.$bo_table.'_'.$pop_id.'").click(); });';