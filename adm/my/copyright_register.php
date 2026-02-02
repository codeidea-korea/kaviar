<?php
$sub_menu = "110400";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '카피라이트 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$ft_background = explode("|", $footer['ft_background']);

$_filemake_type = 'footer';
include_once(G5_BBS_PATH.'/my/filemake_script.php');

if(file_exists(G5_THEME_PATH.'/adm/_copyright_register.php')) {
	require_once(G5_THEME_PATH.'/adm/_copyright_register.php');
    return;
}
?>

<form name="adm_form" id="adm_form" method="post" action="./copyright_register_update.php" onsubmit="return adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
	<h2 class="mybox-title">카피라이트 관리</h2>
	
	<div class="formContainer label130">
		<div class="form-list">
			<div class="form-label"><label>관리 선택</label></div>
			<div class="formCon">
				<input type="checkbox"name="ft_inc" value="1" class="toggle-light" id="ft_inc" <?=$footer['ft_inc']?'checked':'';?> data-class="w-90" data-on="파일로드" data-off="직접등록">
			</div>
			<script>matchOnOff_checkbox('#ft_inc', '.inc-info', '.copyright_wr', 'visibility');</script>		
		</div>
		<div class="form-list inc-info">
			<div class="form-label"><label>인크루드 경로</label></div>
			<div class="formCon">
				<?php
				$inc_footer = G5_THIS_PATH.'/footer.php';
				$inc_footer_class = file_exists($inc_footer) ? 'active' : '';
				?>
				<ul class="stbox column span70">
					<li>
						<span class="bl bin fileMake <?=$inc_footer_class?>" data-filepath="<?=$inc_footer?>">footer</span>
						<span class="fileDelete" data-filepath="<?=$inc_footer?>">삭제</span>
						<span class="text"><?=G5_THIS_DIR?>/<b>footer.php</b></span>
					</li>
				</ul>
			</div>
		</div>
		<div class="form-list copyright_wr">
			<div class="form-label"><label>카피라이트 내용</label></div>
			<div class="formCon">
				<div class="wrConBox">
					<ul class="wrConTabs">
						<li class="active icon_pc" data-target="pcCon" title="데스크탑"></li>
						<li class="icon_mobile" data-target="mobileCon" title="모바일"></li>
					</ul>
					<div class="tabEditor pcCon active">
						<?php echo editor_html("copyright", get_text(html_purifier($footer['copyright']), 0), true, 300); ?>
					</div>
					<div class="tabEditor mobileCon">
						<?php echo editor_html("copyright_mobile", get_text(html_purifier($footer['copyright_mobile']), 0), true, 300); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="form-list copyright_wr">
			<div class="form-label"><label>컬러 지정</label></div>
			<div class="formCon">
				<div class="flex flex-middle gap15">
					<input type="text" name="ft_background[]" value="<?=get_text($ft_background[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="배경 컬러">
					<input type="text" name="ft_background[]" value="<?=get_text($ft_background[1])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="텍스트 컬러">
				</div>
			</div>
		</div>
	</div>
</section>

<div class="btn_fixed_top">
    <input type="submit" value="확인" class="btn btn_submit" accesskey="s">
</div>

</form>

<script>
function adm_form_submit(f) {
	<?php echo get_editor_js("copyright"); ?>
    <?php echo get_editor_js("copyright_mobile"); ?>
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>