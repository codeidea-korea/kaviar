<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');
echo '<input type="file" name="bf_file[]" style="display:none">';
?>

<div class="mix-05 mixContainer">
	<label class="mix-thumb" style="<?=$thumb[1]['src']?'background-image:url('.$thumb[1]['ori'].')':''?>">						
		<input type="file" name="bf_file[]" accept="image/*" class="bgImg">
		<?=$thumb[1]['src']?'<label class="label-del"><input type="checkbox" id="bf_file_del1" name="bf_file_del[1]" value="1"><span></span>파일삭제</label>':''?>
	</label>
	<input type="hidden" name="bf_file_del[2]" value="1">
	<input type="hidden" name="bf_file_del[3]" value="1">
	<input type="hidden" name="bf_file_del[4]" value="1">
	<input type="hidden" name="bf_file_del[5]" value="1">
	<input type="hidden" name="bf_file_del[6]" value="1">
	<input type="hidden" name="bf_file_del[7]" value="1">
	<input type="hidden" name="bf_file_del[8]" value="1">
	<input type="hidden" name="bf_file_del[9]" value="1">
</div>