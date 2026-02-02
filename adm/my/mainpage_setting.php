<?php
$sub_menu = "110500";
include_once('./_common.php');

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '메인페이지 설정';
include_once (G5_ADMIN_PATH.'/admin.head.php');
?>

<style>
.tbl_frm01 table td{border-color:rgba(0,0,0,0.15);}
</style>

<form name="adm_form" id="adm_form" method="post" onsubmit="return adm_form_submit(this);">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
    <h2 class="mybox-title">메인페이지 관리</h2>

	<div class="formContainer label180">
		<div class="local_desc02 local_desc mb20">
			<b>pageMake</b>스킨으로 생성한 게시판중 메인에 적용할 게시판을 선택할 수 있습니다.
		</div>

		<div class="form-list <?=$config['cf_main_table']?"use":"noUse";?>">
			<div class="form-label"><label>메인페이지에 적용 게시판</span></div>
			<div class="formCon">
				<?php echo get_board_select_my('cf_main_table', $config['cf_main_table'], 'class="selectpicker span300"', 'pageMake', 'subject'); ?>
				<?php if($config['cf_main_table']) echo '<a href="'.G5_BBS_URL.'/board.php?bo_table='.$config['cf_main_table'].'" target="_blank" class="btn_frmline">게시판 바로가기</a>';?>
			</div>
        </div>
        <div class="form-list <?=$config['cf_main_table']?"use":"noUse";?>">
			<div class="form-label"><label>메인페이지 URL</span></div>
			<div class="formCon">
				<p class="help-block mb5">URL입력시, <b>기존 적용한 게시판은 사용하지 않고,</b> 입력한 URL페이지를 메인으로 사용합니다.</p>
				<input type="text" name="cf_main_url" value="<?=$config['cf_main_url']?>" id="cf_main_url" class="frm_input" size="130" maxlength="120" placeholder="http://">
			</div>
        </div>
    </div>
	
</section>

<div class="btn_fixed_top btn_confirm">
    <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f)
{
    f.action = "./mainpage_setting_update.php";
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>
