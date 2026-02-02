<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

@include_once $board_pcskin_path.'/list.head.skin.php'; //검색범위에 추가할 필드가 있는지 채크.
//<- $bo_search_sfl_arr = array("wr_1", "wr_2", "wr_3", "wr_4", "wr_5");
//<- $bo_search_name_arr = array("필드명1", "필드명2", "필드명3", "필드명4", "필드명5");
?>

<style>
.bootstrap-select.select-img .dropdown-toggle img{border:0;padding:5px;}
.bootstrap-select.select-img .dropdown-menu li img{border:0;}
</style>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_bo_search_setting_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="bo_skin" value="<?=$board['bo_skin']?>" id="bo_skin">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">
		<div class="form-list">
			<div class="form-label"><label>검색바 스킨</label></div>
			<div class="formCon">
				<?=get_skin_select_my('_boSearch', 'bo_search_skin', 'bo_search_skin', $board['bo_search_skin'], 'class="selectpicker select-img n3  label-OnOff" ', true)?>
				<input type="text" name="bo_search_color" value="<?=$board['bo_search_color']?>" class="colorpicker" id="bo_search_color" data-label="검색바 색상" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>검색범위</label></div>
			<div class="formCon">
				<select id="bo_search_sfl" name="bo_search_sfl[]" multiple class="selectpicker" data-label="범위선택">
					<?=option_multiple_selected_my('wr_subject', $board['bo_search_sfl'], "제목")?>
					<?=option_multiple_selected_my('wr_content', $board['bo_search_sfl'], "내용")?>
					<?=option_multiple_selected_my('wr_name', $board['bo_search_sfl'], "작성자")?>
					<?=option_multiple_selected_my('wr_tag', $board['bo_search_sfl'], "태그")?>
					<?php if($bo_search_sfl_arr) {
						for($i=0; $i<count($bo_search_sfl_arr); $i++) {
							$bo_search_name_arr[$i] = $bo_search_name_arr[$i] ? $bo_search_name_arr[$i] : $bo_search_sfl_arr[$i];
							echo option_multiple_selected_my($bo_search_sfl_arr[$i], $board['bo_search_sfl'], $bo_search_name_arr[$i]);							
						}
					} ?>					
				</select>
			</div>
		</div>
		
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>