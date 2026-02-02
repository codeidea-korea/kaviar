<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_bo_cate_setting_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="bo_skin" value="<?=$board['bo_skin']?>" id="bo_skin">
<input type="hidden" name="bo_category_label" value="<?=$board['bo_category_label']?>">
<input type="hidden" name="bo_category_list" value="<?=$board['bo_category_list']?>">
<input type="hidden" name="bo_tag_list" value="<?=$board['bo_tag_list']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">
		<div class="form-list">
			<div class="form-label">
				<label class="span"><input type="text" name="bo_category_label" value="<?=$board['bo_category_label']?>" id="bo_category_label" class="frm_input span" style="font-weight:bold;" size="15" placeholder="카테고리"></label>
			</div>
			<div class="formCon flex">
				<input type="text" name="bo_category_list" value="<?=get_text($board['bo_category_list'])?>" id="bo_category_list" class="frm_input flex1" placeholder="분류와 분류 사이는 | 로 구분하세요. 첫자로 #은 입력하지 마세요. 분류명에 일부 특수문자 ()/ 는 사용할수 없습니다.">
				<input type="checkbox" name="bo_cate_all_hidden" value="1"<?=$board['bo_cate_all_hidden']?' checked':''?> data-label="전체 분류 사용안함">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>카테고리 스킨</label></div>
			<div class="formCon">
				<?=get_skin_select_my('_boCategory', 'bo_cate_skin', 'bo_cate_skin', $board['bo_cate_skin'], 'class="select-img n3 span300 mr20" ', true)?>
				<input type="text" name="bo_cate_color" value="<?=$board['bo_cate_color']?>" class="colorpicker" id="bo_cate_color" data-label="카테고리 메뉴 색상" data-class="ml20" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
			</div>
		</div>
	</div>
</section>	

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>