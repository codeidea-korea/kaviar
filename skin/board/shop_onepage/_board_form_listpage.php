<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_board_form_viewpage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">
		<div class="form-list">
			<div class="form-label"><label>Header Type</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_subject_hide" value="1" <?=$board['bo_subject_hide']?'checked':'';?> data-label="기본타입으로 변경"></label>			
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>게시판 제목</label></div>
			<div class="formCon">
				<input type="text" name="bo_subject" value="<?=get_text($board['bo_subject'])?>" id="bo_subject" required size="80" maxlength="120">						
			</div>
		</div>
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>