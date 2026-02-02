<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_EDITOR_LIB);
?>


<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_login_intro_head_update.php" onsubmit="return _adm_form_editor_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label190">
		<div class="form-list column">
			<div class="form-label"><label>로그인 상단 문구</label></div>
			<div class="formCon">
				<?php echo editor_html("shop_login_intro_head_content", get_text(html_purifier($default['shop_login_intro_head_content']), 0), true, 300); ?>
			</div>
		</div>
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>


<script>
function _adm_form_editor_submit(f) {
	<?php echo get_editor_js("shop_login_intro_head_content"); ?>
    return true;
}
</script>