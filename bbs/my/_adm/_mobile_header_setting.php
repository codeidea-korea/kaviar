<?php
if (!defined('_GNUBOARD_')) exit;

$cfm_top_bg = explode("|",$config_mobile['cfm_top_bg']);
?>


<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_mobile_header_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section id="header_topSection" class="mybox blue">
	<p class="help-block mt10 ml10">※ 두가지 버전 모두 업로드해야 적용이 됩니다.</p>
	<div class="formContainer label130">
		<div class="form-group2">
			<div class="form-list">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_mobile_c.png">모바일 로고 등록</label></div>
				<div class="formCon">
					<?php
					$logo_mobile_c_path = G5_DATA_PATH.'/logo/logo_mobile_c.png';
					$logo_mobile_c_url = G5_DATA_URL.'/logo/logo_mobile_c.png';
					$upImg_logo_mobile_c = file_exists($logo_mobile_c_path) ? '<img src="'.get_url($logo_mobile_c_url).'"><label><input type="checkbox" name="del_logo_mobile_c" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_mobile_c" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_mobile_c.'</div>';
					?>
				</div>
			</div>
			<div class="form-list" style="background:rgba(0,0,0,0.07);">
				<div class="form-label"><label class="myTip" data-tip="data/logo/logo_mobile_w.png">모바일 로고 등록(흰색)</label></div>
				<div class="formCon">
					<?php
					$logo_mobile_w_path = G5_DATA_PATH.'/logo/logo_mobile_w.png';
					$logo_mobile_w_url = G5_DATA_URL.'/logo/logo_mobile_w.png';
					$upImg_logo_mobile_w = file_exists($logo_mobile_w_path) ? '<img src="'.get_url($logo_mobile_w_url).'"><label><input type="checkbox" name="del_logo_mobile_w" value="1">삭제</label>' : '';
					echo '<input type="file" name="logo_mobile_w" class="myfile">';
					echo '<div class="upImg">'.$upImg_logo_mobile_w.'</div>';
					?>
				</div>
			</div>
		</div>			
	</div>
</section>

<section id="header_topSection" class="mybox blue">
	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><label>헤더(상단) 배경색</label></div>
			<div class="formCon">	
				<input type="text" name="cfm_top_bg[0]" value="<?=get_text($cfm_top_bg[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#">
				<input type="checkbox" name="cfm_top_bg[1]" value="1" <?=$cfm_top_bg[1]?'checked':'';?> data-label="흰색로고 & 흰색 텍스트 사용" data-class="ml25">
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
	opener.$('#navContainer .menuCloser, .quickNews_closer').click();
}, 500 );
</script>