<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="mix-formContainer" data-cols="2" data-gap="20">
	<li class="_form_li">
		<ul class="flex column gap15">
			<li data-num="1">
				<label class="mix-list-label btn_list_of_select<?=$shopblock['mix_li_1']?' active':''?>" data-bl-type="banner" data-check-type="radio" style="--label-height:30%;"><input type="text" name="mix_li_1" value="<?=$shopblock['mix_li_1']?>" id="mix_li_1" readOnly></label>
			</li>
			<li data-num="2">
				<label class="mix-list-label btn_list_of_select<?=$shopblock['mix_li_2']?' active':''?>" data-bl-type="banner" data-check-type="radio" style="--label-height:30%;"><input type="text" name="mix_li_2" value="<?=$shopblock['mix_li_2']?>" id="mix_li_2" readOnly></label>
			</li>
		</ul>
	</li>
	<li class="_form_li" data-num="3">
		<label class="mix-list-label btn_list_of_select<?=$shopblock['mix_li_3']?' active':''?>" data-bl-type="banner" style="--label-height:65%;"><input type="text" name="mix_li_3" value="<?=$shopblock['mix_li_3']?>" id="mix_li_3" readOnly></label>
	</li>
</ul>
