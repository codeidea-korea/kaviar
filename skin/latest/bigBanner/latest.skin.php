<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
add_stylesheet('<link rel="stylesheet" href="'.get_url($latest_skin_url.'/'.$css).'">', 3);
?>


<div class="bigBanner">	
	<?php if(count($list) > 1) {		
		echo '<div class="pagerContainer">';
		echo '<span class="timer"><span class="inner"></span></span>';
		echo '<div class="swiper-pagination"></div>';
		echo '</div>';
		if(!G5_IS_MOBILE) {
			echo '<div class="slide-turn-btn prev"></div> ';
			echo '<div class="slide-turn-btn next"></div>';
		}
	} ?>
	<div class="swiper-container">
		<ul class="swiper-wrapper">
			<?php for ($i=0; $i<count($list); $i++) {
				$img_thumb_mobile[$i] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 1000, 0, false, true, 'center', false, '80/0.5/3', 1);
				$img_thumb[$i] = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 1990, 0);
				if(G5_IS_MOBILE) {
					$img_thumb[$i] = $img_thumb_mobile[$i]['src'] ? $img_thumb_mobile[$i] : $img_thumb[$i];
				}

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

				if($list[$i]['wr_video']) {
					if($video_type[$i] == 'mp4') {
						if($img_thumb[$i]['src']) {
							$poster[$i] = 'poster="'.$img_thumb[$i]['src'].'"';
							$preload[$i] = 'preload="none"';
						} else {
							$Poster_is[$i] = ' no-poster';
						}
						$img[$i] = '<div class="video-container'.$Poster_is[$i].($parallax?' video-parallax':'').'">';
						$img[$i] .= '<video src="'.$list[$i]['wr_video'].'" '.$preload[$i].' '.$poster[$i].' class="video" loop="loop" muted="muted">﻿</video>';
						$img[$i] .= '</div>';
					} else if($video_type[$i] == 'youtube') {
						$img[$i] = '<div class="youtube-wrap">';
						if($list[$i]['wr_video_play']) { //자동재생
							$imgCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0&autoplay=1&mute=1&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
						} else {
							$imgCon[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=0&showinfo=0&autoplay=0&modestbranding=1&rel=0" allowfullscreen  frameborder="0" class="video" title="'.$alt[$i].'"></iframe>';
						}

						if($img_thumb[$i]['src']) $img[$i] .= '<div class="video_thumb"><img src="'.$img_thumb[$i]['src'].'" alt="'.$list[$i]['wr_subject'].'"></div>';
						$img[$i] .= '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?controls=2&showinfo=0&autoplay=0&modestbranding=1&rel=0&loop=0" allowfullscreen  frameborder="0" class="video" title="'.$list[$i]['wr_subject'].'"></iframe>';
						$img[$i] .= '</div>';
					} else if ($video_type[$i] == 'vimeo') {
						$img[$i] = '<div class="vimeo-wrap">';
						$img[$i] .= '<iframe src="https://player.vimeo.com/video/'.$list[$i]['wr_video'].'?autoplay=0" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0" class="video" title="'.$list[$i]['wr_subject'].'"></iframe>';
						$img[$i] .= '</div>';
					}
				} else if($img_thumb[$i]['src']) {
					$img[$i] = '<div class="visual-background '.$parallax.'" style="background:url('.$img_thumb[$i]['src'].') no-repeat center / cover;"></div>';
				}
		
				echo '<li class="swiper-slide">';
				echo $img[$i];
				if($list[$i]['wr_content'] || $list[$i]['wr_link1'] || $include[$i]) {
					echo '<div class="bannerContents">';
					if($include[$i]) include_once($include_path[$i]);
					echo '<div class="listCon">';
					if($isSubject[$i]) echo '<div class="subject '.$bl_font.'">'.$list[$i]['wr_subject'].'</div>';
					if($list[$i]['wr_short_con']) echo '<div class="wr_short_con">'.nl2br($list[$i]['wr_short_con']).'</div>';
					echo '<div class="wrCon">'.$list[$i]['wr_content'].'</div>';
					echo $list_btn_set[$i];
					echo '</div>';					
					echo '</div>';
				}
				echo '</li>';
			} ?>
		</ul>
		<?php if (count($list) == 0) echo '<div class="empty_list"></div>'; ?>
	</div>
</div>



<script>
var swiper =  new Swiper( '<?=$blockID?> .swiper-container', {
	effect: 'fade',
	spaceBetween: 0,
	slidesPerView: 1,
	pagination: {
		el: "<?=$blockID?> .swiper-pagination",
		clickable: true,
		type:  "bullets",
	},
	navigation: {
		prevEl: "<?=$blockID?> .prev",
		nextEl: "<?=$blockID?> .next",			
	},
	autoplay: {delay: 13000,disableOnInteraction:true},
	on: {		
		init : function() {
			$('<?=$blockID?> .timer').addClass('start');
			$('<?=$blockID?> .swiper-slide-active .visual-background').addClass('fullscreen-image');
			if ($('<?=$blockID?> .swiper-slide-active .video').length) {
				$('<?=$blockID?> .swiper-slide-active .video').get(0).play();
			}	
        },
        slideChangeTransitionEnd : function() {
			$('<?=$blockID?> .timer .inner').remove();
			$('<?=$blockID?> .timer').append('<span class="inner"></span>');	
			$('<?=$blockID?> .swiper-slide .visual-background').removeClass('fullscreen-image');
			$('<?=$blockID?> .swiper-slide-active .visual-background').addClass('fullscreen-image');
			$('<?=$blockID?> .swiper-slide .video').get(0).pause();
			if ($('<?=$blockID?> .swiper-slide-active .video').length) {
				$('<?=$blockID?> .swiper-slide-active .video').get(0).play();
			}
        }		
    },
	loop: true
});
</script>