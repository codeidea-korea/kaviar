<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(!G5_IS_MOBILE) {
	echo '<div class="itemsContainer gr-1" data-per="1" data-gap="0" style="--items-radius:10px;width:50%;">';
		if($shopblock['mix_li_1']) echo get_mix_banner($shopblock['mix_li_1'], '');	
	echo '</div>';
}

echo '<div class="itemsContainer _slide mySwiper gr-2'.(!G5_IS_MOBILE?' itemSize_small':'').'" data-per="'.(G5_IS_MOBILE?'1.2':'2').'" data-gap="'.(G5_IS_MOBILE?'12':'20').'" data-loop="false" style="--items-radius:6px;'.(G5_IS_MOBILE?'':'width:50%;').'">';
	echo '<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';
			for($i=2; $i<=18; $i++) {
				if(!G5_IS_MOBILE) {
					if($shopblock['mix_li_'.$i]) echo get_mix_item($shopblock['mix_li_'.$i], '_slide', 350, 410);
				} else {
					if($shopblock['mix_li_'.$i]) echo get_mix_item($shopblock['mix_li_'.$i], '_slide', 450, 400);
				}
			}		
		echo '</div>';
	echo '</div>';
	
	if(!G5_IS_MOBILE) {
		echo '<div class="prev"></div>'.PHP_EOL;
		echo '<div class="next"></div>'.PHP_EOL;
	}
echo '</div>';