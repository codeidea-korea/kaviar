<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
add_stylesheet('<link rel="stylesheet" href="'.get_url($board_pcskin_url.'/'.$css).'">', 3);
?>

<div class="flex flex-middle">
	<?php if($is_bo_title) echo $bo_title; ?>
	<div class="<?=!G5_IS_MOBILE?'ml-auto':'w-full'?>"><?php if($category_menu) echo boCategory($bo_cate_skin, $bo_table); ?></div>
</div>

<div class="bo_list">

	<?=$tagsGroup?>

	<?php //if($board['bo_search_skin']) echo boSearch($board['bo_search_skin'], $bo_table); ?>

    <form name="fboardlist" id="fboardlist" action="<?=G5_BBS_URL?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="shop_faq">
        <?php for ($i=0; $i<count($list); $i++) {?>
		<div class="faq_li">
			
			<div class="faq-header">
				<label class="edit-mode"><input type="checkbox" name="chk_wr_id[]" value="<?=$list[$i]['wr_id']?>" id="chk_wr_id_<?=$i?>"><i class="sound_only"><?=$list[$i]['subject']?></i></label>
				<?php if($list[$i]['ca_name']) echo '<div class="faqCate">'.$list[$i]['ca_name'].'</div>'; ?>
				<div class="faqSubject skinOption-text-align skinOption-subject">					
					<?=$list[$i]['subject']?>
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

				echo get_view_thumbnail($list[$i]['content']);
				
				echo $list_tag_set[$i];

				echo $list_btn_set[$i];

				if($edit_href[$i]) {
					echo '<div class="faqBtn">';
						echo '<a href="'.$edit_href[$i].'"><span class="btnEdit '.$includeOn[$i].'">수정</span></a>';
					echo '</div>';
				}
				?>
			</div>
		</div>
		<?php } ?>
		<?php if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>'; ?>
    </div>
	
	<?php include_once(G5_BBS_PATH.'/my/list_btnSet.php'); ?>

    </form>

	<?=$write_pages?>

</div>

<script>
$(function() {
	$('.faqSubject').click(function() {
		$('.faqSubject').not($(this)).parent().parent().find('.faq-container').slideUp(600, 'easeInOutExpo');
		$('.faqSubject').not($(this)).parent().parent().removeClass('open');
		$(this).parent().parent().find('.faq-container').slideToggle(500, 'easeInOutExpo', function() {
			resizeVideo();
		});
		$(this).parent().parent().toggleClass('open');
	});
});
</script>

<?php if($is_checkbox) include_once(G5_BBS_PATH.'/my/list_script.php'); ?>