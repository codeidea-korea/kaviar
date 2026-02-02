<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$cf_default_style = explode("|",$config['cf_default_style']);
$cf_default_color = explode("|",$config['cf_default_color']);
?>

<style>
#colorpick_list{display:flex;align-items:center;flex-wrap:wrap;gap:15px;margin-top:20px;}
#colorpick_list .plus:before{content:'\e928';font-family:'intaefont';font-size:10px;margin-top:-3px;vertical-align:middle;display:inline-block;}
#colorpick_list .defSwathColor{width:19px;height:19px;border-radius:2px;display:inline-flex;align-items:center;justify-content:center;}
.labelColor-hidden{}
</style>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_adm_default_style_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><label>기본 폰트</label></div>
			<div class="formCon">
				<select name="cf_default_style[0]" class="font-family">
					<?php
					for($i=0; $i<count($_font_name); $i++) {
						echo option_selected_my($_font_family[$i], $cf_default_style[0], $_font_name[$i], "data-content='<span class=\"fs13 ".$_font_family[$i]."\">".$_font_name[$i]."</span>'");
					}
					?>
				</select>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>사이트 메인 컬러</label></div>
			<div class="formCon">
				<input type="text" name="cf_default_style[1]" value="<?=$cf_default_style[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<span class="help-block ml20">※각종 버튼 등에 사용됩니다. 대부분의 버튼은 해당 버튼을 생성시 개별 설정을 할수 있습니다.</span>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label"><label>사이트 서브 컬러</label></div>
			<div class="formCon">
				<input type="text" name="cf_default_style[2]" value="<?=$cf_default_style[2]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<span class="help-block ml20">※각종 버튼(hover) 등에 사용됩니다. 대부분의 버튼은 해당 버튼을 생성시 개별 설정을 할수 있습니다.</span>
			</div>
		</div>
		<div class="form-list">
			<div class="form-label flex-top"><label>자주 사용할 컬러</label></div>
			<div class="formCon" style="min-height:135px">
				<p class="help-block mb10">※컬러 입력시 선택할수 있는 기본 컬러를 미리 지정할수 있습니다.</p>
				<img src="<?=G5_IMG_URL?>/my/colorpicker_default.png" style="position:absolute;top:10px;right:10px;">
				<ul id="colorpick_list">
					<?php
					if($cf_default_style[1]) echo '<span class="defSwathColor" style="background:'.$cf_default_style[1].'"></span>';
					if($cf_default_style[2]) echo '<span class="defSwathColor" style="background:'.$cf_default_style[2].'"></span>';
					if($cf_default_style[1] || $cf_default_style[2]) echo '<span class="plus"></span>';
					?>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[0]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[1]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[2]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[3]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[4]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[5]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[6]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[7]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[8]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[9]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
					<label class="labelColor-hidden"><input type="text" name="cf_default_color[]" value="<?=$cf_default_color[10]?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#"></label>
				</ul>
			</div>
		</div>
	</div>
</section>

<div class="_adm_btnSet">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>
