<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$perview = count($list) > $colspan ? $colspan : count($list);
?>

<div class="gallerySwiper perview-<?=$colspan?>" data-per="<?=$perview?>" data-gap="<?=$distance?>">
	<?php if(count($list) > $colspan) {
		echo '<span class="btn-slide prev"></span>'.PHP_EOL;
		echo '<span class="btn-slide next"></span>'.PHP_EOL;
	} ?>
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php for ($i=0; $i<count($list); $i++) {
				echo '<div class="swiper-slide '.$skinOption_frame.'" id="'.$bo_table.'_'.$list[$i]['wr_id'].'" data-subject="'.$list[$i]['subject'].'" style="'.$slideHeight_css.'">';
				echo $gallContents[$i];
				echo '</div>';
			} ?>
		</div>
	</div>

	<?php
	if(count($list) > $colspan) echo '<div class="swiper-pagination '.$pagerType.' bottom-pager"></div>';
	if(count($list) == 0) echo '<div class="empty_list" data-text="게시물이 없습니다."></div>';
	?>
</div>

<script>
var swiper =  new Swiper( '<?=$blockID?> .gallerySwiper .swiper-container', {
	spaceBetween: <?=$distance?>,
	slidesPerView: <?=$perview?>,
	pagination: {
		el: "<?=$blockID?> .swiper-pagination",
		clickable: true,
		type:  "bullets",
	},
	navigation: {
		prevEl: "<?=$blockID?> .prev",
		nextEl: "<?=$blockID?> .next",			
	},
	<?php if($perColumn) echo 'slidesPerColumn: '.$perColumn.','; ?>
	<?php if($centeredSlides) echo 'centeredSlides: true,'; ?>
	<?php if($autoplay) {?>
	autoplay: {delay: <?=$autoplay?>,disableOnInteraction:true},
	<?php } ?>
	<?php if($loop) echo 'loop: true,'; ?>
	<?php if($board['bo_max_screen'] && !G5_IS_MOBILE) {
		//안맞음 나중에 정리
		/*echo 'breakpoints: {';
		echo ($breakpoints[0]+1).':{slidesPerView:'.$perview.'},';
		for ($s=0; $s<count($bo_max_screen); $s++) {
			echo $breakpoints[$s].': {';
			echo 'slidesPerView: '.$newCols[$s].'';
			echo '},';
		}
		echo '300:{slidesPerView:1},';
		echo '},';*/
	} ?>
});


<?php if($slideHeight == 'auto') { ?>
$(document).ready(function() {
	$('<?=$blockID?> .gallerySwiper .swiper-slide').each(function() {
		var sh = $(this).parent().parent().parent().outerHeight();
		$(this).css({'height': sh});
	});
});
<?php } ?>
</script>