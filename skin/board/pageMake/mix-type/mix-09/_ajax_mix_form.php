<?php
include_once('../../../../../common.php');
include_once($board_skin_path.'/mix-type/_mix_form.lib.php');
echo '<input type="file" name="bf_file[]" style="display:none">';
?>


<div class="mix-09 mixContainer">
	<?php
	echo '<div class="typeControl">';
	echo '<select name="latest_list_style" value="'.$write['latest_list_style'].'" id="latest_list_style" class="select-img" data-id="listStyle">';
	echo option_selected_my("",  $write['latest_list_style'], "type01", "data-content=\"<img src='".get_url($board_skin_url."/mix-type/mix-09/img/type01.gif")."' alt='type-01'><span class='skin_name'>타입 01</span>\"");
	echo option_selected_my("type02",  $write['latest_list_style'], "type02", "data-content=\"<img src='".get_url($board_skin_url."/mix-type/mix-09/img/type02.gif")."' alt='type-02'><span class='skin_name'>타입 02</span>\"");
	echo '</select>';
	
	echo '<select name="latest_gall_cols" value="'.$write['latest_gall_cols'].'" id="latest_gall_cols" class="mr20" data-label="버튼 가로수">';
	echo option_selected_my("",  $write['latest_gall_cols'], "기본값", "data-content='기본값 <small>(4)</small>'");
	echo option_selected_my("1",  $write['latest_gall_cols'], "1");
	echo option_selected_my("2",  $write['latest_gall_cols'], "2");
	echo option_selected_my("3",  $write['latest_gall_cols'], "3");
	echo option_selected_my("4",  $write['latest_gall_cols'], "4");
	echo option_selected_my("5",  $write['latest_gall_cols'], "5");
	echo option_selected_my("6",  $write['latest_gall_cols'], "6");
	echo '</select>';
	echo '</div>';
	?>

	<ul class="mix-ul">
		<?php for($i=1; $i<11; $i++) { ?>
		<li class="mix-li">
			<div class="mix-con">
				<input type="text" name="wr<?=$i?>[0]" value="<?=$wr[$i][0]?>" placeholder="버튼" class="btn-name span">
				<input type="text" name="wr<?=$i?>[1]" value="<?=$wr[$i][1]?>" placeholder="http://" class="btn-url span small">
				<select name="wr<?=$i?>[2]" value="<?=$wr[$i][2]?>" class="btn-option" data-style="selectColor-lightGray">
					<?php
					echo option_selected("_self",  $wr[$i][2], "바로 이동");
					echo option_selected("_blank",  $wr[$i][2], "새창 열기");
					echo option_selected("layer-popup",  $wr[$i][2], "레이어 팝업");
					echo option_selected("alert",  $wr[$i][2], "↑엘럿");
					?>
				</select>				
			</div>
		</li>
		<?php } ?>

		<?php for($i=1; $i<11; $i++) { ?>
		<li class="mix-li">
			<div class="mix-con">
				<input type="text" name="wr_sub<?=$i?>[0]" value="<?=$wr_sub[$i][0]?>" placeholder="버튼" class="btn-name span">
				<input type="text" name="wr_sub<?=$i?>[1]" value="<?=$wr_sub[$i][1]?>" placeholder="http://" class="btn-url span small">
				<select name="wr_sub<?=$i?>[2]" value="<?=$wr_sub[$i][2]?>" class="btn-option" data-style="selectColor-lightGray">
					<?php
					echo option_selected("_self",  $wr_sub[$i][2], "바로 이동");
					echo option_selected("_blank",  $wr_sub[$i][2], "새창 열기");
					echo option_selected("layer-popup",  $wr_sub[$i][2], "레이어 팝업");
					echo option_selected("alert",  $wr_sub[$i][2], "↑엘럿");
					?>
				</select>				
			</div>
		</li>
		<?php } ?>		
	</ul>
	<input type="hidden" name="bf_file_del[2]" value="1">
	<input type="hidden" name="bf_file_del[3]" value="1">
	<input type="hidden" name="bf_file_del[4]" value="1">
	<input type="hidden" name="bf_file_del[5]" value="1">
	<input type="hidden" name="bf_file_del[6]" value="1">
	<input type="hidden" name="bf_file_del[7]" value="1">
	<input type="hidden" name="bf_file_del[8]" value="1">
	<input type="hidden" name="bf_file_del[9]" value="1">
</div>


<script>
function mixColsChange(num) {
	let mix_ul = $('.mix-ul'),
		row = typeof num !== typeof undefined && num !== '' ? num : '4';
	mix_ul.removeClass();
	mix_ul.addClass('mix-ul row-' + row);
}

$(document).ready(function(){
	let mix_li_cols = $('#latest_gall_cols');
	mixColsChange(mix_li_cols.val());
	mix_li_cols.change(function (){
		mixColsChange($(this).val());		
	});
});
</script>