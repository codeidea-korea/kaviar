<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!G5_IS_MOBILE) {

	echo '<div class="itemsContainer _slide mySwiper" data-per="3" data-gap="25" data-group="3" data-loop="false" style="--items-radius:6px;">';
		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';
				for($i=1; $i<=18; $i++) {
					if($i && $i % 3 == 2) {
						if($shopblock['mix_li_'.$i]) echo get_mix_banner($shopblock['mix_li_'.$i], '_slide');
					} else {
						if($shopblock['mix_li_'.$i]) echo get_mix_item($shopblock['mix_li_'.$i], '_slide', 350, get_it_height(350));
					}
				}		
			echo '</div>';
		echo '</div>';
		
		echo '<div class="prev"></div>'.PHP_EOL;
		echo '<div class="next"></div>'.PHP_EOL;
	echo '</div>';
	
} else {
	
	echo '<div class="itemsContainer _slide mySwiper_banner bannerContainer" data-per="1" data-gap="25" data-loop="false" style="--items-radius:6px;">';
		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';
				for($i=1; $i<=18; $i++) {
					if($i && $i % 3 == 2) {
						if($shopblock['mix_li_'.$i]) echo get_mix_banner($shopblock['mix_li_'.$i], '_slide');
					}
				}		
			echo '</div>';
		echo '</div>';
	echo '</div>';

	echo '<div class="itemsContainer _slide itemSize_small mySwiper_items" data-per="2" data-gap="12" data-group="2" data-loop="false" style="--items-radius:6px;">';
		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';
				for($i=1; $i<=18; $i++) {
					if($i && $i % 3 == 2) {
					} else {
						if($shopblock['mix_li_'.$i]) echo get_mix_item($shopblock['mix_li_'.$i], '_slide', 350, get_it_height(350));
					}
				}		
			echo '</div>';
		echo '</div>';
		
		//echo '<div class="prev"></div>'.PHP_EOL;
		//echo '<div class="next"></div>'.PHP_EOL;
	echo '</div>';

}
?>

<script>
		
var swiper_banner =  new Swiper( '.mySwiper_banner .swiper-container', {
	spaceBetween: 15,
	slidesPerView: 1,
	//slidesPerGroup: itemGroup,
	pagination: {
		el: '.mySwiper_banner .pagination',
		clickable: true,
		type:  $('.mySwiper_banner .pagination').hasClass('fraction') ? "fraction" : "bullets",
	},
	navigation: {
		nextEl: '.mySwiper_banner .next',
		prevEl: '.mySwiper_banner .prev'
	},
	centeredSlides: false
});

var swiper_items =  new Swiper( '.mySwiper_items .swiper-container', {
	spaceBetween: 12,
	slidesPerView: 2.3,
	slidesPerGroup: 2,
	pagination: {
		el: '.mySwiper_items .pagination',
		clickable: true,
		type:  $('.mySwiper_items .pagination').hasClass('fraction') ? "fraction" : "bullets",
	},
	navigation: {
		nextEl: '.mySwiper_items .next',
		prevEl: '.mySwiper_items .prev'
	},
	centeredSlides: false		
});
/*
swiper_banner.controller.control = swiper_items;
swiper_items.controller.control = swiper_banner;
*/
</script>