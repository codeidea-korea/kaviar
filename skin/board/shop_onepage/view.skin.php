<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once(G5_LIB_PATH.'/my/shop_block.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/style.css').'">', 3);

$pn_id = $bo_table;
?>

<article id="bo_v">
	<?php if(!G5_IS_MOBILE) echo $fileDownload; //첨부파일?>	

    <section id="bo_v_atc">	

		<?=$bo_v_linkSet; //첨부된 링크?>

        <?php
		if($view['wr_video']) { //저장된 동영상 코드가 있다면
			echo '<section id="bo_v_video">';
			if($video_type == 'mp4') {
				if( !preg_match('/http(s?)\:\/\//i', $view['wr_video']) ) $view['wr_video'] = G5_URL.$view['wr_video'];
				echo '<div class="video-container play-btn"><video src="'.$view['wr_video'].'" controls class="video"></video></div>';
			} else if($video_type == 'youtube') {
				echo '<iframe src="https://www.youtube.com/embed/'.$view['wr_video'].'?amp;controls=2&amp;showinfo=1&autoplay=0&modestbranding=1" frameborder="0" class="video" allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
			} else if($video_type == 'vimeo') {
				echo '<iframe src="https://player.vimeo.com/video/'.$view['wr_video'].'?autoplay=0" frameborder="0" class="video" webkitallowfullscreen mozallowfullscreen allowfullscreen title="'.$view['wr_subject'].'"></iframe>';
			}
			echo '</section>';
		}

		if($board['bo_view_thumb']) { //뷰페이지 이미지 사용
			if(strpos($boSkin, 'gallery') !== false) { //갤러리 스킨은 pc, 모바일 구분
				if(G5_IS_MOBILE && $view['file'][1]['view']){
					echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][1]).'</div>';
				} else if($view['file'][0]['view']) {
					echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][0]).'</div>';
				}
			} else {
				$v_img_count = count($view['file']);
				if($v_img_count) {
					for ($i=0; $i<=count($view['file']); $i++) {
						if ($view['file'][$i]['view']) {
							//echo $view['file'][$i]['view'];
							echo '<div class="bo_v_img">'.get_file_thumbnail($view['file'][$i]).'</div>';
						}
					}
				}
			}
		}
        
		echo get_include_html($view['wr_id']);

        if($isContent) {
			echo '<div id="bo_v_con">';
				if($editor_img_slide) {
					$view['wr_slide_width'] = $view['wr_slide_width'] ? $view['wr_slide_width'] : '500';
					$slideWidth = G5_IS_MOBILE || $view['wr_slide_width'] == '100' ? '100%;' : $view['wr_slide_width'].'px;';

					$slideData = '';
					if(!G5_IS_MOBILE) {
						if($view['wr_slide_row']) $slideData .= ' data-row="'.$view['wr_slide_row'].'"';
						if($view['wr_slide_space']) $slideData .= ' data-space="'.$view['wr_slide_space'].'"';
					}
					if($view['wr_slide_timer']) $slideData .= ' data-timer="'.$view['wr_slide_timer'].'"';
					if($view['wr_slide_loop']) $slideData .= ' data-loop="1"';

					echo '<div class="mySwiper" data-per="1" data-loop="true">';
						echo '<div class="swiper-container">';
							echo '<div class="swiper-wrapper">';
								for($i=0; $i<count($list_img); $i++) {
									echo '<div class="swiper-slide">'.$editor_img[$i].'</div>';
								}							
							echo '</div>';
						echo '</div>';
						echo '<span class="prev"></span>';
						echo '<span class="next"></span>';
						echo '<div class="pagination"></div>';
					echo '</div>';
				} else {
					echo get_view_thumbnail($view['content']);
				}
			echo '</div>';
        }

		echo $view_btn_set;

		
		if($delete_href || $update_href) {
			echo '<div id="bo_v_btnSet">';
			if($update_href) echo '<a href="'.$update_href.'" class="btn_edit" alt="수정">수정</a>';
			if($delete_href) echo '<a href="'.$delete_href.'" class="btn_del" onclick="del(this.href); return false;" alt="삭제">삭제</a>';			
			echo '</div>';
		}
		
		if(G5_IS_MOBILE) echo $fileDownload; //첨부파일		
		?>
        
    </section>

	<?php
	if($is_shop_manager) {
		echo '<a href="'.$_adm_url.'/?pn=_shop_block&bl_cate='.$pn_id.'&title=쇼핑몰 페이지 관리'.($pn=='_view_adm'?'&bl_use=admin':'').'" id="shopIndexSetting" class="btnSetting popWin'.($pn=='_view_adm'?' _view_adm':'').'" data-width="1400" data-height="700" data-top="60" data-left="0" data-area="#shopIndex">쇼핑몰 페이지 관리</a>';
		if($pn=='_view_adm') echo '<div id="_view_adm_msg" class="mobile-max-width"><span class="msg">보고계신 페이지는<br>관리자 확인용 페이지입니다.</span></div>';
	}

	echo '<article id="shopIndex">';	
		echo shop_block($pn_id);
	echo '</article>';
	?>

</article>