<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<form name="_adm_form" id="_adm_form" action="<?=$_adm_update_url?>/_shop_banner_category_update.php" onsubmit="return _adm_form_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">


<section class="mybox blue">

	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>블럭용 배너 분류</label></div>
			<div class="formCon">
				<input type="text" name="shop_banner_category" value="<?=$default['shop_banner_category']?>" class="w-full" placeholder="예시) 이벤트배너|공지배너">
				<p class="help-block mt5">분류와 분류 사이는 | 로 구분하세요.</p>
			</div>
		</div>	
	</div>

</section>

 <div class="_adm_btnSet">
	<input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>