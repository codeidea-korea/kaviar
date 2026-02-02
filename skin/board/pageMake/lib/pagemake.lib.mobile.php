<?php
if (!defined('_GNUBOARD_')) exit;

//블록모음 사이즈 및 여백
$padding_LR = $board['bo_mobile_padding'] ? $board['bo_mobile_padding'].'px' :'0'; //공통 좌우 여백

$pageMakeStyle .= '.blockSet{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;

for ($i=0; $i<count($list); $i++) {
	
	$wr_use[$i] = true;
	if($list[$i]['wr_use'] == 'none' || $list[$i]['wr_use'] == 'pc') $wr_use[$i] = false;
	
	$alt[$i] = $list[$i]['wr_title'] ? $list[$i]['wr_title'] : $list[$i]['wr_block_name'];

	if($wr_use[$i]) {
		$blockName[$i] = 'section-'.$list[$i]['wr_id'];
		$blockID[$i] = '#'.$blockName[$i];
		$bl_layout[$i] = $list[$i]['wr_subject']; //블록 레이아웃		
		$alt[$i] = $list[$i]['bl_name'] ? $list[$i]['bl_name'] : $bl_layout[$i];
		$is_layout_LR[$i] = $bl_layout[$i] == 'layout-lt' || $bl_layout[$i] == 'layout-rt' ? true : false; //좌우 미디어 레이아웃 여부 채크
		
		$latest_skin[$i] = $list[$i]['latest_skin'];
		if(preg_match('#^theme/(.+)$#', $list[$i]['latest_skin'], $match)) $latest_skin[$i] = $match[1];
		if(preg_match('#^seperate/(.+)$#', $list[$i]['latest_skin'], $match)) $latest_skin[$i] = $match[1];

		//블록높이 (배경이미지형&빅배너형 일때만 적용)
		if($list[$i]['bl_height_mobile'] && ($bl_layout[$i]=='layout-bg' || $bl_layout[$i]=='layout-bigBanner')) {
			$pageMakeStyle .= $blockID[$i].' .blockInner{height:'.$list[$i]['bl_height_mobile'].'px;}';
		}

		//블록 가로 최대사이즈 (mobile블록은 항상 width:100%)

		//블록 좌우 여백 (게시판 모바일 여백에서 상속)		
		if($board['bo_mobile_padding']) {
			if($bl_layout[$i] == 'layout-bg' || $bl_layout[$i] == 'layout-bigBanner') {
				$pageMakeStyle .= $blockID[$i].' .blockInner{padding:0;}'.PHP_EOL;
				if($list[$i]['wr_video'] && $bl_layout[$i] == 'layout-bg') $pageMakeStyle .= $blockID[$i].' .blockInner.layout-bg .textCon{position:absolute;padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;  //동영상풀 모드일때 여백 제거
			} else {
				$pageMakeStyle .= $blockID[$i].':not([class*="piece-"]) .blockInner{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;
			}
		}

		if($list[$i]['bl_title'] && $list[$i]['bl_title_color']) {
			$pageMakeStyle .= $blockID[$i].' .blockInner .textCon .block-title{color:'.$list[$i]['bl_title_color'].'}';
		}
		if($isContent[$i] && $list[$i]['wr_content_color']) {
			$pageMakeStyle .= $blockID[$i].' .blockInner .textCon .contents{color:'.$list[$i]['wr_content_color'].'}';
		}

		$img[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 1, 1, false, true, 'center', false, '80/0.5/3', 0, false);
		$img_mob[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 1, 1, false, true, 'center', false, '80/0.5/3', 1, false);
		$img[$i] = G5_IS_MOBILE && $img_mob[$i]['src'] ? $img_mob[$i] : $img[$i];
		$thumbImg[$i] = $bl_layout[$i] == 'layout-bg' ? '' : $img[$i]['ori'];
		$bgImg[$i] = $bl_layout[$i] == 'layout-bg' ? $img[$i]['ori'] : '';
		if($bl_layout[$i] == 'layout-bigBanner') $thumbImg[$i] = $bgImg[$i] = '';

		//배경 이미지
		if($bgImg[$i]) {			
			$pageMakeStyle .= $blockID[$i].'{background-image:url('.$bgImg[$i].');background-size:cover;background-position:center;}';
			if($list[$i]['bl_height_mobile'] && $list[$i]['bl_parallax']) {
				$backgroundSize[$i] = $list[$i]['bl_height_mobile'] + 300; // js/my/parallax/jquery.parallax.js -> $(this).parallax("50%", 0.2, true, "150");
				$pageMakeStyle .= $blockID[$i].'.parallax{background-size:auto '.$backgroundSize[$i].'px !important;}';
			}
			if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .blockInner:before{content:"";position:absolute;top:0;left:0;width:100%;height:100%;z-index:1;background:'.$list[$i]['bl_background'].'}';
			if(!$list[$i]['wr_video_src'] && !$list[$i]['bl_parallax']) $pageMakeStyle .= $blockID[$i].' .blockInner.layout-bg{min-height:360px;}'.PHP_EOL;
		} else if($bl_layout[$i] == 'layout-bigBanner') {
			if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .bigBanner .swiper-slide:before{content:"";position:absolute;top:0;left:0;z-index:2;width:100%;height:100%;background:'.$list[$i]['bl_background'].'}';
		} else {
			if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].'{background-color:'.$list[$i]['bl_background'].';}';
		}		
		
		if($bl_layout[$i] != 'layout-mix') {
			//동영상 & 이미지
			if($list[$i]['wr_video'] && $bl_layout[$i] != 'layout-bigBanner') { //비디오 타입 채크
				if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .videoCover{background:'.$list[$i]['bl_background'].'}';

				if(strpos($list[$i]['wr_video_src'], 'youtu') !== false) {
					$videoType[$i] = 'youtube';
				} else if(strpos($list[$i]['wr_video_src'], 'vimeo') !== false) {
					$videoType[$i] = 'vimeo';
				} else if($list[$i]['wr_video_src']) {
					$videoType[$i] = 'mp4';
				}
				if($videoType[$i] == 'mp4') {
					if($thumbImg[$i]) {
						$poster[$i] = 'poster="'.$thumbImg[$i].'"';
						$preload[$i] = 'preload="none"';
					} else {
						$poster[$i] = $preload[$i] = '';
						$Poster_is[$i] = 'no-poster';
					}
					$imgCon[$i] = '<div class="video-container play-btn '.$Poster_is[$i].'">';
					$mp4_play[$i] = $list[$i]['wr_video_play'] ? 'playsinline loop="loop" muted="muted" autoplay="autoplay"' : ''; 
					$imgCon[$i] .= '<video src="'.$list[$i]['wr_video'].'" '.$preload[$i].' '.$poster[$i].' class="video" '.$mp4_play[$i].'">﻿</video>';
					$imgCon[$i] .= '</div>';
				} else if($videoType[$i] == 'youtube') {
					$imgCon[$i] = '<div class="youtube-wrap" style="min-width:100%">';
					if($thumbImg[$i]) $imgCon[$i] .= '<div class="video_thumb"><img src="'.$thumbImg[$i].'" alt="'.$alt[$i].'"></div>';
					if($list[$i]['wr_video_play']) { //자동재생
						//$imgCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0&autoplay=1&mute=1&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
						$imgCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0&autoplay=0&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
						//모바일 자동재생이 안됨... 나중에 재확인
					} else {
						$imgCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0&autoplay=0&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
					}
					$imgCon[$i] .= '</div>';
				} else if ($videoType[$i] == 'vimeo') {
					$imgCon[$i] = '<div class="vimeo-wrap">';
					$imgCon[$i] .= '<iframe src="https://player.vimeo.com/video/'.$list[$i]['wr_video'].'?autoplay=0" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
					$imgCon[$i] .= '</div>';
				}
			} else if($thumbImg[$i]) {
				$imgCon[$i] = '<div class="thumbImg"><img src="'.$thumbImg[$i].'" alt="'.$alt[$i].'"></div>'.PHP_EOL;
			}
			
			//최신글 불러오기
			$latestContainer[$i] = false;
			if($list[$i]['latest_table']) {				
				if($latest_skin[$i] == 'basic' && $list[$i]['wr_10']) $x2[$i] = 'x2';
				$latestContainer[$i] .= '<div class="latestContainer '.$x2[$i].'" data-skin-name="'.$latest_skin[$i].'">'.PHP_EOL;

				if($list[$i]['latest_option']) $latestOption[$i] = preg_replace("/,/", " ", $list[$i]['latest_option']); //,를 &nbsp;로 변환			

				if($list[$i]['latest_list_style'] == 'list-style2') $latestOption[$i] .= ' 외곽선';
					
				$list[$i]['gall_cols_default'] = $list[$i]['gall_cols_default'] > 2 ? 2 : 1; 
				$gallCols[$i] = $list[$i]['latest_gall_mobile_cols'] ? $list[$i]['latest_gall_mobile_cols'] : $list[$i]['gall_cols_default'];
				$latestOption[$i] .= ' 리스트가로수'.$gallCols[$i];
				
				$gallGutter[$i] = $list[$i]['latest_gall_itemspace'] ? $list[$i]['latest_gall_itemspace'] : 60; //간격은 60이 기본
				$gallGutter[$i] = G5_IS_MOBILE ? 15 : $gallGutter[$i]; // 모바일 간격은 15로 고정
				$latestOption[$i] .= ' 리스트간격'.$gallGutter[$i];

					
				if($list[$i]['latest_order_option'] == 'list_of_select') {
					$latestCount[$i] = $list[$i]['latest_sel_li_id'] ? count(explode(",",$list[$i]['latest_sel_li_id'])) : 0;
					$latestOption[$i] .= ' 직접선택';
					$latestSort[$i] = $list[$i]['latest_sel_li_id'];
				} else {
					$latestCount[$i] = G5_IS_MOBILE && $list[$i]['latest_mobile_count'] ? $list[$i]['latest_mobile_count'] : $list[$i]['latest_count'];
				}			
				
				if($list[$i]['latest_order_option'] == 'detail') { //상세조건일때만 order조건값 전달
					$latestCate[$i] = $list[$i]['latest_order_cate'] ? '|'.$list[$i]['latest_order_cate'] : ''; //카테고리 조건
					$latestSort[$i] = $list[$i]['wr_tag']; //선택한게시물 & 태그조건
				}


				//최신글 가로 사이즈 기준
				$latest_width_default[$i] = $is_layout_LR[$i] ? 1000 : 1800; //기본 가로 풀사이즈를 1800으로 잡고, 최신글 썸네일 사이즈 기준에 적용한다. 좌우미디어 레이아웃일땐 1200이 기준
				$latest_width[$i] = $list[$i]['bl_width'] > 100 ? $list[$i]['bl_width'] : $latest_width_default[$i];

				if($latest_skin[$i] == 'PEOPLE-HUB-RE') {
					$latestContainer[$i] .= latestSortComment($list[$i]['latest_skin'], $list[$i]['latest_table'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type']);
				} else {
					if($latest_skin[$i] == 'basic' && $list[$i]['wr_10']) $latestCount[$i] = round($latestCount[$i] / 2); //basic스킨에서 추가 게시판이 있을때 목록수 나누기
					$latestContainer[$i] .= latest_multi($list[$i]['latest_skin'], $list[$i]['latest_table'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type']);

					if($latest_skin[$i] == 'basic' && $list[$i]['wr_10']) { //basic스킨에서 추가 게시판이 있을때
						$latestContainer[$i] .= latest_multi($list[$i]['latest_skin'], $list[$i]['wr_10'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type']);
					}
				}

				$latestContainer[$i] .= '</div>'.PHP_EOL;

			} //end - $list[$i]['latest_table']
		}

		if($bl_layout[$i] == 'layout-mix') {
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer{color:'.$list[$i]['bl_font_color'].';}';
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer .mix-btn{color:'.$list[$i]['bl_font_color'].' !important;}';
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer .mix-btn:before, '.$blockID[$i].' .mixContainer .mix-btn:after{background:'.$list[$i]['bl_font_color'].' !important;}';

			if(file_exists($board_skin_path.'/mix-type/'.$list[$i]['mix_type'].'/mix.head.skin.php')) { //mix타입별 예외설정 불러오기
				include_once($board_skin_path.'/mix-type/'.$list[$i]['mix_type'].'/mix.head.skin.php');
			}
		}
		

		if($list[$i]['latest_table'] && $list[$i]['latest_skin']) { //blockInner에 클래스 주기
			$latest_type[$i] = $list[$i]['latest_type'];
		}

	} //end - $wr_use[$i]	
} //end - for




if($board['bo_category_list']) {
	$pageMakeStyle .= $is_admin && !defined('_INDEX_') ? '.boWrap{padding-bottom:80px;}' : '';
	//$pageMakeStyle .= '.blockContainer.height-fixed .layout-bg .basic-white .basicWhiteSkin{padding-bottom:90px;}'.PHP_EOL;
}

if($bo_background[0]) {
	$pageMakeStyle .= '#floatingMenu ul li.active{background:'.$bo_background[0].' !important;}';
}

$floatingMenu = false;
if($board['bo_category_list'] && $board['bo_use_category']) {
	$floatingMenu .= '<div id="floatingMenu" class="swiper-container fixed">';
	$floatingMenu .= '<ul class="swiper-wrapper">';
    $categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
	$li_size_style = count($categories) <=3 ? 'flex:1;' : '';
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if ($category=='') continue;
		if ($category==$sca) $active[$i] = 'active';
        $floatingMenu .= '<li class="'.$active[$i].' swiper-slide" style="'.$li_size_style.'"><a href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'"';
        $floatingMenu .= ' alt="'.$category.'">'.$category.'</a></li>';
    }
	$floatingMenu .= '</ul>';
	$floatingMenu .= '</div>';	
}





/*─────────────────────────────────────────────────────────────────
										첫번째 블럭이 배경이미지형일 경우
──────────────────────────────────────────────────────────────────*/
$is_full_bg = false;
if($bl_layout[0]=='layout-bg' && ($img[0] || $list[0]['wr_video'])) $is_full_bg = true;
if($bl_layout[0]=='layout-bigBanner') $is_full_bg = true;
if($is_full_bg) {	
	$pageMakeStyle .= '
	#wrapper{margin-top:-55px}
	#header{background-color:rgba(255,255,255,0);--textColor:#fff;--subColor:#717480;}
	#header:after{display:none;}
	#header .top_logo{color:#fff;}
	#header .top_logo .top_logo_c{opacity:0;}
	#header .top_logo .top_logo_w{opacity:1;}';
}