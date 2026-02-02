<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="mix-formContainer flex1 mr20" data-cols="1" data-gap="30">
	<?php
	echo '<li class="_form_li" data-num="1">';
		echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_1']?' active':'').'" data-bl-type="banner" data-check-type="radio" ><input type="text" name="mix_li_1" value="'.$shopblock['mix_li_1'].'" id="mix_li_1" readOnly></label>';
	echo '</li>';
	?>
</ul>

<ul class="mix-formContainer" data-cols="2" data-gap="20" style="width:50%" data-start-num="2">
	<?php for($i=2; $i<=19; $i++) {
		echo '<li class="_form_li" data-num="'.$i.'">';
			echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:120%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
		echo '</li>';
	} ?>
</ul>
