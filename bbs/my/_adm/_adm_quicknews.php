<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_adm_quicknews_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="bo_table" value="<?=$bo_table?>" id="bo_table">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<?php include_once (G5_ADMIN_PATH.'/my/quick_news_form.php'); ?>

<div class="_adm_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
setTimeout(function() {
	opener.$('.quickNews_opener').click();
}, 1200 );
</script>