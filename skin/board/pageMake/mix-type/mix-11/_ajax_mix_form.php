<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');
?>

<div class="formContainer label120 mb40">
	<div class="formGroup">
		<div class="form-list flex-top">
			<div class="form-label"><label>배경 이미지</label></div>
			<div class="formCon" style="max-width:420px">
				<input type="file" name="bf_file[]" class="myfile" accept="image/*">
				<div class="upImg">
					<?php if($upImg[0]) echo $upImg[0].'<label class="label-del"><input type="checkbox" id="bf_file_del0" name="bf_file_del[0]" value="1"><span></span>파일삭제</label>';?>
				</div>
			</div>
			<div class="form-label"><label class="label-video">백그라운드 동영상</label></div>
			<div class="formCon">
				<input type="hidden" name="wr_video_play" value="1">
				<input type="text" name="wr_video_src" value="<?=$write['wr_video_src']?>" id="wr_video_src" class="span" size="50" placeholder="mp4경로,&nbsp;&nbsp;&nbsp;(유투브) https://youtu.be/AbCdefGhiJK...,&nbsp;&nbsp;&nbsp;(비메오) https://vimeo.com/01234567...">
			</div>
		</div>
	</div>
</div>


<div class="mix-11 mixContainer">
	<ul class="mix-ul">
		<?php for($i=1; $i<10; $i++) { ?>
		<li class="mix-li">
			<label class="mix-thumb" style="<?=$thumb[$i]['src']?'background-image:url('.$thumb[$i]['ori'].')':''?>">						
				<input type="file" name="bf_file[]" accept="image/*" class="bgImg">
				<?=$thumb[$i]['src']?'<label class="label-del"><input type="checkbox" id="bf_file_del'.$i.'" name="bf_file_del['.$i.']" value="1"><span></span>파일삭제</label>':''?>
			</label>
			<div class="mix-con">
				<textarea name="wr<?=$i?>[0]" placeholder="텍스트" class="text-subject"><?=$wr[$i][0]?></textarea>
				<textarea name="wr<?=$i?>[1]" placeholder="보조 텍스트" class="text-sub autosize"><?=$wr[$i][1]?></textarea>
				<input type="text" name="wr_sub<?=$i?>[0]" value="<?=$wr_sub[$i][0]?>" placeholder="버튼명 (생략가능)" class="btn-name span">
				<input type="text" name="wr_sub<?=$i?>[1]" value="<?=$wr_sub[$i][1]?>" placeholder="http://" class="btn-url span small">
				<select name="wr_sub<?=$i?>[2]" value="<?=$wr_sub[$i][2]?>" class="btn-option" data-style="selectColor-lightGray">
					<?php
					echo option_selected("_self",  $wr_sub[$i][2], "바로 이동");
					echo option_selected("_blank",  $wr_sub[$i][2], "새창 열기");
					echo option_selected("layer-popup",  $wr_sub[$i][2], "레이어 팝업");
					echo option_selected("alert",  $wr_sub[$i][2], "↓엘럿");
					?>
				</select>
			</div>
		</li>
		<?php } ?>
	</ul>
</div>
