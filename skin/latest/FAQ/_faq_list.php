<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="bo_list">

	<div class="faqWrap">
		<?php for ($i=0; $i<count($list); $i++) {?>
		<div class="faq_li">
			<div class="faq-header">
				<header><span class="listNumber"><?php echo $i+1 ?></span></header>
				<?php if($cate_link_front[$i]) echo '<div class="faqCate"><a href="'.$list[$i]['ca_name_href'].'" class="cate_link">'.$list[$i]['ca_name'].'</a></div>'; ?>
				<div class="faqSubject skinOption-text-align skinOption-subject">
					<?=$list[$i]['subject']?>
					<?=$category_back[$i]?>
				</div>
			</div>
			<div class="faq-container skinOption-text-align skinOption-con">
				<?php
				if($list[$i]['wr_video']) { //비디오
					echo '<section class="bo_v_video">';						
					if(strpos($list[$i]['wr_video_src'], 'youtu') !== false) { 
						echo '<iframe src="https://www.youtube.com/embed/'.$list[$i]['wr_video'].'?rel=0&amp;controls=0&amp;showinfo=1&autoplay=0" frameborder="0" class="video" allowfullscreen></iframe>';
					} else if(strpos($list[$i]['wr_video_src'], 'vimeo') !== false) {
						echo '<iframe src="https://player.vimeo.com/video/'.$list[$i]['wr_video'].'?autoplay=0" frameborder="0" class="video" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
					} else if($list[$i]['wr_video_src']) {
						echo '<div class="video-container"><video src="'.$list[$i]['wr_video'].'" controls class="video"></video></div>';
					}
					echo '</section>';
				}

				if($board['bo_view_thumb']) { //첨부이미지 (뷰이미지 사용)
					$file_count = $board['bo_upload_count'];
					
					for($j=0; $j<$file_count; $j++) {
						$thumb[$j] = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 1, 0, false, true, 'center', false, '80/0.5/3', $j, false);
						if($thumb[$j]['src']) echo '<div class="mb10"><img src="'.$thumb[$j]['ori'].'"></div>';
					}
				}				
				if($include[$i]) include_once($include_path[$i]); //인크루드

				echo get_view_thumbnail($list[$i]['wr_content']);

				if($list[$i]['wr_link1']) { //첨부링크
					if($list[$i]['wr_link_name']) $attach_linkClass[$i] = 'buttonStyle';
					$linkName[$i] = $list[$i]['wr_link_name'] ? $list[$i]['wr_link_name'] : $list[$i]['link_href'][1];
					echo '<div class="attach_link '.$attach_linkClass[$i].'">';
					echo '	<a href="'.$list[$i]['wr_link1'].'" class="" target="_blank">'.$linkName[$i].'</a>';
					echo '</div>';
				}
				?>
				<?=$list_tag_set[$i]?>
			</div>
		</div>
		<?php } ?>
		<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>'; ?>
	</div>
</div>

<script>
$(function() {
	$('<?=$blockID?> .faqSubject').click(function() {
		$('<?=$blockID?> .faqSubject').not($(this)).parent().parent().find('.faq-container').slideUp(600, 'easeInOutExpo');
		$('<?=$blockID?> .faqSubject').not($(this)).parent().parent().removeClass('open');
		$(this).parent().parent().find('.faq-container').slideToggle(600, 'easeInOutExpo', function() {
			resizeVideo();
		});
		$(this).parent().parent().toggleClass('open');
	});
});
</script>