<?php
$sub_menu = "300900";
include_once('./_common.php');
auth_check($auth[$sub_menu], 'r');

if ($is_admin != 'super')
    alert('최고관리자만 접근 가능합니다.');

$g5['title'] = '게시판 기본 스타일';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$title_style = explode("|",$bo_style['title_style']);
$btn_write_style = explode("|",$bo_style['btn_write_style']);
$btn_pager_style = explode("|",$bo_style['btn_pager_style']);

$bo_title_root = '';
if($title_style[1]) $bo_title_root .= '--font-size:'.$title_style[1].'px;';
if($title_style[2]) $bo_title_root .= '--font-color:'.$title_style[2].';';
if($title_style[3]) $bo_title_root .= 'margin-bottom:'.$title_style[3].'px;';

$bo_btnSet_root = '';
if($btn_write_style[0]) $bo_btnSet_root .= '--font-size:'.$btn_write_style[0].'px;';
if($btn_write_style[1]) $bo_btnSet_root .= '--btn-width:'.$btn_write_style[1].'px;';
if($btn_write_style[2]) $bo_btnSet_root .= '--btn-height:'.$btn_write_style[2].'px;';
if($btn_write_style[3]) $bo_btnSet_root .= '--btnColor:'.$btn_write_style[3].';';
if($btn_write_style[4]) $bo_btnSet_root .= '--btnColor-hover:'.$btn_write_style[4].';';

$pg_wrap_root = '';
if($btn_pager_style[0]) $pg_wrap_root .= '--btn-size:'.$btn_pager_style[0].'px;';
if($btn_pager_style[1]) $pg_wrap_root .= '--btn-gap:'.$btn_pager_style[1].'px;';
if($btn_pager_style[1]!='' && $btn_pager_style[1]==0) $pg_wrap_root .=  '--btn-gap:'.$btn_pager_style[1].'px;';
if($btn_pager_style[2]) $pg_wrap_root .= '--btn-radius:'.$btn_pager_style[2].'px;';
if($btn_pager_style[3]) $pg_wrap_root .= '--btnColor-active:'.$btn_pager_style[3].';';
?>

<style>
<?php
$cf_default_style = explode("|",$config['cf_default_style']);
if($cf_default_style[1]) echo '.boStyle-preview{--mainColor:'.$cf_default_style[1].';}';
if($cf_default_style[2]) echo '.boStyle-preview{--subColor:'.$cf_default_style[2].';}';
?>
</style>

<form name="bo_style_form" id="bo_style_form" method="post" action="./board_style_update.php" onsubmit="return fbostyleform_submit(this);" autocomplete="off">
<input type="hidden" name="token" value="" id="token">

<?php include_once (G5_ADMIN_PATH.'/my/board_style_form.php'); ?>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function bo_style_form_submit(f) {
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>
