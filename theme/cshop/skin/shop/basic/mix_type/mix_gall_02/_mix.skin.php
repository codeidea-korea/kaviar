<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가


if(!G5_IS_MOBILE) {
	echo '<div class="itemsContainer _gall itemSize_small" data-cols="5" data-gap="17" style="--items-radius:5px;">';
		for($i=1; $i<=18; $i++) {
			if($i && $i % 5 == 1) {
				if($shopblock['mix_li_'.$i]) echo get_mix_banner($shopblock['mix_li_'.$i], '_gall');
			} else {
				if($shopblock['mix_li_'.$i]) echo get_mix_item($shopblock['mix_li_'.$i], '_gall', 350, 430);
			}
		}
	echo '</div>';
} else {
	
	if($shopblock['mix_li_1']) {
		echo '<div class="itemsContainer _gall itemSize_small" data-cols="1" style="--items-radius:5px;">';
			echo get_mix_banner($shopblock['mix_li_1'], '_gall');
		echo '</div>';
	}
	$mix_gall_02_str = '';
	for($i=2; $i<=5; $i++) {
		if($shopblock['mix_li_'.$i]) $mix_gall_02_str .= get_mix_item($shopblock['mix_li_'.$i], '_gall', 350, 430);
	}	
	if($mix_gall_02_str) echo '<div class="mt20 itemsContainer _gall itemSize_small" data-cols="2" data-gap="10" style="--items-radius:5px;">'.$mix_gall_02_str.'</div>';

	if($shopblock['mix_li_6']) {
		echo '<div class="mt40 itemsContainer _gall itemSize_small" data-cols="1" style="--items-radius:5px;">';
			echo get_mix_banner($shopblock['mix_li_6'], '_gall');
		echo '</div>';
	}
	$mix_gall_02_str = '';
	for($i=7; $i<=10; $i++) {
		if($shopblock['mix_li_'.$i]) $mix_gall_02_str .= get_mix_item($shopblock['mix_li_'.$i], '_gall', 350, 430);
	}	
	if($mix_gall_02_str) echo '<div class="mt20 itemsContainer _gall itemSize_small" data-cols="2" data-gap="10" style="--items-radius:5px;">'.$mix_gall_02_str.'</div>';

	if($shopblock['mix_li_11']) {
		echo '<div class="mt40 itemsContainer _gall itemSize_small" data-cols="1" style="--items-radius:5px;">';
			echo get_mix_banner($shopblock['mix_li_11'], '_gall');
		echo '</div>';
	}
	$mix_gall_02_str = '';
	for($i=12; $i<=15; $i++) {
		if($shopblock['mix_li_'.$i]) $mix_gall_02_str .= get_mix_item($shopblock['mix_li_'.$i], '_gall', 350, 430);
	}	
	if($mix_gall_02_str) echo '<div class="mt20 itemsContainer _gall itemSize_small" data-cols="2" data-gap="10" style="--items-radius:5px;">'.$mix_gall_02_str.'</div>';

	if($shopblock['mix_li_16']) {
		echo '<div class="mt40 itemsContainer _gall itemSize_small" data-cols="1" style="--items-radius:5px;">';
			echo get_mix_banner($shopblock['mix_li_16'], '_gall');
		echo '</div>';
	}
	$mix_gall_02_str = '';
	for($i=17; $i<=20; $i++) {
		if($shopblock['mix_li_'.$i]) $mix_gall_02_str .= get_mix_item($shopblock['mix_li_'.$i], '_gall', 350, 430);
	}	
	if($mix_gall_02_str) echo '<div class="mt20 itemsContainer _gall itemSize_small" data-cols="2" data-gap="10" style="--items-radius:5px;">'.$mix_gall_02_str.'</div>';

}