<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');
echo '<input type="file" name="bf_file[]" style="display:none">';
?>


<div class="mix-10 mixContainer">
	<ul class="mix-ul">		
		<?php for($i=1; $i<4; $i++) { ?>
		<li class="mix-li">
			<label class="mix-thumb" style="<?=$thumb[$i]['src']?'background-image:url('.$thumb[$i]['ori'].')':''?>">						
				<input type="file" name="bf_file[]" accept="image/*" class="bgImg">
				<?=$thumb[$i]['src']?'<label class="label-del"><input type="checkbox" id="bf_file_del'.$i.'" name="bf_file_del['.$i.']" value="1"><span></span>파일삭제</label>':''?>
			</label>			
		</li>
		<?php } ?>		
	</ul>

	<div class="flex gap50 mt20">		
		<?php for($i=1; $i<4; $i++) { ?>
		<div class="mix-con flex1">
			<textarea name="wr<?=$i?>[0]" placeholder="텍스트" class="text-subject"><?=$wr[$i][0]?></textarea>
			<textarea name="wr<?=$i?>[1]" placeholder="보조 텍스트" class="text-sub autosize" style="min-height:60px"><?=$wr[$i][1]?></textarea>
			<input type="text" name="wr_sub<?=$i?>[0]" value="<?=$wr_sub[$i][0]?>" placeholder="버튼" class="span200">
			<input type="text" name="wr_sub<?=$i?>[1]" value="<?=$wr_sub[$i][1]?>" placeholder="http://" class="span small">
			<select name="wr_sub<?=$i?>[2]" value="<?=$wr_sub[$i][2]?>" class="span120 btn-option" data-style="selectColor-lightGray">
				<?php
				echo option_selected("_self",  $wr_sub[$i][2], "바로 이동");
				echo option_selected("_blank",  $wr_sub[$i][2], "새창 열기");
				echo option_selected("layer-popup",  $wr_sub[$i][2], "레이어 팝업");
				echo option_selected("alert",  $wr_sub[$i][2], "↑엘럿");
				?>
			</select>
		</div>
		<?php } ?>
	</div>
	
	<input type="hidden" name="bf_file_del[7]" value="1">
	<input type="hidden" name="bf_file_del[8]" value="1">
	<input type="hidden" name="bf_file_del[9]" value="1">
</div>