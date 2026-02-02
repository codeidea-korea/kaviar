<?php
$sub_menu = "130100";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '퀵뉴스 관리';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>


<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);" autocomplete="off" action="<?=G5_ADMIN_URL?>/my/quick_news_update.php" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<?php include_once (G5_ADMIN_PATH.'/my/quick_news_form.php'); ?>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f) {
    return true;
}
</script>


<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>