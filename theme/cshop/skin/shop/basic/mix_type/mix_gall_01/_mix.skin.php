<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가






echo '<div class="itemsContainer _slide itemSize_small mySwiper" data-per="3" data-gap="25" data-group="3" data-loop="false" style="--items-radius:10px;">';
	echo '<div class="swiper-container">';
		echo '<div class="swiper-wrapper">';		

			if($shopblock['mix_li_1']) echo get_mix_item($shopblock['mix_li_1'], '_slide', 350, 350);

			if($shopblock['mix_li_2']) echo get_mix_banner($shopblock['mix_li_2'], '_slide');

			if($shopblock['mix_li_3']) echo get_mix_item($shopblock['mix_li_3'], '_slide', 350, 350);

			if($shopblock['mix_li_4']) echo get_mix_item($shopblock['mix_li_4'], '_slide', 350, 350);

			if($shopblock['mix_li_5']) echo get_mix_banner($shopblock['mix_li_5'], '_slide');

			if($shopblock['mix_li_6']) echo get_mix_item($shopblock['mix_li_6'], '_slide', 350, 350);
		
		echo '</div>';
	echo '</div>';
	
	echo '<div class="prev"></div>'.PHP_EOL;
	echo '<div class="next"></div>'.PHP_EOL;
echo '</div>';