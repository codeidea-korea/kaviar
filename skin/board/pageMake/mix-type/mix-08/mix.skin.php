<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($list[$i]['bl_title'] || $isContent[$i]) {
	echo '<div class="textCon '.$bl_text_align[$i][0].'">'.PHP_EOL;
	if($list[$i]['bl_title']) echo '<div class="block-title scrollMotion'.($bl_font?' '.$bl_font:'').'">'.nl2br($list[$i]['bl_title']).'</div>'.PHP_EOL;
	if($isContent[$i]) echo '<div class="contents scrollMotion">'.stripslashes($list[$i]['wr_content']).'</div>'.PHP_EOL;
	echo $list_btn_set[$i];
	echo '</div>';
}
?>

<section class="mixWrap gallerySwiper">		
	<div class="mix-08 mixContainer swiper-container">
		<span class="btn-slide prev"></span>
		<span class="btn-slide next"></span>
		<ul class="mix-ul swiper-wrapper">			
			<?php for($x=1; $x<9; $x++) {
				if($thumb[$x][$i]['src'] || $wr[$x][$i][0] || $wr[$x][$i][1] || ($wr_sub[$x][$i][0] && $wr_sub[$x][$i][1])) {
					echo '<li class="mix-li swiper-slide">';
					echo '<div class="mix-thumb" style="'.($thumb[$x][$i]['src']?'background-image:url('.$thumb[$x][$i]['ori'].')':'').'"></div>';
					echo '<div class="mix-con">';
					if($wr[$x][$i][0]) echo '<p class="text-subject">'.nl2br($wr[$x][$i][0]).'</p>';
					if($wr[$x][$i][1]) echo '<p class="text-sub">'.nl2br($wr[$x][$i][1]).'</p>';
					if($mix_link[$x][$i] && $wr_sub[$x][$i][0]) echo $mix_link[$x][$i].'<span class="mix-btn type02">'.$wr_sub[$x][$i][0].'</span></a>';
					echo '</div>';					
					echo '</li>';
				}
			} ?>
		</ul>
	</div>
	<div class="swiper-pagination bottom-pager"></div>
</section>

<script>
var mySwiper =  new Swiper("<?=$blockID[$i]?> .gallerySwiper .swiper-container",{
	pagination: "<?=$blockID[$i]?> .swiper-pagination",
	nextButton: "<?=$blockID[$i]?> .next",
	prevButton: "<?=$blockID[$i]?> .prev",
	slidesPerView: 1,
	spaceBetween: 0,
	autoHeight: true,
	paginationClickable: true,
	autoplay: 6000,
	loop: false
});
</script>