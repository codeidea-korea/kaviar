<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

/*─────────────────────────────────────────────────
										관리자 간편 등록
─────────────────────────────────────────────────*/
if($board['bo_skin'] == 'gallery-grid') echo '<link rel="stylesheet" href="'.get_url($board_skin_url.'/style.css').'">';
?>


<form name="fwrite" id="fwrite" action="<?=G5_BBS_URL?>/my/_adm/_write_form_update.php" onsubmit="return fwrite_form_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="wr_file_count" value="2"><!--이미지(첨부파일)사용시 첨부파일 갯수를 2로 고정-->
<input type="hidden" name="callback_url" value="<?=$callback_url?>">
	
<section class="mybox blue blue-bg">
	<div class="formContainer label130">
		<?php
		echo $form_gall_file;
		echo $form_video;
		?>
	</div>
</section>

<section class="flex mt25">
	<?php
	if($board['bo_use_category']) {
		$category_option = get_category_option($bo_table, $write['ca_name']);
		echo '<select name="ca_name" id="ca_name" class="ca_name selectpicker" data-label="분류">';
		echo option_selected("",  $write['ca_name'], "- 분류 없음 -");
		echo $category_option;
		echo '</select>';
	}
	echo '<input type="text" name="wr_subject" value="" id="wr_subject" required class="span" maxlength="255" style="padding:0 10px;" data-label="제목" placeholder="제목을 입력해주세요.">';
	?>
</section>

<section class="mt10" style="padding-left:20px">
	<textarea name="wr_short_con" class="span autosize label" style="min-height:70px;" placeholder="목록페이지에 본문 대신 사용할 문구" data-label="문구" data-class="mb10"></textarea>
	<div class="wrConBox">
		<ul class="wrConTabs">
			<li class="active icon_pc" data-target="pcCon" title="PC">내용</li>
			<li class="icon_mobile" data-target="mobileCon" title="모바일">모바일 내용</li>
		</ul>
		<div class="tabEditor pcCon active"><?=$editor_html?></div>
		<div class="tabEditor mobileCon"><?=$editor_mobile_html?></div>
	</div>
</section>	

<div class="_adm_btnSet">
	<input type="submit" value="등록하기" class="btn_submit btn" accesskey="s">
</div>
</form>	


<script>
function fwrite_form_submit(f){
	<?=get_editor_js("wr_content")?>
    <?=get_editor_js("wr_content_mobile")?>
    return true;
}
</script>