<?php
if (!defined('_GNUBOARD_')) exit;

$cf_default_style = explode("|",$config['cf_default_style']);
$cfm_menu_top_bg = explode("|",$config_mobile['cfm_menu_top_bg']);
$cfm_menu_color = explode("|",$config_mobile['cfm_menu_color']);
?>


<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_mobile_side_header_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><label>메뉴패널 해드 배경색</label></div>
			<div class="formCon flex flex-middle gap20">
				<input type="text" name="cfm_menu_top_bg[0]" value="<?=$cfm_menu_top_bg[0]?$cfm_menu_top_bg[0]:$cf_default_style[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">	
				<input type="text" name="cfm_menu_top_bg[1]" value="<?=$cfm_menu_top_bg[1]?$cfm_menu_top_bg[1]:$cf_default_style[2]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<span class="help-block">* 값이 없으면 사이트 기본컬러, 서브컬러가 기본이 됩니다</span>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>메뉴패널 배경색</label></div>
			<div class="formCon">
				<input type="text" name="cfm_menu_bg" value="<?=get_text($config_mobile['cfm_menu_bg'])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">	
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>메뉴 폰트컬러</label></div>
			<div class="formCon">
				<input type="text" name="cfm_menu_color[0]" value="<?=get_text($cfm_menu_color[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<input type="text" name="cfm_menu_color[1]" value="<?=$cfm_menu_color[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="활성화 메뉴 컬러" data-class="ml30"></label>
			</div>
		</div>
	</div>
</section>


<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>

<script>
setTimeout(function() {
	opener.$('body:not(.nav-visible) #header .menuOpener').click();
}, 500 );
</script>