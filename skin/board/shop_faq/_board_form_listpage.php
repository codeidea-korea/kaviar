<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<?=$bo_inc_info?>

<form name="_adm_form" id="_adm_form" action="<?=G5_BBS_URL?>/my/_adm/_board_form_listpage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="bo_skin" value="<?=$board['bo_skin']?>" id="bo_skin">
<input type="hidden" name="bo_category_label" value="플로팅 메뉴">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label140">
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

<?php
echo '<section class="mybox blue '.($board['bo_use_category'] || $board['bo_use_tag']?'':'hide').'">';
echo '<h2 class="mybox-title toggle">분류</h2>';
echo '<div class="formContainer label170">';
//카테고리
echo '<div class="form-list">';
echo '<div class="form-label">';
echo '<label class="w-full"><input type="text" name="bo_category_label" value="'.$board['bo_category_label'].'" id="bo_category_label" class="frm_input w-full" style="font-weight:bold;" size="15" placeholder="카테고리"></label>';
echo '</div>';
echo '<div class="formCon flex gap15">';
echo '<input type="text" name="bo_category_list" value="'.get_text($board['bo_category_list']).'" id="bo_category_list" class="frm_input flex1" placeholder="분류와 분류 사이는 | 로 구분하세요. 첫자로 #은 입력하지 마세요. 분류명에 일부 특수문자 ()/ 는 사용할수 없습니다.">';
echo '<input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" '.($board['bo_use_category']?'checked':'').' data-label="사용">';
echo '<input type="checkbox" name="bo_cate_all_hidden" value="1"'.($board['bo_cate_all_hidden']?' checked':'').' data-label="전체보기 사용안함">';
echo '</div>';
echo '</div>';
echo '</section>';			
?>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>