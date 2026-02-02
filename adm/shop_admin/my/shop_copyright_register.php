<?php
$sub_menu = "110400";
include_once('./_common.php');
include_once(G5_EDITOR_LIB);

auth_check($auth[$sub_menu], 'r');

$g5['title'] = '쇼핑몰 카피라이트 등록';
include_once (G5_ADMIN_PATH.'/admin.head.php');

$shop_ft_background = explode('|', $footer['shop_ft_background']);

for($i=1; $i<=5; $i++) {
	$footer_menu[$i] = explode('|', $footer['footer_menu'.$i]);
}

$_filemake_type = 'shop_footer';
include_once(G5_BBS_PATH.'/my/filemake_script.php');

if(file_exists(G5_THEME_PATH.'/adm/_shop_copyright_register.php')) {
	require_once(G5_THEME_PATH.'/adm/_shop_copyright_register.php');
    return;
}
?>

<form name="adm_form" id="adm_form" method="post" action="./shop_copyright_register_update.php" onsubmit="return adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">

<section class="mybox">
	<h2 class="mybox-title">쇼핑몰 카피라이트 관리</h2>
		
	<div class="formContainer label150">
		<div class="form-list">
			<div class="form-label"><label>관리 선택</label></div>
			<div class="formCon">
				<input type="checkbox"name="shop_ft_inc" value="1" class="toggle-light" id="shop_ft_inc" <?=$footer['shop_ft_inc']?'checked':'';?> data-class="w-90" data-on="파일로드" data-off="직접등록">
			</div>
			<script>matchOnOff_checkbox('#shop_ft_inc', '.inc-info', '.copyright_wr', 'visibility');</script>
		</div>
		<div class="form-list inc-info">
			<div class="form-label"><label>인크루드 경로</label></div>
			<div class="formCon">
				<?php
				$inc_shop_footer = G5_THIS_PATH.'/shop_footer.php';
				$inc_shop_footer_class = file_exists($inc_shop_footer) ? 'active' : '';
				?>
				<ul class="stbox column span70">
					<li>
						<span class="bl bin fileMake <?=$inc_shop_footer_class?>" data-filepath="<?=$inc_shop_footer?>">footer</span>
						<span class="fileDelete" data-filepath="<?=$inc_shop_footer?>">삭제</span>
						<span class="text"><?=G5_THIS_DIR?>/<b>shop_footer.php</b></span>
					</li>
				</ul>
			</div>
		</div>
		<div class="form-list copyright_wr">
			<div class="form-label"><label>카피라이트 내용</label></div>
			<div class="formCon">
				<?php echo editor_html("shop_copyright", get_text(html_purifier($footer['shop_copyright']), 0), true, 300); ?>
			</div>
		</div>
		<div class="form-list copyright_wr">
			<div class="form-label"><label>카피라이트 메뉴</label><span id="add-list" class="_btn/mini/blue/rd10 ml10">추가</span></div>
			<div class="formCon">
				<ul id="shop_footer_menu">
					<?php
					echo '<li>';
					echo '<input type="text" name="footer_menu1[]" value="'.$footer_menu[1][0].'" class="w-160" data-label="메뉴명">';
					echo '<input type="text" name="footer_menu1[]" value="'.$footer_menu[1][1].'" class="w-full" data-class="flex1" data-label="링크" placeholder="https://">';
					echo '</li>';
					for($i=2; $i<=5; $i++) {
						if($footer_menu[$i][0]) {
							echo '<li>';
							echo '<input type="text" name="footer_menu'.$i.'[]" value="'.get_text($footer_menu[$i][0]).'" class="w-160" data-label="메뉴명">';
							echo '<input type="text" name="footer_menu'.$i.'[]" value="'.get_text($footer_menu[$i][1]).'" class="w-full" data-class="flex1" data-label="링크" placeholder="https://">';
							echo '<span class="_btn/mini/gray del-list">삭제</span>';
							echo '</li>';
						}
					} ?>
				</ul>
			</div>
		</div>
		<div class="form-list copyright_wr">
			<div class="form-label"><label>카피라이트 컬러</label></div>
			<div class="formCon">
				<div class="flex flex-middle gap15">
					<input type="text" name="shop_ft_background[]" value="<?=get_text($shop_ft_background[0])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="배경 컬러">
					<input type="text" name="shop_ft_background[]" value="<?=get_text($shop_ft_background[1])?>" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="<?=$swathColor?>" placeholder="#" data-label="텍스트 컬러">
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
$(function() {
	$(document).on("click", "#add-list", function() {
		add_list();
	});

	$(document).on("click", ".del-list", function() {
		var $li = $(this).closest("li");
		$li.remove();        
	});
});
function add_list() {
	var $ul = $("#shop_footer_menu");
	var toCount = $("#shop_footer_menu li").length + 1;
	if(toCount >= 6) {
		alert('5개까지 추가 가능합니다.');
		return false;
	}
	var list = '<li>';
	list += '<label class="labelInput"><span class="label">메뉴명</span><input type="text" name="footer_menu'+toCount+'[]" value="" class="w-160"></label>';
	list += '<label class="labelInput flex1"><span class="label">링크</span><input type="text" name="footer_menu'+toCount+'[]" value="" class="w-full" placeholder="https://"></label>';
	list += '<span class="_btn/mini/gray del-list">삭제</span>';
	list += '</li>';
	$ul.append(list);
	
}
</script>

<script>
function adm_form_submit(f) {
	<?php echo get_editor_js("shop_copyright"); ?>
    return true;
}
</script>

<?php include_once (G5_ADMIN_PATH.'/admin.tail.php'); ?>