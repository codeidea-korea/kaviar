<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="mix-formContainer" data-cols="5" data-gap="15">
	<?php for($i=1; $i<=20; $i++) {
		if($i && $i % 5 == 1) {
			echo '<li class="_form_li" data-num="'.$i.'">';
				echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:160%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
			echo '</li>';
		} else {
			echo '<li class="_form_li" data-num="'.$i.'">';
				echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:110%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
			echo '</li>';
		}
	} ?>
</ul>
