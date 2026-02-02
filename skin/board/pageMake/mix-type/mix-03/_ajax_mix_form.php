<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');
echo '<input type="file" name="bf_file[]" style="display:none">';
?>

<div class="mix-03 mixContainer">
	<div class="head">
		<label class="mix-thumb" style="<?=$thumb[1]['src']?'background-image:url('.$thumb[1]['ori'].')':''?>">						
			<input type="file" name="bf_file[]" accept="image/*" class="bgImg">
			<?=$thumb[1]['src']?'<label class="label-del"><input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"><span></span>파일삭제</label>':''?>
		</label>
		<div class="mix-con">
			<textarea name="wr1[0]" placeholder="텍스트" class="text-subject"><?=$wr[1][0]?></textarea>
			<textarea name="wr1[1]" placeholder="보조 텍스트" class="text-sub autosize" style="min-height:60px"><?=$wr[1][1]?></textarea>
			<input type="text" name="wr_sub1[0]" value="<?=$wr_sub[1][0]?>" placeholder="버튼 (생략가능)" class="span200">
			<div class="flex">
				<input type="text" name="wr_sub1[1]" value="<?=$wr_sub[1][1]?>" placeholder="http://" class="span small">
				<select name="wr_sub1[2]" value="<?=$wr_sub[1][2]?>" class="span120" data-style="selectColor-lightGray">
					<?php
					echo option_selected("_self",  $wr_sub[1][2], "바로 이동");
					echo option_selected("_blank",  $wr_sub[1][2], "새창 열기");
					echo option_selected("layer-popup",  $wr_sub[1][2], "레이어 팝업");
					echo option_selected("alert",  $wr_sub[1][2], "↑엘럿");
					?>
				</select>
			</div>
		</div>
	</div>

	<div class="body">
		<ul class="mix-ul">
			<?php for($i=2; $i<6; $i++) { ?>
			<li class="mix-li">
				<div class="mix-con">
					<textarea name="wr<?=$i?>[0]" placeholder="텍스트" class="text-subject"><?=$wr[$i][0]?></textarea>
					<textarea name="wr<?=$i?>[1]" placeholder="보조 텍스트" class="text-sub autosize" style="min-height:60px"><?=$wr[$i][1]?></textarea>
					<input type="text" name="wr_sub<?=$i?>[0]" value="<?=$wr_sub[$i][0]?>" placeholder="버튼" class="span200">
					<div class="flex">
						<input type="text" name="wr_sub<?=$i?>[1]" value="<?=$wr_sub[$i][1]?>" placeholder="http://" class="span small">
						<select name="wr_sub<?=$i?>[2]" value="<?=$wr_sub[$i][2]?>" class="span120" data-style="selectColor-lightGray">
							<?php
							echo option_selected("_self",  $wr_sub[$i][2], "바로 이동");
							echo option_selected("_blank",  $wr_sub[$i][2], "새창 열기");
							echo option_selected("layer-popup",  $wr_sub[$i][2], "레이어 팝업");
							echo option_selected("alert",  $wr_sub[$i][2], "↑엘럿");
							?>
						</select>
					</div>
				</div>
			</li>
			<?php } ?>			
		</ul>
	</div>
	<input type="hidden" name="bf_file_del[2]" value="1">
	<input type="hidden" name="bf_file_del[3]" value="1">
	<input type="hidden" name="bf_file_del[4]" value="1">
	<input type="hidden" name="bf_file_del[5]" value="1">
	<input type="hidden" name="bf_file_del[6]" value="1">
	<input type="hidden" name="bf_file_del[7]" value="1">
	<input type="hidden" name="bf_file_del[8]" value="1">
	<input type="hidden" name="bf_file_del[9]" value="1">
</div>