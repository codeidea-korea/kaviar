<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(file_exists(G5_THIS_PATH.'/member/register.skin.php')) {
	require_once(G5_THIS_PATH.'/member/register.skin.php');
	return;
} else if(defined('G5_THEME_PATH') && file_exists(G5_THEME_PATH.'/member/register.skin.php')) {
	require_once(G5_THEME_PATH.'/member/register.skin.php');
	return;
}
?>

<form name="fregister" id="fregister" action="<?php echo $register_action_url ?>" onsubmit="return fregister_submit(this);" method="POST" autocomplete="off">

<div class="mb100 fs14 max-width sm:p15" style="max-width:900px">
	<h2 id="_page_title">회원가입</h2>

	<div class="textbox h-auto fs13 fw500">
		회원가입약관 및 개인정보처리방침안내의 내용에 동의하셔야<br>
		회원가입 하실 수 있습니다.
	</div>
	
	<?php if($config['cf_stipulation_label'] || $config['cf_privacy_label'] || $config['cf_terms_label']) { ?>
	<div class="py20 border-bottom">
		<label class="checkbox-label fw500"><input type="checkbox" name="chk_all" class="chkall" data-group="chk1"><span></span>회원가입 약관에 모두 동의합니다.</label>
	</div>
	<?php } ?>
	
	<?php if($config['cf_stipulation_label']) { ?>
	<div class="mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree" value="1" class="chk1"><span></span><?=$config['cf_stipulation_label']?> (필수)</label>
		<div class="textbox h-135 fs13 color-gray2 mt15">
			<?php echo nl2br($config['cf_stipulation']) ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if($config['cf_privacy_label']) { ?>
	<div class="mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree2" value="1" class="chk1"><span></span><?=$config['cf_privacy_label']?> (필수)</label>
		<div class="textbox h-135 fs13 color-gray2 mt15">
			<?php echo nl2br($config['cf_privacy']) ?>
		</div>
	</div>
	<?php } ?>
	
	<?php if($config['cf_terms_label']) { ?>
	<div class="mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree3" value="1" class="chk1"><span></span><?=$config['cf_terms_label']?> (필수)</label>
		<div class="textbox h-135 fs13 color-gray2 mt15">
			<?php echo nl2br($config['cf_terms']) ?>
		</div>
	</div>
	<?php } ?>
	
	<div class="mt20">
		<label class="checkbox-label fw500"><input type="checkbox" name="agree4" value="1" class="chk1"><span></span>만 14세 이상입니다. (필수)</label>
	</div>

	<div class="mt20">
		<label class="checkbox-label fw500 flex-top"><input type="checkbox" name="agree5" value="1" class="chk1"><span></span>
			이메일 및 SMS 마케팅 정보 수신에 동의합니다.<br>
			회원은 언제든지 회원 정보에서 수신 거부로 변경할 수<br>
			있습니다. (선택)
		</label>
	</div>
	
	<div class="btnSet mt50 tcenter">
		<button type="submit" class="_btn/lg/mainColor w-full" style="max-width:260px">다음</button>
	</div>
</div>


</form>
<script>
function fregister_submit(f)
{	
	<?php if($config['cf_stipulation_label']) { ?>
	if (!f.agree.checked) {
		alert("<?=$config['cf_stipulation_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree.focus();
		return false;
	}
	<?php } ?>
	
	<?php if($config['cf_privacy_label']) { ?>
	if (!f.agree2.checked) {
		alert("<?=$config['cf_privacy_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree2.focus();
		return false;
	}
	<?php } ?>

	<?php if($config['cf_terms_label']) { ?>
	if (!f.agree3.checked) {
		alert("<?=$config['cf_terms_label']?>의 내용에 동의하셔야 회원가입 하실 수 있습니다.");
		f.agree3.focus();
		return false;
	}
	<?php } ?>

	if (!f.agree4.checked) {
		alert("만 14세 이상만 회원가입 하실 수 있습니다.");
		f.agree4.focus();
		return false;
	}

	return true;
}

jQuery(function($){
	// 모두선택
	$("input[name=chk_all2]").click(function() {
		if ($(this).prop('checked')) {
			$("input[name^=agree]").prop('checked', true);
		} else {
			$("input[name^=agree]").prop("checked", false);
		}
	});
});
</script>
