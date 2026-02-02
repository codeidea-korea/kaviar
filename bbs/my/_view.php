<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$isSubject = $view['wr_subject_hide'] ? false : true;
$isContent = $view['wr_content'] && $view['wr_content'] != '&nbsp;' ? $view['wr_content'] : '';

//슬라이드 보기일때 에디터 이미지만 추출
$editor_img_src = get_editor_image($view['wr_content'], false);
$list_img = $editor_img_src[1];
$is_editor_img = count($list_img) > 0 ? true : false;
$wr_use_slideview = $view['wr_use_slideview'] && $is_editor_img ? true : false;
for($i=0; $i<count($list_img); $i++) {
	$p = @parse_url($list_img[$i]);
	if(strpos($p['path'], "/data/") != 0) {
		$data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
	 } else {
		$data_path = $p['path'];
	 }
	 $editor_img[$i] = '<img src="'.$list_img[$i].'" alt="첨부 이미지">';
}

//비디오 타입 채크
if(strpos($view['wr_video_src'], 'youtu') !== false) {
	$video_type = 'youtube';
} else if(strpos($view['wr_video_src'], 'vimeo') !== false) {
	$video_type = 'vimeo';
} else if($view['wr_video_src']) {
	$video_type = 'mp4';
}

//첨부파일 다운로드
$cnt = 0;
if ($view['file']['count']) {
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
			$cnt++;
	}
}
$fileDownload = '';
if($cnt) {
	$fileDownload .= '<section id="bo_v_file">';
	$fileDownload .= '<span class="fileOpener">첨부파일'.($cnt>1?' <span class="cnt">'.$cnt.'</span>':'').'</span>';
	$fileDownload .= '<ul class="file_ul">';
	for ($i=0; $i<count($view['file']); $i++) {
		if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
			$fileDownload .= '<li>';
			$fileDownload .= '<a href="'.$view['file'][$i]['href'].'" alt="'.cut_str($view['file'][$i]['source'], 40, '…').' 다운로드">'.cut_str($view['file'][$i]['source'], 40, '…').'</a>';
			$fileDownload .= '<span class="fileSize">'.$view['file'][$i]['content'].'('.$view['file'][$i]['size'].')</span>';
			$fileDownload .= '</li>';
		}
	}
	$fileDownload .= '</ul>';
	$fileDownload .= '</section>';
}

//첨부된 링크
$bo_v_linkSet = '';
if(isset($view['link'][1]) && $view['link'][1] && $view['wr_link_target'] == 'attach') {
	$bo_v_linkSet .= '<section id="bo_v_linkSet">';
	$bo_v_linkSet .= '<ul>';
	$cnt = 0;
	for ($i=1; $i<=count($view['link']); $i++) {
		if($view['link'][$i]) {
			$cnt++;
			$bo_v_linkSet .= '<li>';
			if($view['wr_link_name']) $bo_v_linkSet .= '<span class="linkname">'.$view['wr_link_name'].'</span>';
			$bo_v_linkSet .= '<a href="'.$view['link_href'][$i].'" target="_blank" alt="링크 바로가기">'.cut_str($view['link'][$i], 80).'</a>';
			$bo_v_linkSet .= '</li>';
		}
	}
	$bo_v_linkSet .= '</ul>';
	$bo_v_linkSet .= '</section>';
}

//버튼달기
$view_btn_set = '';
if($board['bo_use_btn']) {		
	$view_btn_set .= '<div id="view-btn-set" class="list-btn-set sm:row-2">';
	for($b=1; $board['bo_use_btn'] && $b<=$board['bo_use_btn']; $b++) {
		$view_btn[$b] = explode("|",$view['wr_btn'.$b]);
		if($view_btn[$b][2] == 'alert') {
			$abtnOption = ' class="btnIcon-alert pop-alert" data-text="'.$view_btn[$b][1].'"';
		} else if($view_btn[$b][2] == 'popup') {
			$abtnOption = ' class="btnIcon-popwin popWin a_'.$wr_id.'_'.$b.'" data-width="'.$view_btn[$b][3].'" data-height="'.$view_btn[$b][4].'" data-top="0" data-left="0" ';
		} else if($view_btn[$b][2] == 'layerpopup') {
				$abtnOption = 'class="btnIcon-layerpop popup-view a_'.$wr_id.'_'.$b.'" ';
				$view_btn[$b][1] = explode("?",$view_btn[$b][1]);
				$view_btn[$b][1] = G5_BBS_URL.'/my/ajax.view.skin.php?'.$ex_btn[$b][1][1];
		} else {
			if($view_btn[$b][2] == '_blank') {
				$abtnOption = ' class="btnIcon-link a_'.$wr_id.'_'.$b.'" target="_blank"';
			} else if($view_btn[$b][2] == 'down') {
				$abtnOption = ' class="btnIcon-download a_'.$wr_id.'_'.$b.'"';
			} else {
				$abtnOption = ' class="btnIcon-link a_'.$wr_id.'_'.$b.'"';
			}
		}
		$wr_btn_href = $view_btn[$b][2] == 'alert' ? '' : ' href="'.$view_btn[$b][1].'" ';
		if($view_btn[$b][0] && $view_btn[$b][1]) $view_btn_set .= '<a'.$wr_btn_href.$abtnOption.'>'.$view_btn[$b][0].'</a>';

		$btn_color[$b] = explode("|",$view['wr_btn'.$b.'_color']);
		if($btn_color[$b][0]) $boStyle .= '#view-btn-set a.a_'.$wr_id.'_'.$b.'{background:'.$btn_color[$b][0].';}';
		if($btn_color[$b][1]) $boStyle .= '#view-btn-set a.a_'.$wr_id.'_'.$b.':hover{background:'.$btn_color[$b][1].';}';
	}
	$view_btn_set .= '</div>';		
}


//(view페이지 정보)
$bo_v_info = '';
if($is_good) { //좋아요
	include_once(G5_LIB_PATH.'/my/get_my.lib.php');
	$good_href = './good.php?bo_table='.$bo_table.'&amp;wr_id='.$wr_id.'&amp;good=good';//추가
	$bo_v_info .= '<div id="bo_v_good" class="list_goodContainer">';
	$new_good_cnt = get_new_good_cnt($bo_table, $view['wr_id']);
	$bo_v_info .= '<label class="label_good'.($new_good_cnt > 0?' new':'').'" data-tip="'.$view['wr_good'].' Likes">';
	$bo_v_info .= '<a href="'.$good_href.'&amp;'.$qstr.'" class="good_button icon_good" alt="좋아요">좋아요</a>';
	$bo_v_info .= '</label>';
	$bo_v_info .= '</div>';
}
if($bo_writer || $bo_date || $bo_hit) {
	$bo_v_info .= '<div id="bo_v_info">';	
	if($bo_writer) $bo_v_info .= $view['writer'];
	if($bo_date) $bo_v_info .= passing_time($view['wr_datetime']);
	if($bo_hit) $bo_v_info .= '<span class="info_hit"><span class="pc_only">조회수</span><span class="num">'.number_format($view['wr_hit']).'</span></span>';
	$bo_v_info .= '</div>';
}


//게시물별 태그목록
$view_tag_set = '';
if($view['wr_tag']) {
	//$view_tag_set .= $view['wr_tag'];
	$view_tag = explode(",", $view['wr_tag']);
	$view_tag_set .= '<div class="tagSet">';
	for ($i=0; $i<count($view_tag); $i++) {
		if($view_tag[$i]=='') continue;
		$view_tag_set .= '<a href="'.(get_pretty_url($bo_table,'','tag='.urlencode($view_tag[$i]))).'" class="tag';
		if($tag == $tag_name) $view_tag_set .= ' active';
		$view_tag_set .= '">'.$view_tag[$i].'</a>';
		//$view_tag_set .= '<span class="tag">'.$view_tag[$i].'</span>';
	}
	$view_tag_set .= '</div>';
}


//슬라이드 보기일때 에디터 이미지만 추출
$editor_img_src = get_editor_image($view['wr_content'], false);
$list_img = $editor_img_src[1];
$is_editor_img = count($list_img) > 0 ? true : false;
$editor_img_slide = $view['editor_img_slide'] && $is_editor_img ? true : false;
for($i=0; $i<count($list_img); $i++) {
	$p = @parse_url($list_img[$i]);
	if(strpos($p['path'], "/data/") != 0) {
		$data_path = preg_replace("/^\/.*\/data/", "/data", $p['path']);
	 } else {
		$data_path = $p['path'];
	 }
	 $editor_img[$i] = '<img src="'.$list_img[$i].'" alt="첨부 이미지">';
}


/*▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣〓▣*/

if($boStyle) echo '<style name="boStyle">'.$boStyle.'</style>'; //게시판 스타일

if(!$is_magnific_popup) {

	if($is_boTop) { //상단 인크루드
		echo '<div class="bo_top">';
		include_once($boTopPATH);
		echo '</div>';
	}

	echo '<div id="'.$bo_table.'" class="boWrap '.$boSkin.'" data-option="'.$bo_skinOption.'" style="'.$css_boWrap.'">';

	//view.skin.php 공통사용 ──────────
	if(file_exists($board_skin_path.'/view.skin.php')) {
		include_once($board_skin_path.'/view.skin.php');
	} else if(file_exists($board_pcskin_path.'/view.skin.php')) {
		include_once($board_pcskin_path.'/view.skin.php');
	} else {
		include_once(G5_BBS_PATH.'/my/view.skin.php');
	}

	echo '</div>'; // end - boWrap

	if($is_boBottom) { //하단 인쿠루드
		echo '<div class="bo_bottom">';
		include_once($boBottomPATH);
		echo '</div>';
	}

	@include_once($board_skin_path.'/view.tail.skin.php');
}