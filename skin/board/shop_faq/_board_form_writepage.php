<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>


<form name="_adm_form" id="_adm_form" action="<?=G5_BBS_URL?>/my/_adm/_board_form_writepage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">	
		<div class="form-list">
			<div class="form-label"><label>DHTML 에디터 사용</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_use_dhtml_editor" value="1" <?=$board['bo_use_dhtml_editor']?'checked':'';?> id="bo_use_dhtml_editor" class="" data-label="사용">
				<input type="text" name="bo_editor_height" value="<?=$board['bo_editor_height']?>" id="bo_editor_height" class="frm_input" size="6" data-label="에디터 높이" data-label-inline="PX" data-class="ml15">
				<label class="ml25 mr5 bold">에디터 미적용시</label>
				<select id="bo_use_html_tag" name="bo_use_html_tag">
					<?=option_selected('html2', $board['bo_use_html_tag'], "자동 줄바꿈, html태그 둘다 적용")?>
					<?=option_selected('html', $board['bo_use_html_tag'], "자동 줄바꿈 적용")?>
					<?=option_selected('html1', $board['bo_use_html_tag'], "html태그 적용")?>
					<?=option_selected('noCon', $board['bo_use_html_tag'], "내용쓰기 없음")?>
				</select>
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>