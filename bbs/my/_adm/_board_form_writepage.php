<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists($board_pcskin_path.'/_board_form_writepage.php')) {
	echo '<span id="from-skin"></span>';
	require_once($board_pcskin_path.'/_board_form_writepage.php');
    return;
}
?>


<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_board_form_writepage_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label150">	
		 
		 <div class="form-list">
			<div class="form-label"><input type="text" name="bo_category_label" value="<?=$board['bo_category_label']?$board['bo_category_label']:'카테고리'?>" id="bo_category_label" class="w-full fw600" placeholder=""></div>
			<div class="formCon flex">
				<input type="text" name="bo_category_list" value="<?=get_text($board['bo_category_list'])?>" id="bo_category_list" class="frm_input flex1" placeholder="분류와 분류 사이는 | 로 구분하세요. 첫자로 #은 입력하지 마세요. 분류명에 일부 특수문자 ()/ 는 사용할수 없습니다.">
				<input type="checkbox" name="bo_use_category" value="1" id="bo_use_category" class="" <?=$board['bo_use_category']?'checked':''?> data-label="사용">
				<input type="checkbox" name="bo_cate_all_hidden" value="1"<?=$board['bo_cate_all_hidden']?' checked':''?> data-label="전체보기 사용안함">
			</div>
		</div>
		<div class="form-list">
			<div class="formCon flex">
				<input type="text" name="bo_tag_list" value="<?=get_text($board['bo_tag_list'])?>" id="bo_tag_list" class="span" data-class="flex1" data-label="#태그" placeholder="태그와 태그 사이는 | 로 구분하세요.">
				<input type="checkbox" name="bo_use_tag" value="1" id="bo_use_tag" class="" <?=$board['bo_use_tag']?'checked':''?> data-label="사용">
			</div>
		</div>

		<div class="form-list">
			<div class="form-label"><label>DHTML 에디터 사용</label></div>
			<div class="formCon">
				<!--<input type="checkbox" name="bo_use_dhtml_editor" value="1" <?=$board['bo_use_dhtml_editor']?'checked':'';?> id="bo_use_dhtml_editor" class="" data-label="사용">-->
				<select name="bo_use_dhtml_editor" id="bo_use_dhtml_editor" class="selectpicker" data-label="에디터 사용">
					<?=option_selected('', $board['bo_use_dhtml_editor'], "사용안함")?>
					<?=option_selected('1', $board['bo_use_dhtml_editor'], "PC만 사용")?>
					<?=option_selected('2', $board['bo_use_dhtml_editor'], "PC, 모바일 둘다 사용")?>
				</select>
				<input type="text" name="bo_editor_height" value="<?=$board['bo_editor_height']?>" id="bo_editor_height" class="frm_input" size="6" data-label="에디터 높이" data-label-inline="PX" data-class="ml15">
				<label class="ml25 mr5 bold">에디터 미적용시</label>
				<select id="bo_use_html_tag" name="bo_use_html_tag">
					<?=option_selected('html2', $board['bo_use_html_tag'], "자동 줄바꿈, html태그 둘다 적용")?>
					<?=option_selected('html', $board['bo_use_html_tag'], "자동 줄바꿈 적용")?>
					<?=option_selected('html1', $board['bo_use_html_tag'], "html태그 적용")?>
					<?=option_selected('', $board['bo_use_html_tag'], "내용쓰기 없음")?>
				</select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label><?=$autoSize?'첨부 이미지':'첨부파일'?></label></div>
			<div class="formCon">
				<?php if($autoSize) {
					echo '<input type="hidden" name="bo_upload_count" value="'.$board['bo_upload_count'].'">';					
				} else {
					echo '<input type="text" name="bo_upload_count" value="'.$board['bo_upload_count'].'" id="bo_upload_count" required class="required span50" size="4" data-label="첨부파일 개수" data-class="mr25" data-label-inline="개">';
				}
				$bo_upload_size = $board['bo_upload_size'] ? $board['bo_upload_size'] / 1048576 : $bo_upload_size;
				echo '<input type="text" name="bo_upload_size" value="'.$bo_upload_size.'" id="bo_upload_size" required class="required span60" size="3"  data-label="첨부 제한용량" data-label-inline="MB">';
				if($autoSize) {
					echo '<input type="hidden" name="bo_use_file_content" value="">';	
				} else {
					if(!G5_IS_MOBILE) {
						echo '<input type="checkbox" name="bo_use_file_content" value="1" id="bo_use_file_content"'.($board['bo_use_file_content']?' checked':'').' data-label="파일설명 쓰기" data-class="ml20">';
					} else {
						echo '<input type="hidden" name="bo_use_file_content" value="'.$board['bo_use_file_content'].'">';
					}
				}
				?>
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>