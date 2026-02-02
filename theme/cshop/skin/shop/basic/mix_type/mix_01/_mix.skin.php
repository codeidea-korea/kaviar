<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


echo '<div class="mix-01-container">';

	echo '<ul class="itemsContainer slide-1" style="--items-radius:6px;padding-top:20px;">';
		if($shopblock['mix_li_1']) echo get_mix_banner($shopblock['mix_li_1'], '');	
		if($shopblock['mix_li_2']) echo get_mix_banner($shopblock['mix_li_2'], '');	
	echo '</ul>';

	echo '<div class="itemsContainer _slide itemSize_small mySwiper slide-2" data-per="1" data-gap="25" data-loop="false" style="--items-radius:6px;">';
		echo '<div class="swiper-container">';
			echo '<div class="swiper-wrapper">';
				if($shopblock['mix_li_3']) echo get_mix_banner($shopblock['mix_li_3'], '_slide');	
			echo '</div>';
		echo '</div>';
		
		echo '<div class="prev"></div>'.PHP_EOL;
		echo '<div class="next"></div>'.PHP_EOL;
	echo '</div>';
echo '</div>';