<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists($board_pcskin_path.'/_board_form_viewpage.php')) {
	echo '<span id="from-skin"></span>';
	require_once($board_pcskin_path.'/_board_form_viewpage.php');
    return;
}
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_board_form_viewpage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">
		<?php if(!G5_IS_MOBILE) { ?>
		<div class="form-list">
			<div class="form-label"><label for="bo_table_width">게시판 폭</label></div>
			<div class="formCon">
				<input type="text" name="bo_view_width" value="<?=$board['bo_view_width']?>" id="bo_view_width" class="percent span70" size="4" data-label="상세페이지" data-label-inline="PX">
				<span class="help-block ml10">기본 : <?=$board['bo_table_width']?><?=$board['bo_table_width']>100?'px':'%'?></span>
			</div>
		</div>
		<?php } else { ?>
		<input type="hidden" name="bo_view_width" value="<?=$board['bo_view_width']?>">
		<?php } ?>
		<div class="form-list">
			<div class="form-label"><label>기본항목 (상세)</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_view_thumb" value="1" <?=$board['bo_view_thumb']?'checked':''?> id="bo_view_thumb" data-label="첨부 이미지 보이기">
				<input type="checkbox" name="bo_view_writer" value="1" <?=$board['bo_view_writer']?'checked':'';?> id="bo_view_writer" data-label="작성자 보이기" data-class="ml20">
				<input type="checkbox" name="bo_view_date" value="1" <?=$board['bo_view_date']?'checked':'';?> id="bo_view_date" data-label="날짜 보이기" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>추천 기능</label></div>
			<div class="formCon">
				<input type="checkbox" name="bo_use_good" value="1" <?=$board['bo_use_good']?'checked':'';?> id="bo_use_good" data-label="추천기능 사용">
				<input type="checkbox" name="bo_use_good_guest" value="1" <?=$board['bo_use_good_guest']?'checked':'';?> id="bo_use_good_guest" data-label="비회원도 추천 가능" data-class="ml20">
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label for="bo_comment_level">댓글 쓰기 사용 & 권한</label></div>
			<div class="formCon">
				<?=get_member_level_select_my('bo_comment_level', 0, 10, $board['bo_comment_level'])?>
			</div>
		</div>
	</div>
</section>

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>