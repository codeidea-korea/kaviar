<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
echo '<link rel="stylesheet" href="'.get_url($member_skin_url.'/'.$css).'">';
?>

<div class="flexCenter/absolute mobile-max-width" style="background:#f8f7f7;">

	<div class="passCheck">
		<div class="title">
			가입코드를 입력해주세요.<br/>
			<span class="msg">가입코드 분실시 관리자에게 문의하십시오.</span>
		</div>		
		<form  name="fjoincode" id="fregister" action="<?=$join_action_url?>" onsubmit="return fjoincode_submit(this);" method="POST" autocomplete="off">
		<fieldset class="mt20">	
			<input type="text" name="join_code" id="" required class="w-full noto600" size="15" maxLength="20" placeholder="가입코드를 입력해주세요.">
			<input type="submit" value="확인" id="btn_submit" class="_btn/md w-full">
		</fieldset>
		</form>
		<div class="tcenter mt40">
			<a href="<?=G5_URL?>" class="fs13 text-hover">메인으로 돌아가기</a>
		</div>
	</div>

</div>


<script>
function fjoincode_submit(f)
{
	if (f.join_code == '') {
		alert("코드를 입력하세요.");
		f.join_code.focus();
		return false;
	}
}
</script>