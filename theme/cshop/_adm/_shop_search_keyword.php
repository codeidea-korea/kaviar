<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>


<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_search_keyword_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mybox blue">
	<div class="formContainer label190">		
		<div class="form-list">
			<div class="form-label"><label>쇼핑몰 추천검색어</label></div>
			<div class="formCon">
				<input type="text" name="cf_search_keyword" value="<?=$config['cf_search_keyword']?>" class="w-full" size="255" placeholder="예시) 공지사항, 갤러리">
			</div>
		</div>
		
	</div>	
</section>

<div class="_adm_btnSet">
	<input type="submit" value="저장하기" class="btn_submit btn" accesskey="s">
</div>

</form>