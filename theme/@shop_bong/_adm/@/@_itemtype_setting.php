<?php
if (!defined('_GNUBOARD_')) exit;

$shop_header_color = explode("|", $default['shop_header_color']);

//상품유형
$itemtype = explode("|", $default['itemtype']);
if(!$itemtype[0] && !$itemtype[1] && !$itemtype[2] && !$itemtype[3] && !$itemtype[4]) $itemtype = false;
?>

<form name="_adm_form" method="post" action="<?=$_adm_update_url?>/_itemtype_setting_update.php" onsubmit="return _adm_form_submit(this);" autocomplete="off" enctype="multipart/form-data">
<input type="hidden" name="token" value="" id="token">
<input type="hidden" name="callback_url" value="<?=$callback_url?>">

<section class="mt20 mybox blue">
	<div class="formContainer label100">
		<div class="form-list">
			<div class="form-label"><label>상품유형</label></div>
			<div class="formCon column">
				<p class="help-block" style="line-height:1.6em">상품 등록시에 상품의 유형을 구분하는 옵션으로, 상단메뉴에도 사용할 수 있습니다.<br>예시) <span class="color-black bold">베스트, 신상품, 추천, 할인/이벤트</span> - 메인메뉴에 사용할때 (/)로 구분된 유형은 롤링 텍스트로 출력합니다.<br><span class="color-red bold">※ 상단메뉴 설정 이후 또는 상품 등록 이후라면 상품유형의 수정시 주의하십시오.</span></p>
				<?php for ($t=0; $t < 5; $t++) {
					$num = $t + 1;
					echo '<input type="text" name="itemtype[]" value="'.$itemtype[$t].'" class="frm_input w-100" size="70" data-class="w-250" data-label="타입'.$num.'">';
				} ?>
			</div>
		</div>	
	</div>
</section>	

<div class="bo_btnSet">
	<input type="submit" value="적용하기" class="btn_submit btn" accesskey="s">
</div>
</form>