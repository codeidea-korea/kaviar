<?php
if (!defined('_GNUBOARD_')) exit;
include_once(G5_BBS_PATH.'/my/_adm/_shop_item.lib.php');
include_once(G5_EDITOR_LIB);
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_item_content_update.php" onsubmit="return _adm_form_editor_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="it_id" value="<?=$_GET['it_id']?>">
<input type="hidden" name="close" value="<?=$_GET['close']?>">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section>
	<?=get_item_mini($it_id)?>
	<div class="formContainer label100">			
		<div class="form-list">
			<div class="formCon">			
				<div class="wrConBox ml20">
					<ul class="wrConTabs">
						<li class="icon_pc active" data-target="topCon">상단내용</li>
						<li class="icon_mobile" data-target="topCon_mob">모바일 상단내용</li>
					</ul>
					<div class="tabEditor topCon active">
						<?php echo editor_html("it_explan", get_text(html_purifier($it['it_explan']), 0), true, 650); ?>
					</div>
					<div class="tabEditor topCon_mob">
						<?php echo editor_html("it_mobile_explan", get_text(html_purifier($it['it_mobile_explan']), 0), true, 650); ?>
					</div>
				</div>				
			</div>
		</div>
	</div>
</section>



<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>



<script>
function _adm_form_editor_submit(f) {
	<?php echo get_editor_js("it_explan"); ?>
	<?php echo get_editor_js("it_mobile_explan"); ?>
    return true;
}
</script>