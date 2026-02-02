<?php
if (!defined('_GNUBOARD_')) exit;

/*─────────────────────────────────────────────────
									블럭모음 사이즈 및 여백
─────────────────────────────────────────────────*/
if(!G5_IS_MOBILE) {
	$blockSet_padding_LR = $board['bo_padding_left_right'] > 10 ? $board['bo_padding_left_right'].'px' : $board['bo_padding_left_right'].'%'; //공통 좌우 여백
	if($board['bo_table_width'] > 100) {
		$table_max_width = $is_quickNews ? $board['bo_table_width'] + 60 : $board['bo_table_width'];
		$pageMakeStyle .= '
		.blockSet .inner{max-width:'.$board['bo_table_width'].'px;margin:0 auto;}
		@media screen and (max-width:'.$table_max_width.'px) {
			.blockSet{padding-left:'.$blockSet_padding_LR.';padding-right:'.$blockSet_padding_LR.';}
		}'.PHP_EOL;
	} else {
		if($board['bo_padding_left_right']) $pageMakeStyle .= '.blockSet{padding-left:'.$blockSet_padding_LR.';padding-right:'.$blockSet_padding_LR.';}'.PHP_EOL;
	}
}

/*─────────────────────────────────────────────────
										게시판 좌우여백
─────────────────────────────────────────────────*/
$padding_LR = $board['bo_padding_left_right'] > 10 ? $board['bo_padding_left_right'].'px' : $board['bo_padding_left_right'].'%'; //공통 좌우 여백
if(G5_IS_MOBILE) {
	$padding_LR = $board['bo_mobile_padding'] ? $board['bo_mobile_padding'].'px' :'0'; //공통 좌우 여백
	$pageMakeStyle .= '.blockSet{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;
}


for ($i=0; $i<count($list); $i++) {
	
	$wr_use[$i] = true;
	if($list[$i]['wr_use'] == 'none') $wr_use[$i] = false;
	if(!G5_IS_MOBILE && $list[$i]['wr_use'] == 'mobile') $wr_use[$i] = false;
	if(G5_IS_MOBILE && $list[$i]['wr_use'] == 'pc') $wr_use[$i] = false;
	
	$alt[$i] = $list[$i]['wr_title'] ? $list[$i]['wr_title'] : $list[$i]['wr_block_name'];

	if($wr_use[$i]) {
		$blockName[$i] = 'section-'.$list[$i]['wr_id'];
		$blockID[$i] = '#'.$blockName[$i];
		$bl_layout[$i] = $list[$i]['wr_subject']; //블럭 레이아웃		
		$alt[$i] = $list[$i]['bl_name'] ? $list[$i]['bl_name'] : $bl_layout[$i];
		$is_layout_LR[$i] = $bl_layout[$i] == 'layout-lt' || $bl_layout[$i] == 'layout-rt' ? true : false; //좌우 미디어 레이아웃 여부 채크
		
		$latest_skin[$i] = $list[$i]['latest_skin'];
		if(preg_match('#^theme/(.+)$#', $list[$i]['latest_skin'], $match)) $latest_skin[$i] = $match[1];
		if(preg_match('#^seperate/(.+)$#', $list[$i]['latest_skin'], $match)) $latest_skin[$i] = $match[1];
		
		/*─────────────────────────────────────────────────
							블럭높이 (배경이미지형&빅배너형 일때만 적용)
		─────────────────────────────────────────────────*/
		if(!G5_IS_MOBILE && $list[$i]['bl_height']) {
			if($bl_layout[$i]=='layout-bg' || $bl_layout[$i]=='layout-bigBanner') {
				$pageMakeStyle .= $blockID[$i].' .blockInner{height:'.$list[$i]['bl_height'].'px;}';
			}
		}
		if(G5_IS_MOBILE && $list[$i]['bl_height_mobile']) {
			if($bl_layout[$i]=='layout-bg' || $bl_layout[$i]=='layout-bigBanner') {
				$pageMakeStyle .= $blockID[$i].' .blockInner{height:'.$list[$i]['bl_height_mobile'].'px;}';
			}
		}

		/*─────────────────────────────────────────────────
											블럭 가로 최대사이즈
		─────────────────────────────────────────────────*/
		//블럭 가로 최대사이즈 (mobile블럭은 항상 width:100%)
		if(!G5_IS_MOBILE) {
			$bl_width[$i] = $list[$i]['bl_width'] ? $list[$i]['bl_width'] : 100;
			$bl_width[$i] .= $bl_width[$i] >= 100 ? 'px' : '%';
			if($list[$i]['bl_width'] && $bl_layout[$i] != 'layout-bg' && $bl_layout[$i] != 'layout-bigBanner') $pageMakeStyle .= $blockID[$i].':not([class*="piece-"]) .blockInner{max-width:'.$bl_width[$i].';margin:0 auto;}'.PHP_EOL;
		}
		
		/*─────────────────────────────────────────────────
								블럭 좌우 여백 (게시판 여백설정에서 상속)
		─────────────────────────────────────────────────*/
		if(!G5_IS_MOBILE) {
			if($board['bo_padding_left_right']) {
				if($bl_layout[$i] == 'layout-bg' || $bl_layout[$i] == 'layout-bigBanner') {
					$pageMakeStyle .= $blockID[$i].' .blockInner{padding:0;}'.PHP_EOL;
					if($list[$i]['wr_video'] && $bl_layout[$i] == 'layout-bg') $pageMakeStyle .= $blockID[$i].' .blockInner.layout-bg .textCon{position:absolute;padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;  //동영상풀 모드일때 여백 제거
				} else {
					if(!$list[$i]['bl_width']) {
						$pageMakeStyle .= $blockID[$i].' .blockInner{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;
					} else {
						$max_bl_width[$i] = $is_quickNews ? $list[$i]['bl_width'] + 60 : $list[$i]['bl_width'];
						$pageMakeStyle .= '
						@media screen and (max-width:'.$max_bl_width[$i].'px) {
							'.$blockID[$i].' .blockInner{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}
						}'.PHP_EOL;
					}
				}
			}
		} else {	
			if($board['bo_mobile_padding']) {
				if($bl_layout[$i] == 'layout-bg' || $bl_layout[$i] == 'layout-bigBanner') {
					$pageMakeStyle .= $blockID[$i].' .blockInner{padding:0;}'.PHP_EOL;
					if($list[$i]['wr_video'] && $bl_layout[$i] == 'layout-bg') $pageMakeStyle .= $blockID[$i].' .blockInner.layout-bg .textCon{position:absolute;padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;  //동영상풀 모드일때 여백 제거
				} else {
					$pageMakeStyle .= $blockID[$i].':not([class*="piece-"]) .blockInner{padding-left:'.$padding_LR.';padding-right:'.$padding_LR.';}'.PHP_EOL;
				}
			}
		}

		/*─────────────────────────────────────────────────
								블럭 상하 여백 (게시판 여백설정에서 상속)
		─────────────────────────────────────────────────*/
		$bl_padding_top[$i] = explode("|",$list[$i]['bl_padding_top']);
		$bl_padding_top[$i] = !G5_IS_MOBILE ? $bl_padding_top[$i][0] : $bl_padding_top[$i][1]; 
		$bl_padding_bottom[$i] = explode("|",$list[$i]['bl_padding_bottom']);
		$bl_padding_bottom[$i] = !G5_IS_MOBILE ? $bl_padding_bottom[$i][0] : $bl_padding_bottom[$i][1];
		if(!G5_IS_MOBILE) {
			$bl_padding_top[$i] = $bl_padding_top[$i] ? $bl_padding_top[$i] : $board['bo_padding_top'];
			$bl_padding_bottom[$i] = $bl_padding_bottom[$i] ? $bl_padding_bottom[$i] : $board['bo_padding_bottom'];
		} else {
			$bl_padding_top[$i] = $bl_padding_top[$i] ? $bl_padding_top[$i] : $board['bo_mobile_padding'];
			$bl_padding_bottom[$i] = $bl_padding_bottom[$i] ? $bl_padding_bottom[$i] : $board['bo_mobile_padding'];			
		}
		if($bl_layout[$i] != 'layout-bg' && $bl_layout[$i] != 'layout-bigBanner') {
			if($bl_padding_top[$i]) $pageMakeStyle .= $blockID[$i].' .blockInner{padding-top:'.$bl_padding_top[$i].'px;}'.PHP_EOL;
			if($bl_padding_bottom[$i]) $pageMakeStyle .= $blockID[$i].' .blockInner{padding-bottom:'.$bl_padding_bottom[$i].'px;}'.PHP_EOL;
		}

		
		/*─────────────────────────────────────────────────
													font style
		─────────────────────────────────────────────────*/
		if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .textCon{color:'.$list[$i]['bl_font_color'].';}';
		if($list[$i]['bl_title']){
			if($list[$i]['bl_title_color']) $pageMakeStyle .= $blockID[$i].' .blockInner .textCon .block-title{color:'.$list[$i]['bl_title_color'].' !important}';
			if($list[$i]['bl_title_size'] && !G5_IS_MOBILE) $pageMakeStyle .= $blockID[$i].' .blockInner .textCon .block-title{font-size:'.$list[$i]['bl_title_size'].'px;line-height:1.2em;}';
		}
		if($isContent[$i] && $list[$i]['wr_content_color']) {
			$pageMakeStyle .= $blockID[$i].' .blockInner .textCon .contents{color:'.$list[$i]['wr_content_color'].' !important}';
		}
		

		// 이미지 썸네일
		$img[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 1, 1, false, true, 'center', false, '80/0.5/3', 0, false);
		$img_mob[$i] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 1, 1, false, true, 'center', false, '80/0.5/3', 1, false);
		$img[$i] = G5_IS_MOBILE && $img_mob[$i]['src'] ? $img_mob[$i] : $img[$i];

		/*──────────────────────────────────────────────────────
														동영상
		───────────────────────────────────────────────────────*/
		if($list[$i]['wr_video']) { 
			if(strpos($list[$i]['wr_video_src'], 'youtu') !== false) {
				$videoType[$i] = 'youtube';
			} else if(strpos($list[$i]['wr_video_src'], 'vimeo') !== false) {
				$videoType[$i] = 'vimeo';
			} else if($list[$i]['wr_video_src']) {
				$videoType[$i] = 'mp4';
			}
			if($videoType[$i] == 'mp4') {
				if( !preg_match('/http(s?)\:\/\//i', $list[$i]['wr_video']) ) $list[$i]['wr_video'] = G5_URL.$list[$i]['wr_video'];
				$videoCon[$i] = '<div class="video-container'.($bl_layout[$i] == 'layout-bg'&&$list[$i]['wr_video_play']?'':' play-btn').''.($img[$i]['ori']?'':' no-poster').($list[$i]['bl_parallax']?' video-parallax':'').'">';
				$videoCon[$i] .= '<video src="'.$list[$i]['wr_video'].'" class="video"'.($img[$i]['ori']?' poster="'.$img[$i]['ori'].'" preload="none"':'').''.($list[$i]['wr_video_play']?' playsinline loop="loop" muted="muted" autoplay="autoplay"':' controls').'>﻿</video>';
				$videoCon[$i] .= '</div>';
			} else if($videoType[$i] == 'youtube') {
				$videoCon[$i] = '<div class="youtube-wrap">';					
				$videoCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0'.($list[$i]['wr_video_play']?'&autoplay=1&mute=1':'&autoplay=0').'&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
				$videoCon[$i] .= '</div>';
			} else if ($videoType[$i] == 'vimeo') {
				$videoCon[$i] = '<div class="vimeo-wrap">';
				$videoCon[$i] .= '<iframe src="https://player.vimeo.com/video/'.$list[$i]['wr_video'].'?'.($list[$i]['wr_video_play']?'autoplay=1':'autoplay=0').'" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
				$videoCon[$i] .= '</div>';
			}
			if(!G5_IS_MOBILE && $list[$i]['wr_video_width']) {
				$pageMakeStyle .= '.video-container, .youtube-wrap, .vimeo-wrap{width:'.$list[$i]['wr_video_width'].'px !important;}';
				if($bl_layout[$i] == 'layout-bg') {
					$pageMakeStyle .= $blockID[$i].' .blockInner{align-items:flex-start;justify-content:flex-start;}';
					$video_width_half[$i] = $list[$i]['wr_video_width'] / 2;
					$pageMakeStyle .= '.video-container, .youtube-wrap, .vimeo-wrap{position:absolute;top:0px !important;left:50%;margin-left:-'.$video_width_half[$i].'px !important;}';
				}
			}
		}
		
		
		if($bl_layout[$i] != 'layout-mix') {			
			/*────────────────────────────────────────────────────────────────
															최신글 불러오기 설정
			─────────────────────────────────────────────────────────────────*/
			$latestContainer[$i] = '';
			if($list[$i]['latest_table']) {
				if($latest_skin[$i] == 'basic' && $list[$i]['wr_10'] && !$is_layout_LR[$i]) $x2[$i] = 'x2';
				$latestContainer[$i] .= '<div class="latestContainer '.$x2[$i].'" data-skin-name="'.$latest_skin[$i].'">'.PHP_EOL;

				if($is_admin && !defined('_INDEX_') && $latest_skin[$i] != 'basic') {
					$latestContainer[$i] .=  '<div class="latest_adm myTip mini right" data-tip="'.$list[$i]['latest_table'].' 바로가기">
					<a href="'.G5_BBS_URL.'/board.php?bo_table='.$list[$i]['latest_table'].'" target="_blank" class="icon-adm" alt="'.$list[$i]['latest_table'].'">게시판 바로가기</a></div>';//바로가기버튼
				}
				
				//$list[$i]['latest_option'] = G5_IS_MOBILE ? $list[$i]['latest_mobile_option'] : $list[$i]['latest_option'];
				if($list[$i]['latest_option']) $latestOption[$i] = preg_replace("/,/", " ", $list[$i]['latest_option']); //,를 &nbsp;로 변환			

				if($list[$i]['latest_list_style'] == 'list-style2') $latestOption[$i] .= ' 외곽선';
				
				if(G5_IS_MOBILE) $list[$i]['gall_cols_default'] = $list[$i]['gall_cols_default'] >= 2 ? 2 : 1; 
				$gallCols[$i] = G5_IS_MOBILE && $list[$i]['latest_gall_mobile_cols'] ? $list[$i]['latest_gall_mobile_cols'] : $list[$i]['latest_gall_cols'];
				$gallCols[$i] = $gallCols[$i] ? $gallCols[$i] : $list[$i]['gall_cols_default'];
				$latestOption[$i] .= ' 리스트가로수'.$gallCols[$i];
				
				$gallGutter[$i] = $list[$i]['latest_gall_itemspace'] ? $list[$i]['latest_gall_itemspace'] : 60; //간격은 60이 기본
				if(G5_IS_MOBILE) {
					$gallGutter[$i] = $gallCols[$i] >=3 ? 15 : 30 / $gallCols[$i];
				}
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
				$latest_width_default[$i] = G5_IS_MOBILE ? 1000:1800; //기본 가로 풀사이즈를 1000(모바일) 1800으로 잡는다. 썸네일 생성시 사이즈 기준.
				$latest_width[$i] = $list[$i]['bl_width'] > 100 ? $list[$i]['bl_width'] : $latest_width_default[$i];
				$latest_width[$i] = !G5_IS_MOBILE && $is_layout_LR[$i] ? $latest_width[$i] / 2 : $latest_width[$i]; //좌,우 미디어 레이아웃일 경우 반으로 나눈다.

				if($bl_layout[$i] == 'layout-bigBanner' && $list[$i]['bl_parallax']) $latestOption[$i] .= ' 스크롤모션';

				if($latest_skin[$i] == 'PEOPLE-HUB-RE') {
					$latestContainer[$i] .= latestSortComment($list[$i]['latest_skin'], $list[$i]['latest_table'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type']);
				} else {
					if($latest_skin[$i] == 'basic' && $list[$i]['wr_10']) $latestCount[$i] = round($latestCount[$i] / 2); //basic스킨에서 추가 게시판이 있을때 목록수 나누기
					$latestContainer[$i] .= latest_multi($list[$i]['latest_skin'], $list[$i]['latest_table'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type'], $bl_font);
					if($latest_skin[$i] == 'basic' && $list[$i]['wr_10']) { //basic스킨에서 추가 게시판이 있을때
						$latestContainer[$i] .= latest_multi($list[$i]['latest_skin'], $list[$i]['wr_10'].$latestCate[$i], $latestCount[$i], 100, 0, $latestSort[$i], $blockName[$i], $latestOption[$i], $latest_width[$i], $list[$i]['bl_background'], $list[$i]['latest_type'], $bl_font);
					}
				}
				$latestContainer[$i] .= '</div>'.PHP_EOL;

				if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .latestContainer{color:'.$list[$i]['bl_font_color'].';}';

			} //end - $list[$i]['latest_table'] ─────────────────────────────────────────────────────────────────


			/*────────────────────────────────────────────────────────────────
																백그라운드형 블럭
			─────────────────────────────────────────────────────────────────*/
			$backgroundCon[$i] = $imgCon[$i] = '';
			if($bl_layout[$i] == 'layout-bg') {
				//동영상 백그라운드
				if($videoCon[$i]) {
					$backgroundCon[$i] = '<div class="backgroundCon">'.$videoCon[$i].'</div>';
				//이미지 백그라운드
				} else if($img[$i]['ori']) {
					$parallax_num[$i] = $i==0 ? '' : '';
					$backgroundCon[$i] = '<div class="backgroundCon'.($list[$i]['bl_parallax']?' parallax':'').($i!=0&&$list[$i]['bl_parallax']?' start-bottom':'').(G5_IS_MOBILE&&$list[$i]['bl_parallax']?' mobile':'').'" style="background:url('.$img[$i]['ori'].') no-repeat center / cover;"></div>';
					if(G5_IS_MOBILE && $list[$i]['bl_height_mobile'] && $list[$i]['bl_parallax']) {
						$backgroundSize[$i] = $list[$i]['bl_height_mobile'] + 300; // js/my/parallax/jquery.parallax.js -> $(this).parallax("50%", 0.2, true, "150");
						$pageMakeStyle .= $blockID[$i].' .parallax{background-size:auto '.$backgroundSize[$i].'px !important;}';
					}
					if(G5_IS_MOBILE && !$list[$i]['bl_parallax']) $pageMakeStyle .= $blockID[$i].' .blockInner.layout-bg{min-height:360px;}'.PHP_EOL;
				}
				//if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .blockInner:before{content:"";position:absolute;top:0;left:0;z-index:1;width:100%;height:100%;background-color:'.$list[$i]['bl_background'].'}';
			} else if($bl_layout[$i] == 'layout-bigBanner') {
				$backgroundCon[$i] = '<div class="backgroundCon">'.$latestContainer[$i].'</div>';
				$latestContainer[$i] = '';
				if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .bigBanner .bannerContents{background-color:'.$list[$i]['bl_background'].'}';
				if(G5_IS_MOBILE && $list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .bigBanner .swiper-slide:before{content:"";position:absolute;top:0;left:0;z-index:2;width:100%;height:100%;background:'.$list[$i]['bl_background'].'}';
			} else {
				if($videoCon[$i]) {
					$imgCon[$i] = $videoCon[$i];
				} else {
					if($img[$i]['ori']) $imgCon[$i] = '<div class="thumbImg"><img src="'.$img[$i]['ori'].'" alt="'.$alt[$i].'"></div>'.PHP_EOL;
				}
			}
		} //end - $bl_layout[$i] != 'layout-mix'  ─────────────────────────────────────────────────────────────────
		




		/*───────────────────────────────────────────────────
											믹스 블럭 관련 layout-mix
		────────────────────────────────────────────────────*/
		if($bl_layout[$i] == 'layout-mix') {
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer{color:'.$list[$i]['bl_font_color'].';}';
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer .mix-btn{color:'.$list[$i]['bl_font_color'].' !important;}';
			if($list[$i]['bl_font_color']) $pageMakeStyle .= $blockID[$i].' .mixContainer .mix-btn:before, '.$blockID[$i].' .mixContainer .mix-btn:after{background:'.$list[$i]['bl_font_color'].' !important;}';
			if(file_exists($board_skin_path.'/mix-type/'.$list[$i]['mix_type'].'/mix.head.skin.php')) { //mix타입별 예외설정 불러오기
				include_once($board_skin_path.'/mix-type/'.$list[$i]['mix_type'].'/mix.head.skin.php');
			}

			for($x=1; $x<11; $x++) {
				$thumb[$x][$i] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 600, 0, false, true, 'center', false, '80/0.5/3', $x, false);
				$wr[$x][$i] = explode("|",$list[$i]['wr_'.$x]);
				$wr_sub[$x][$i] = explode("|",$list[$i]['wr_sub'.$x]);
				$mix_link[$x][$i] = '';
				if($wr_sub[$x][$i][1]) {
					if($wr_sub[$x][$i][2] == 'layer-popup') {
						$mix_link[$x][$i] = '<a href="'.get_layer_popup_url($wr_sub[$x][$i][1]).'" class="'.$blockName[$i].'_popup-view" alt="링크">';
					} else if($wr_sub[$x][$i][2] == 'alert') {
						//$mix_link[$x][$i] = '<a href="javascript:alert(\''.$wr_sub[$x][$i][1].'\');" class="" alt="바로가기">';
						$mix_link[$x][$i] = '<a class="pop-alert" data-text="'.$wr_sub[$x][$i][1].'">';					
					} else {
						$mix_link[$x][$i] = '<a href="'.$wr_sub[$x][$i][1].'" class="" target="'.$wr_sub[$x][$i][2].'" alt="링크">';
					}
				}
			}
		}

		//blockInner에 최신글이 있을경우 최신글스킨 타입으로 클래스명 전달
		$latest_type[$i] = '';
		if($list[$i]['latest_table'] && $list[$i]['latest_skin']) $latest_type[$i] = $list[$i]['latest_type'];

		if($list[$i]['bl_background']) $pageMakeStyle .= $blockID[$i].' .backgroundCon:before{content:"";position:absolute;top:0;left:0;z-index:1;width:100%;height:100%;background-color:'.$list[$i]['bl_background'].'}';
		
	} //end - $wr_use[$i]	
} //end - for



/*─────────────────────────────────────────────────────────────────
											페이지메이크 텝메뉴(분류)
──────────────────────────────────────────────────────────────────*/
$pagemake_tabmenu = $pagemake_tabmenu_top = $pagemake_tabmenu_floating = '';
if($board['bo_category_list'] && $board['bo_use_category']) {
	$categories = explode('|', $board['bo_category_list']);
	if(!G5_IS_MOBILE) {		
		$pagemake_tabmenu .= '<ul'.(count($categories) < 4?' class="flex-center"':'').'>';    
		for ($i=0; $i<count($categories); $i++) {
			$category = trim($categories[$i]);
			if ($category=='') continue;
			if ($category==$sca) $active[$i] = 'active';
			if(count($categories) <= 8) $li_row[$i] = ' flex1';
			$pagemake_tabmenu .= '<li class="'.$active[$i].$li_row[$i].'"'.($active[$i]&&$bo_background[0]?' style="background:'.$bo_background[0].'"':'').'><a href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'"';
			$pagemake_tabmenu .= ' alt="'.$category.'">'.$category.'</a></li>';
		}
		$pagemake_tabmenu .= '</ul>';
	} else {
		$pagemake_tabmenu .= '<ul class="swiper-wrapper">';
		$categories = explode('|', $board['bo_category_list']);
		for ($i=0; $i<count($categories); $i++) {
			$category = trim($categories[$i]);
			if ($category=='') continue;
			if ($category==$sca) $active[$i] = 'active';
			if(count($categories) <= 4) $li_row[$i] = ' flex1';
			$pagemake_tabmenu .= '<li class="'.$active[$i].' swiper-slide'.$li_row[$i].'"><a href="'.(get_pretty_url($bo_table,'','sca='.urlencode($category))).'"';
			$pagemake_tabmenu .= ' alt="'.$category.'">'.$category.'</a></li>';
		}
		$pagemake_tabmenu .= '</ul>';
		if($board['bo_cate_skin'] == '') {
			$myStyle .= '#_gototop{margin-bottom:50px;}';
			$myScript .= 'bottom_scrollTrigger("#pagemake-tabmenu.floating, #_gototop")';
		}
	}	
	if($board['bo_cate_skin'] == 'top-tabs') $pagemake_tabmenu_top = '<div id="pagemake-tabmenu" class="top-tabs mobile-max-width">'.$pagemake_tabmenu.'</div>';
	if($board['bo_cate_skin'] == '') {
		$pagemake_tabmenu_floating = '<div id="pagemake-tabmenu" class="floating auto-fixed mobile-max-width">'.$pagemake_tabmenu.'</div>';
		if($is_admin) $pageMakeStyle .= '.bo_adm_set .ul-edit-mode.on.fixed{transform:translateY(-48px);}';		
	}
		
}


/*─────────────────────────────────────────────────────────────────
										첫번째 블럭이 배경이미지형일 경우
──────────────────────────────────────────────────────────────────*/
$is_full_bg = false;
if($bl_layout[0]=='layout-bg' && ($img[0] || $list[0]['wr_video'])) $is_full_bg = true;
if($bl_layout[0]=='layout-bigBanner') $is_full_bg = true;
if($is_full_bg) {
	if(!G5_IS_MOBILE) {
		$pageMake_top_margin = $pagemake_tabmenu_top ? $header['header_height'] + 100 : $header['header_height'];
		$pageMakeStyle .= '#pageMake{margin-top:-'.$pageMake_top_margin.'px}';
		$pageMakeStyle .= $blockID[0].' .latestContainer .latest_adm{top:120px;left:20px;}';
		if(!$header['top_header_color_fixed']) {
			$pageMakeStyle .= '
			#header .topSection:not(.scroll):not(.open){background-color:rgba(255,255,255,0);}
			#header .topSection:not(.scroll):not(.open):after{display:none;}
			#header .topSection:not(.scroll):not(.open) .top-header-logo .top_logo_c{opacity:0;}
			#header .topSection:not(.scroll):not(.open) .top-header-logo .top_logo_w{opacity:1;}
			#header .topSection:not(.scroll):not(.open) [class*="line-"]{background:#fff}
			#header .topSection:not(.scroll):not(.open) [class*="line-"]:after{border-color:#fff;}
			#header .topSection:not(.scroll):not(.open), #header .topSection:not(.scroll):not(.open) a, #header .topSection:not(.scroll):not(.open) .active a, #header .topSection:not(.scroll):not(.open) #hd-search-opener{color:#fff}
			';
		}
	} else {
		$pageMakeStyle .= '#container{padding-top:0 !important;}';		 
		$pageMakeStyle .= '#header:not(.scroll){background-color:rgba(255,255,255,0);--textColor:#fff;--subColor:#717480;}';
		$pageMakeStyle .= '#header:not(.scroll):after{display:none;}';
		$pageMakeStyle .= '#header:not(.scroll) .top_logo{color:#fff;}';
		$pageMakeStyle .= '#header:not(.scroll) .top_logo .top_logo_c{opacity:0;}';
		$pageMakeStyle .= '#header:not(.scroll) .top_logo .top_logo_w{opacity:1;}';
		if($header_top_bg[0]) {
			$pageMakeStyle .= '#header.scrollfixed.scroll{background-color:'.$header_top_bg[0].';--textColor:#fff;--subColor:#717480;}';
			$pageMakeStyle .= '#header.scrollfixed.scroll:after{display:none;}';
		}
	}
}