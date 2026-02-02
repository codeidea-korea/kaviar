<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<div class="mix-form-group">
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=1; $i<=2; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img1" class="myfile">
				<div class="upImg">
					<?php
					$bl_img1 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_1';
					if (file_exists($bl_img1)) {
						$bl_img1_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_1">';
						$bl_img1_str .= '<label><input type="checkbox" name="del_bl_img1" value="1">삭제</label>';
					}
					if ($bl_img1_str) echo $bl_img1_str;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=3; $i<=4; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img2" class="myfile">
				<div class="upImg">
					<?php
					$bl_img2 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_2';
					if (file_exists($bl_img2)) {
						$bl_img2_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_2">';
						$bl_img2_str .= '<label><input type="checkbox" name="del_bl_img2" value="1">삭제</label>';
					}
					if ($bl_img2_str) echo $bl_img2_str;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=5; $i<=6; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img3" class="myfile">
				<div class="upImg">
					<?php
					$bl_img3 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_3';
					if (file_exists($bl_img3)) {
						$bl_img3_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_3">';
						$bl_img3_str .= '<label><input type="checkbox" name="del_bl_img3" value="1">삭제</label>';
					}
					if ($bl_img3_str) echo $bl_img3_str;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=7; $i<=8; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img4" class="myfile">
				<div class="upImg">
					<?php
					$bl_img4 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_4';
					if (file_exists($bl_img4)) {
						$bl_img4_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_4">';
						$bl_img4_str .= '<label><input type="checkbox" name="del_bl_img4" value="1">삭제</label>';
					}
					if ($bl_img4_str) echo $bl_img4_str;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=9; $i<=10; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img5" class="myfile">
				<div class="upImg">
					<?php
					$bl_img5 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_5';
					if (file_exists($bl_img5)) {
						$bl_img5_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_5">';
						$bl_img5_str .= '<label><input type="checkbox" name="del_bl_img5" value="1">삭제</label>';
					}
					if ($bl_img5_str) echo $bl_img5_str;
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="mix-li">
		<ul class="mix-formContainer" data-cols="2" data-gap="30">
			<?php for($i=11; $i<=12; $i++) {
				if($i && $i % 2 == 1) {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="banner" data-check-type="radio" style="--label-height:85%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				} else {
					echo '<li class="_form_li" data-num="'.$i.'">';
						echo '<label class="mix-list-label btn_list_of_select'.($shopblock['mix_li_'.$i]?' active':'').'" data-bl-type="item" data-check-type="radio" style="--label-height:64%;"><input type="text" name="mix_li_'.$i.'" value="'.$shopblock['mix_li_'.$i].'" id="mix_li_'.$i.'" readOnly></label>';
					echo '</li>';
				}
			} ?>
		</ul>
		<div class="mix_img">
			<div class="label">배경이미지</div>
			<div>
				<input type="file" name="bl_img6" class="myfile">
				<div class="upImg">
					<?php
					$bl_img6 = G5_DATA_PATH.'/shop_block/bl'.$shopblock['bl_id'].'_6';
					if (file_exists($bl_img6)) {
						$bl_img6_str = '<img src="'.G5_DATA_URL.'/shop_block/bl'.$shopblock['bl_id'].'_6">';
						$bl_img6_str .= '<label><input type="checkbox" name="del_bl_img6" value="1">삭제</label>';
					}
					if ($bl_img6_str) echo $bl_img6_str;
					?>
				</div>
			</div>
		</div>
	</div>
</div>