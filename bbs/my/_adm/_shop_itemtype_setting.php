<?php
if (!defined('_GNUBOARD_')) exit;

$shop_header_color = explode("|", $default['shop_header_color']);

//상품유형
$itemtype = explode("|", $default['itemtype']);
$itemtype_color = explode("|", $default['itemtype_color']);
if(!$itemtype[0] && !$itemtype[1] && !$itemtype[2] && !$itemtype[3] && !$itemtype[4]) $itemtype = false;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_shop_itemtype_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>상품유형</label></div>
			<div class="formCon column">
				<p class="help-block" style="line-height:1.6em">
					상품 등록시에 상품의 유형을 구분하는 옵션으로, 상단메뉴에도 사용할 수 있습니다.<br>
					예시) <span class="color-black bold">베스트, 신상품, 추천, 할인/이벤트</span> - 메인메뉴에 사용할때 (/)로 구분된 유형은 롤링 텍스트로 출력합니다.<br>
					각 타입의 컬러는 상품상세 페이지에서 상품이 속한 유형을 TAG형식으로 출력할때 TAG의 색상을 나타냅니다.<br>
					<span class="color-red bold">※ 상단메뉴 설정 이후 또는 상품 등록 이후라면 상품유형의 수정시 주의하십시오.</span>
				</p>
				<?php for ($t=0; $t < 10; $t++) {
					$num = $t + 1;
					echo '<div class="flex flex-middle">';
						echo '<input type="text" name="itemtype[]" value="'.$itemtype[$t].'" class="frm_input w-100" size="70" data-class="w-250" data-label="타입'.$num.'">';
						echo '<label class="labelColor-hidden"><input type="text" name="itemtype_color[]" value="'.$itemtype_color[$t].'" class="colorpicker" data-format="rgb" data-opacity="1" data-swatches="'.$swathColor.'" placeholder="#"></label>';
					echo '</div>';
				} ?>
			</div>
		</div>	
	</div>
</section>	

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>